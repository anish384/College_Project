<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store funding data
    $fundingSchemes = [];

    // Extract funding scheme data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $fundingSchemes[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting funding scheme data
    $stmt = $pdo->prepare("INSERT INTO research_grants_till_now(faculty_id, title, scheme, funding_organization, amount, year, status) 
                           VALUES (:faculty_id, :title, :scheme, :funding_organization, :amount, :year, :status)");

    // Loop through each funding scheme and execute the insert statement
    foreach ($fundingSchemes as $funding) {
        $stmt->execute([
            ':faculty_id' => $funding['faculty_id'],
            ':title' => $funding['title'],
            ':scheme' => $funding['scheme'],
            ':funding_organization' => $funding['funding_organization'],
            ':amount' => $funding['amount'],
            ':year' => $funding['year'],
            ':status' => $funding['status']
        ]);
    }

    echo "Funding scheme records saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

