<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store organization data
    $organizations = [];

    // Extract organization data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $organizations[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting organization data
    $stmt = $pdo->prepare("INSERT INTO professional_memberships(faculty_id, organization, member_category, since) 
                           VALUES (:faculty_id, :organization, :member_category, :since)");

    // Loop through each organization and execute the insert statement
    foreach ($organizations as $organization) {
        $stmt->execute([
            ':faculty_id' => $organization['faculty_id'],
            ':organization' => $organization['organization'],
            ':member_category' => $organization['member_category'],
            ':since' => $organization['since']
        ]);
    }

    echo "Organization data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

