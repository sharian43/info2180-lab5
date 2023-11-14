function lookupCountry() {
    var countryInput = document.getElementById('country').value;

    var xhr = new XMLHttpRequest();

    xhr.open('GET', 'world.php?country=' + encodeURIComponent(countryInput), true);

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
