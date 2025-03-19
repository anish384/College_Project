<?php
require_once 'config.php';

if (!isset($_GET['table'])) {
    die('Table name not provided');
}

$table = $_GET['table'];

// Validate table name
$tables_query = "SHOW TABLES";
$tables_result = $conn->query($tables_query);
$valid_tables = [];
while ($table_row = $tables_result->fetch_array()) {
    $valid_tables[] = $table_row[0];
}

if (!in_array($table, $valid_tables)) {
    die('Invalid table name');
}

try {
    // Join with faculty_table if applicable
    if ($table != 'faculty_table' && $table != 'departments') {
        $sql = "SELECT t.*, f.name as faculty_name 
                FROM $table t 
                LEFT JOIN faculty_table f ON t.faculty_id = f.faculty_id";
    } else {
        $sql = "SELECT * FROM $table";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>" . ucwords(str_replace('_', ' ', $table)) . "</h3>";
        echo "<div style='overflow-x: auto;'>";
        echo "<table class='data-table' style='width:100%; border-collapse:collapse; margin-top:10px;'>";
        
        // Headers
        echo "<thead><tr>";
        $fields = $result->fetch_fields();
        foreach ($fields as $field) {
            echo "<th style='background:rgb(43, 69, 152); color:white; padding:10px;'>" . 
                 ucwords(str_replace('_', ' ', $field->name)) . "</th>";
        }
        echo "</tr></thead><tbody>";

        // Data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td style='padding:8px; border:1px solid #ddd; color:#333;'>" . 
                     htmlspecialchars($value ?? '') . "</td>";
            }
            echo "</tr>";
        }
        
        echo "</tbody></table>";
        echo "</div>";
    } else {
        echo "<p>No records found in " . ucwords(str_replace('_', ' ', $table)) . "</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>Error loading table data: " . htmlspecialchars($e->getMessage()) . "</p>";
}

$conn->close();
?>