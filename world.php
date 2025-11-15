<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$country = isset($_GET["country"]) ? $_GET["country"] : "";
$lookup  = isset($_GET["lookup"]) ? $_GET["lookup"] : "countries";

/* ============================================================
    CITIES LOOKUP
    ============================================================ */
if ($lookup === "cities" && $country !== "") {

    $stmt = $conn->prepare("
        SELECT cities.name, cities.district, cities.population
        FROM cities
        JOIN countries ON cities.country_code = countries.code
        WHERE countries.name LIKE :country
    ");

    $search = "%$country%";
    $stmt->bindParam(':country', $search, PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) === 0) {
        echo "<p>No cities found.</p>";
        exit;
    }

    echo "<table border='1' cellpadding='6' cellspacing='0'>
            <tr>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>";

    foreach ($results as $row) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['district']}</td>
                <td>{$row['population']}</td>
              </tr>";
    }

    echo "</table>";
    exit;
}

/* ============================================================
    COUNTRIES LOOKUP (DEFAULT)
    ============================================================ */
if ($country !== "") {

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

if (count($results) === 0) {
    echo "<p>No countries found.</p>";
    exit;
}

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
?>
