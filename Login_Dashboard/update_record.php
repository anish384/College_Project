<?php
require_once 'config.php';
header('Content-Type: application/json');

// Get JSON data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['sr_no']) || !isset($input['table_name']) || !isset($input['fields'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

// Sanitize inputs
$sr_no = $conn->real_escape_string($input['sr_no']);
$table_name = $conn->real_escape_string($input['table_name']);

// Build SET clause
$sets = [];
foreach ($input['fields'] as $field => $value) {
    $field = $conn->real_escape_string($field);
    $value = $conn->real_escape_string($value);
    $sets[] = "`$field` = '$value'";
}

if (empty($sets)) {
    echo json_encode(['success' => false, 'message' => 'No fields to update']);
    exit;
}

$query = "UPDATE $table_name SET " . implode(', ', $sets) . " WHERE sr_no = '$sr_no'";

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