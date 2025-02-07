<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store education data
    $educations = [];

    // Extract education data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $educations[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting education data
    $stmt = $pdo->prepare("INSERT INTO qualification (faculty_id, degree, University_institution, specialization, year_of_passing) 
                           VALUES (:faculty_id, :degree, :university_institution, :specialization, :year_of_passing)");

    // Loop through each education and execute the insert statement
    foreach ($educations as $education) {
        $stmt->execute([
            ':faculty_id' => $education['faculty_id'],
            ':degree' => $education['degree'],
            ':University_institution' => $education['university'],
            ':specialization' => $education['specialization'],
            ':year_of_passing' => $education['year_of_passing']
        ]);
    }

    echo "Education records saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

