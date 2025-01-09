<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store experience data
    $experiences = [];

    // Extract experience data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $experiences[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting experience data
    $stmt = $pdo->prepare("INSERT INTO experience (faculty_id, industry, teaching, research) 
                           VALUES (:faculty_id, :industry, :teaching, :research)");

    // Loop through each experience and execute the insert statement
    foreach ($experiences as $experience) {
        $stmt->execute([
            ':faculty_id' => $experience['faculty_id'],
            ':industry' => $experience['industry'],
            ':teaching' => $experience['teaching'],
            ':research' => $experience['research']
        ]);
    }

    echo "Experience data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

