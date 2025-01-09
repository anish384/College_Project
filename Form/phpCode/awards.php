<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $awards[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO awards (faculty_id, name_of_award, Organizer, Place, Year) VALUES (:faculty_id, :name_of_award, :organizer, :place, :year)");
    
    foreach ($awards as $award) {
        $year = !empty($award['year']) ? (int)$award['year'] : null;
        $stmt->execute([
            ':faculty_id' => $award['faculty_id'],
            ':name_of_award' => $award['name_of_awards'],
            ':organizer' => $award['Organizer'],
            ':place' => $award['Place'],
            ':year' => $year
        ]);
    }

    echo "Awards data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
