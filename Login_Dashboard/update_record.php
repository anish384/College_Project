<?php
require_once 'config.php';
header('Content-Type: application/json'); // Set JSON header

// Get JSON data
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!$input || !isset($input['sr_no']) || !isset($input['table_name']) || !isset($input['fields'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

// Sanitize inputs
$sr_no = $conn->real_escape_string($input['sr_no']);
$table_name = $conn->real_escape_string($input['table_name']);

// Build SET clause for UPDATE query
$set_clauses = [];
foreach ($input['fields'] as $field => $value) {
    $field = $conn->real_escape_string($field);
    $value = $conn->real_escape_string($value);
    $set_clauses[] = "`$field` = '$value'";
}

if (empty($set_clauses)) {
    echo json_encode(['success' => false, 'message' => 'No fields to update']);
    exit;
}

// Construct and execute UPDATE query
$query = "UPDATE $table_name SET " . implode(', ', $set_clauses) . " WHERE sr_no = '$sr_no'";

try {
    if ($conn->query($query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Record updated successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage()
    ]);
}

// Close the connection
$conn->close();
?>