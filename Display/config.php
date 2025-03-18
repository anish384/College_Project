<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
try {
    $conn = new mysqli("127.0.0.1", "root", "", "college_database");
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set charset to ensure proper encoding
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Database Connection Error: " . $e->getMessage());
}

// Set timezone to UTC
date_default_timezone_set('UTC');

// Function to verify if user is logged in
function checkLogin() {
    if (!isset($_SESSION['faculty_id'])) {
        header("Location: index.php");
        exit();
    }
}

// Function to format date time
function formatDateTime($datetime) {
    return date('Y-m-d H:i:s', strtotime($datetime));
}

// Function to sanitize output
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>