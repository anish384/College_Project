<?php
require_once 'config.php';
header('Content-Type: application/json');

// Get JSON data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['table_name']) || !isset($input['faculty_id']) || !isset($input['fields'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

// Sanitize inputs
$table_name = $conn->real_escape_string($input['table_name']);
$faculty_id = $conn->real_escape_string($input['faculty_id']);

// Build INSERT query
$fields = ['faculty_id'];
$values = ["'$faculty_id'"];

foreach ($input['fields'] as $field => $value) {
    $field = $conn->real_escape_string($field);
    $value = $conn->real_escape_string($value);
    $fields[] = "`$field`";
    $values[] = "'$value'";
}

$query = "INSERT INTO $table_name (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";

try {
    if ($conn->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>