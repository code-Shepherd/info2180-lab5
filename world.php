<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    // Establish database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if 'country' is set in the GET request and sanitize it
    $country = isset($_GET['country']) ? $_GET['country'] : '';

    if (!empty($country)) {
        // Prepare the SQL query with a WHERE clause to filter by country
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->bindValue(':country', "%" . $country . "%", PDO::PARAM_STR);
    } else {
        // If no country is provided, fetch all countries
        $stmt = $conn->query("SELECT * FROM countries");
    }

    // Execute the query
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<ul>
<?php if (!empty($results)): ?>
    <?php foreach ($results as $row): ?>
        <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
    <?php endforeach; ?>
<?php else: ?>
    <li>No results found for this country.</li>
<?php endif; ?>
</ul>
