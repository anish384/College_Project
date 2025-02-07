<?php
require_once 'config.php';

echo "Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted): " . CURRENT_TIMESTAMP . "\n";
echo "Current User's Login: " . CURRENT_USER . "\n";
echo "Configuration loaded successfully\n";
echo "Current Timestamp: " . CURRENT_TIMESTAMP . "\n";
echo "Current User: " . CURRENT_USER . "\n";
echo "Database Status: " . ($conn->ping() ? "Connected" : "Not Connected") . "\n";
?>