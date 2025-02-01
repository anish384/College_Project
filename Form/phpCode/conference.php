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
    $stmt = $pdo->prepare("INSERT INTO conference (faculty_id, Title, Name_of_the_Conference, International_National, publisher, place, year, website_link, author_type, remarks) 
                           VALUES (:faculty_id, :Title, :Name_of_the_Conference, :International_National, :publisher, :place, :year, :website_link, :author_type, :remarks)");

    // Loop through each conference and execute the insert statement
    foreach ($conferences as $conference) {
        $year = !empty($conference['year']) ? (int)$conference['year'] : null;
        $stmt->execute([
            ':faculty_id' => $conference['faculty_id'],
            ':Title' => $conference['Title'],
            ':Name_of_the_Conference' => $conference['Name_of_conf'],
            ':International_National' => $conference['int_nat'],
            ':publisher' => $conference['publisher'],
            ':place' => $conference['place'],
            ':year' => $year,
            ':website_link' => $conference['website_link'],
            ':author_type' => $conference['author_type'],
            ':remarks' => $conference['remarks']
        ]);
    }

    echo "Conference data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

