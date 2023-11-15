<?php

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// Allow requests from any origin, you can specify specific origins if needed
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); // Adjust content type as needed

// Get the country name from the GET request, default to an empty string if not provided
$countryName = isset($_GET['country']) ? $_GET['country'] : '';

// Check if the "lookup" parameter is set to "cities"
$lookupCities = isset($_GET['lookup']) && $_GET['lookup'] === 'cities';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    if ($lookupCities) {
        // If looking up cities, retrieve city information
        $stmt = $conn->prepare("SELECT cities.name AS city, cities.district, cities.population FROM cities 
                               JOIN countries ON cities.country_code = countries.code 
                               WHERE countries.name = :country");
    } else {
        // If not looking up cities, retrieve country information
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    }

    $stmt->bindParam(':country', $countryName, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //echo json_encode(['data' => $results]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit(); // Terminate script if an error occurs
}
?>

<?php if ($lookupCities): ?>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>District</th>
            <th>Population</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= $row['city']; ?></td>
                <td><?= $row['district']; ?></td>
                <td><?= $row['population']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <!-- Display country information as before -->
    <table border="1">
        <tr>
            <th>Country Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= $row['name']; ?></td>
                <td><?= $row['continent']; ?></td>
                <td><?= $row['independence_year']; ?></td>
                <td><?= $row['head_of_state']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
