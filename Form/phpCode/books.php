<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an empty array to store book data
    $books = [];

    // Extract book data from the POST request
    foreach ($_POST as $key => $value) {
        if (preg_match('/_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $books[$index][str_replace("_$index", '', $key)] = $value;
        }
    }

    // Prepare the SQL statement for inserting book data
    $stmt = $pdo->prepare("INSERT INTO books (faculty_id, Title, Publisher, Place, Year_of_publication, ISBN, Book/Chapter) VALUES (:faculty_id, :title, :publisher, :place, :year_of_publication, :isbn, :book_chapter)");

    // Loop through each book and execute the insert statement
    foreach ($books as $book) {
        $yearOfPublication = !empty($book['YOP']) ? (int)$book['YOP'] : null;
        $stmt->execute([
            ':faculty_id' => $book['faculty_id'],
            ':title' => $book['Title'],
            ':publisher' => $book['Publisher'],
            ':place' => $book['Place'],
            ':year_of_publication' => $yearOfPublication,
            ':isbn' => $book['isbn'],
            ':book_chapter' => $book['book_chapter']
        ]);
    }

    echo "Books data saved successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
