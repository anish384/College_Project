<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store journal data
    $journals = [];

    // Extract journal data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $journals[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting journal data
    $stmt = $pdo->prepare("INSERT INTO mtech_guided (faculty_id, year, college_university) 
                           VALUES (:faculty_id, :year, :college_or_university)");

    // Loop through each journal and execute the insert statement
    foreach ($journals as $journal) {
        $stmt->execute([
            ':faculty_id' => $journal['faculty_id'],
            ':year' => $journal['year'],
            ':college_or_university' => $journal['college_or_university']
        ]);
    }

    echo "Journal data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

