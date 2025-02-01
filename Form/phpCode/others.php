<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store project data
    $projects = [];

    // Extract project data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $projects[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting project data
    $stmt = $pdo->prepare("INSERT INTO others(faculty_id, areas_of_interests, any_other_information) 
                           VALUES (:faculty_id, :areas_of_interests, :any_other_information)");

    // Loop through each project and execute the insert statement
    foreach ($projects as $project) {
        $stmt->execute([
            ':faculty_id' => $project['faculty_id'],
            ':areas_of_interests' => $project['areas_of_interests'],
            ':any_other_information' => $project['any_other_information'],
        ]);
    }

    echo "records saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>