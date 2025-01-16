<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store journal data
    $journals = [];

    // Extract journal data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $journals[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting journal data
    $stmt = $pdo->prepare("INSERT INTO journals (faculty_id, title, name_of_journal, author_type, publisher, place, vol_no_issue_no, ISSN, page_no, year, website_link, international_national, free_paid, indexing, impact_factor, SNIP, SJR, h_index, citations) 
                           VALUES (:faculty_id, :title, :name_of_journal, :author_type, :publisher, :place, :vol_no_issue_no, :ISSN, :page_no, :year, :website_link, :international_national, :free_paid, :indexing, :impact_factor, :SNIP, :SJR, :h_index, :citations)");

    // Loop through each journal and execute the insert statement
    foreach ($journals as $journal) {
        $stmt->execute([
            ':faculty_id' => $journal['faculty_id'],
            ':title' => $journal['title'],
            ':name_of_journal' => $journal['name_of_journal'],
            ':author_type' => $journal['author_type'],
            ':publisher' => $journal['publisher'],
            ':place' => $journal['place'],
            ':vol_no_issue_no' => $journal['vol_no_issue_no'],
            ':ISSN' => $journal['ISSN'],
            ':page_no' => $journal['page_no'],
            ':year' => $journal['year'],
            ':website_link' => $journal['website_link'],
            ':international_national' => $journal['international_national'],
            ':free_paid' => $journal['free_paid'],
            ':indexing' => $journal['indexing'],
            ':impact_factor' => $journal['impact_factor'],
            ':SNIP' => $journal['SNIP'],
            ':SJR' => $journal['SJR'],
            ':h_index' => $journal['h_index'],
            ':citations' => $journal['citations']
        ]);
    }

    echo "Journal data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

