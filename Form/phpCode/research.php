<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store research project data
    $researchProjects = [];

    // Extract research project data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $researchProjects[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting research project data
    $stmt = $pdo->prepare("INSERT INTO research_grants (faculty_id, research_title, funding_organization, amount, year) 
                           VALUES (:faculty_id, :research_title, :funding_organization, :amount, :year)");

    // Loop through each research project and execute the insert statement
    foreach ($researchProjects as $research) {
        $stmt->execute([
            ':faculty_id' => $research['faculty_id'],
            ':research_title' => $research['research_title'],
            ':funding_organization' => $research['funding_organization'],
            ':amount' => $research['amount'],
            ':year' => $research['year']
        ]);
    }

    echo "Research project records saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

