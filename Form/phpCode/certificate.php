<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store certificate data
    $certificates = [];

    // Extract certificate data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $certificates[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting certificate data
    $stmt = $pdo->prepare("INSERT INTO certificates (faculty_id, certification_on, source, year) 
                          VALUES (:faculty_id, :certification_on, :source, :year)");

    // Loop through each certificate and execute the insert statement
    foreach ($certificates as $certificate) {
        $stmt->execute([
            ':faculty_id' => $certificate['faculty_id'],
            ':certification_on' => $certificate['certification_on'],
            ':source' => $certificate['source'],
            ':year' => $certificate['year']
        ]);
    }

    echo "Certificate data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>