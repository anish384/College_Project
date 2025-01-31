<?php
require_once 'config.php';
header('Content-Type: application/json');

try {
    // Get JSON data
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || !isset($input['sr_no']) || !isset($input['table_name'])) {
        throw new Exception('Invalid input data');
    }

    // Sanitize inputs
    $sr_no = $conn->real_escape_string($input['sr_no']);
    $table_name = $conn->real_escape_string($input['table_name']);

    $query = "DELETE FROM $table_name WHERE sr_no = '$sr_no'";
    
    if ($conn->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception($conn->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>