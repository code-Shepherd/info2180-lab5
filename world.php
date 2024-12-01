<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get country from the GET request
    $country = isset($_GET['country']) ? $_GET['country'] : '';
    $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : 'country'; // Default to 'country'

    if ($lookup === 'cities' && !empty($country)) {
        // Query for cities in the country with Name, District, and Population
        $stmt = $conn->prepare("SELECT city.name, city.district, city.population FROM cities AS city JOIN countries AS c ON city.country_code = c.code WHERE c.name LIKE :country");
        $stmt->bindValue(':country', "%" . $country . "%", PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output table for cities
        echo '<table>';
        echo '<thead><tr><th>City Name</th><th>District</th><th>Population</th></tr></thead><tbody>';
        if (!empty($results)) {
            foreach ($results as $row) {
                echo '<tr><td>' . htmlspecialchars($row['name']) . '</td><td>' . htmlspecialchars($row['district']) . '</td><td>' . htmlspecialchars($row['population']) . '</td></tr>';
            }
        } else {
            echo '<tr><td colspan="3">No cities found for this country.</td></tr>';
        }
        echo '</tbody></table>';
    } else {
        // Query for country information
        $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
        $stmt->bindValue(':country', "%" . $country . "%", PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output table for country information
        echo '<table>';
        echo '<thead><tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead><tbody>';
        if (!empty($results)) {
            foreach ($results as $row) {
                echo '<tr><td>' . htmlspecialchars($row['name']) . '</td><td>' . htmlspecialchars($row['continent']) . '</td><td>' . htmlspecialchars($row['independence_year']) . '</td><td>' . htmlspecialchars($row['head_of_state']) . '</td></tr>';
            }
        } else {
            echo '<tr><td colspan="4">No results found for this country.</td></tr>';
        }
        echo '</tbody></table>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
