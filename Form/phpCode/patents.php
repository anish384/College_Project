<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store patent data
    $patents = [];

    // Extract patent data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $patents[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting patent data
    $stmt = $pdo->prepare("INSERT INTO patents (faculty_id, title, co_inventors, ip_pct, year_of_publication, status) 
                           VALUES (:faculty_id, :title, :co_inventors, :ip_pct, :year_of_publication, :status)");

    // Loop through each patent and execute the insert statement
    foreach ($patents as $patent) {
        $stmt->execute([
            ':faculty_id' => $patent['faculty_id'],
            ':title' => $patent['title'],
            ':co_inventors' => $patent['co_inventors'],
            ':ip_pct' => $patent['ip_pct'],
            ':year_of_publication' => $patent['year_of_publication'],
            ':status' => $patent['status']
        ]);
    }

    echo "Patent data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

