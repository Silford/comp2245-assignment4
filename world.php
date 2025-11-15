<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if (isset($_GET["country"]) && $_GET["country"] !== "") {
    $country = $_GET["country"];

    // Use LIKE for partial search
    $stmt = $conn->prepare("
        SELECT name, continent, independence_year, head_of_state
        FROM countries
        WHERE name LIKE :country
    ");

    $search = "%$country%";
    $stmt->bindParam(':country', $search, PDO::PARAM_STR);
    $stmt->execute();
} else {
    $stmt = $conn->query("
        SELECT name, continent, independence_year, head_of_state
        FROM countries
    ");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build table
echo "<table border='1' cellpadding='6' cellspacing='0'>
        <tr>
            <th>Country Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>";

foreach ($results as $row) {
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['continent']}</td>
            <td>{$row['independence_year']}</td>
            <td>{$row['head_of_state']}</td>
          </tr>";
}

echo "</table>";
