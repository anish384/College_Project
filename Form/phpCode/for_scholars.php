<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $scholars = [];

    // Loop through POST data to capture information for each scholar
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $field = str_replace("_$index", '', $key);
            $scholars[$index][$field] = $value;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO for_scholars_dr 
        (faculty_id, degree, University, year_of_registration, Area_of_research, Year_of_complition_of_Coursework, Year_of_complition_of_Comprehensive, Year_of_Passing) 
        VALUES (:faculty_id, :degree, :University, :year_of_registration, :Area_of_research, :Year_of_complition_of_Coursework, :Year_of_complition_of_Comprehensive, :Year_of_Passing)");

    // Insert each scholar's data into the database
    foreach ($scholars as $scholar) {
        $stmt->execute([
            ':faculty_id' => $scholar['faculty_id'],
            ':degree' => $scholar['degree'],
            ':University' => $scholar['University'],
            ':year_of_registration' => $scholar['yearofregi'],
            ':Area_of_research' => $scholar['areaofres'],
            ':Year_of_complition_of_Coursework' => $scholar['Year_of_complition_of_Coursework'],
            ':Year_of_complition_of_Comprehensive' => $scholar['Year_of_complition_of_Comprehensive'],
            ':Year_of_Passing' => $scholar['yearofpassing']
        ]);
    }

    echo "Scholar data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


