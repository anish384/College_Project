<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store conference data
    $conferences = [];

    // Extract conference data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $conferences[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting conference data
    $stmt = $pdo->prepare("INSERT INTO fdp_conferences_attended (faculty_id, Topic, Organizer, no_of_days, Place, Year) 
                           VALUES (:faculty_id, :Topic, :Organizer, :no_of_days, :Place, :Year)");

    // Loop through each conference and execute the insert statement
    foreach ($conferences as $conference) {
        $stmt->execute([
            ':faculty_id' => $conference['faculty_id'],
            ':Topic' => $conference['topic'],
            ':Organizer' => $conference['organizer'],
            ':no_of_days' => $conference['noofdays'],
            ':Place' => $conference['place'],
            ':Year' => $conference['year']
        ]);
    }

    echo "Conference data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

