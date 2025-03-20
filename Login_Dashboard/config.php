<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Your existing database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>