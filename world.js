document.addEventListener('DOMContentLoaded', function () {

    function lookupCountry() {
        var countryInput = document.getElementById('country').value;
        fetchAndDisplayData('http://localhost/info2180-lab5/world.php?country=' + encodeURIComponent(countryInput));
    }

    function lookupCities() {
        var countryInput = document.getElementById('country').value;
        fetchAndDisplayData('http://localhost/info2180-lab5/world.php?country=' + encodeURIComponent(countryInput) + '&lookup=cities');
    }

    function fetchAndDisplayData(url) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                document.getElementById('result').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed with status', xhr.status);
            }
        };

        xhr.onerror = function () {
            console.error('Request failed');
        };

        xhr.send();
    }

    document.getElementById('lookup').addEventListener('click', lookupCountry);
    document.getElementById('lookupCities').addEventListener('click', lookupCities);
});
