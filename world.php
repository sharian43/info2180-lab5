<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Get the country name from the GET request, default to an empty string if not provided
$countryName = isset($_GET['country']) ? '%' . $_GET['country'] . '%' : '';

// Use try-catch block to handle potential PDO exceptions
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Use prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindParam(':country', $countryName, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch results only if the query was successful
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit(); // Terminate script if an error occurs
}
?>

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
