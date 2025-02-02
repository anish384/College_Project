<?php
require_once 'config.php';
header('Content-Type: application/json');

try {
    // Get JSON data
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || !isset($input['faculty_id']) || !isset($input['table_name']) || !isset($input['fields'])) {
        throw new Exception('Invalid input data');
    }

    // Sanitize inputs
    $faculty_id = $conn->real_escape_string($input['faculty_id']);
    $table_name = $conn->real_escape_string($input['table_name']);

    // Build SET clause
    $sets = [];
    foreach ($input['fields'] as $field => $value) {
        $field = $conn->real_escape_string($field);
        $value = $conn->real_escape_string($value);
        $sets[] = "`$field` = '$value'";
    }

    if (empty($sets)) {
        throw new Exception('No fields to update');
    }

    // Update query using faculty_id
    $query = "UPDATE $table_name SET " . implode(', ', $sets) . " WHERE faculty_id = '$faculty_id'";
    
    if ($conn->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception($conn->error);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>