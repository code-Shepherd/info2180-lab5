document.addEventListener("DOMContentLoaded", function () {
    const lookupButton = document.getElementById("lookup");
    const lookupCitiesButton = document.getElementById("lookup-cities");

    function fetchData(url) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const resultDiv = document.getElementById("result");
                resultDiv.innerHTML = xhr.responseText;
            }
        };

        xhr.send();
    }

    // Lookup Country Button
    lookupButton.addEventListener("click", function () {
        const countryInput = document.getElementById("country").value.trim();
        const url = `world.php?country=${encodeURIComponent(countryInput)}&lookup=country`;
        fetchData(url);
    });

    // Lookup Cities Button
    lookupCitiesButton.addEventListener("click", function () {
        const countryInput = document.getElementById("country").value.trim();
        const url = `world.php?country=${encodeURIComponent(countryInput)}&lookup=cities`;
        fetchData(url);
    });
});
