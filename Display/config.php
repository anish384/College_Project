<?php
// config.php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'college_database');

// Application settings
define('APP_NAME', 'Faculty Data System');
define('APP_VERSION', '1.0.0');

// Current timestamp and user settings
define('CURRENT_TIMESTAMP', '2025-02-06 17:07:24'); // Updated timestamp
define('CURRENT_USER', 'vky6366');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1); // Changed to 1 to see errors
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Export settings
define('EXPORT_PATH', __DIR__ . '/exports/');
define('MAX_EXECUTION_TIME', 300);
define('MEMORY_LIMIT', '512M');

// File settings
define('ALLOWED_FILE_SIZE', 52428800); // 50MB in bytes
define('TEMP_DIR', sys_get_temp_dir());

// Create database connection
try {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}

// Set PHP configuration
ini_set('memory_limit', MEMORY_LIMIT);
set_time_limit(MAX_EXECUTION_TIME);
date_default_timezone_set('UTC');

// Helper functions
function sanitize_filename($filename) {
    return preg_replace('/[^A-Za-z0-9.]/', '_', $filename);
}

function format_timestamp($timestamp) {
    return date('Y-m-d H:i:s', strtotime($timestamp));
}

// Error handling function
function handle_error($error_message) {
    error_log($error_message);
    return [
        'status' => 'error',
        'message' => $error_message,
        'timestamp' => CURRENT_TIMESTAMP,
        'user' => CURRENT_USER
    ];
}

// Validation functions
function validate_department_name($department_name) {
    global $conn;
    if (empty($department_name)) {
        throw new Exception("Department name is required");
    }
    return mysqli_real_escape_string($conn, $department_name);
}

// Initialize export directory
$export_dir = EXPORT_PATH;
if (!file_exists($export_dir)) {
    if (!mkdir($export_dir, 0755, true)) {
        error_log("Failed to create export directory: " . $export_dir);
    }
}

// Clean up old temporary files
function cleanup_temp_files() {
    $files = glob(TEMP_DIR . '/excel_*');
    $now = time();
    
    foreach ($files as $file) {
        if (is_file($file)) {
            if ($now - filemtime($file) >= 3600) { // Files older than 1 hour
                @unlink($file);
            }
        }
    }
}

// Run cleanup
cleanup_temp_files();

// Session handling
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection test
function test_db_connection() {
    global $conn;
    try {
        if (!$conn->ping()) {
            throw new Exception("Database connection lost");
        }
        return true;
    } catch (Exception $e) {
        error_log("Database Connection Test Failed: " . $e->getMessage());
        return false;
    }
}

// Test database connection
if (!test_db_connection()) {
    die("Database connection test failed. Please check your connection settings.");
}

// Don't set headers if they're already sent
if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
}

// Error handler
function custom_error_handler($errno, $errstr, $errfile, $errline) {
    $error_message = date('Y-m-d H:i:s') . " - Error [$errno]: $errstr in $errfile on line $errline";
    error_log($error_message);
    
    if (ini_get('display_errors')) {
        echo "<pre>$error_message</pre>";
    }
    
    return true;
}

// Set custom error handler
set_error_handler("custom_error_handler");

return $conn;
?>