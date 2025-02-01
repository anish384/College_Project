<<<<<<< HEAD
<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store chair/resource data
    $chairResources = [];

    // Extract chair/resource data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $chairResources[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting chair/resource data
    $stmt = $pdo->prepare("INSERT INTO chair_resource (faculty_id, Organization, Chair_Resource, Place, Year) VALUES (:faculty_id, :organization, :chair_resource, :place, :year)");

    // Loop through each chair/resource and execute the insert statement
    foreach ($chairResources as $resource) {
        $year = !empty($resource['year_chair_resource']) ? (int)$resource['year_chair_resource'] : null;
        $stmt->execute([
            ':faculty_id' => $resource['faculty_id'],
            ':organization' => $resource['Organization'],
            ':chair_resource' => $resource['Chair_resource'],
            ':place' => $resource['Place'],
            ':year' => $year
        ]);
    }

    echo "Chair/Resource data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
=======
<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store chair/resource data
    $chairResources = [];

    // Extract chair/resource data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $chairResources[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting chair/resource data
    $stmt = $pdo->prepare("INSERT INTO chair_resource (faculty_id, Organization, Chair_Resource, Place, Year) VALUES (:faculty_id, :organization, :chair_resource, :place, :year)");

    // Loop through each chair/resource and execute the insert statement
    foreach ($chairResources as $resource) {
        $year = !empty($resource['year_chair_resource']) ? (int)$resource['year_chair_resource'] : null;
        $stmt->execute([
            ':faculty_id' => $resource['faculty_id'],
            ':organization' => $resource['Organization'],
            ':chair_resource' => $resource['Chair_resource'],
            ':place' => $resource['Place'],
            ':year' => $year
        ]);
    }

    echo "Chair/Resource data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
>>>>>>> dd84abaed9d4712d03bb49a3b31e5bea4f119281
?>