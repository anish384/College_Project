<?php
require_once 'config.php';
header('Content-Type: application/json');

try {
    // Get faculty_id and fields
    $faculty_id = $_POST['faculty_id'] ?? null;
    $fields = json_decode($_POST['fields'], true) ?? null;

    if (!$faculty_id || !$fields) {
        throw new Exception('Invalid input data');
    }

    // Sanitize faculty_id
    $faculty_id = $conn->real_escape_string($faculty_id);

    // Validate required fields
    $required_fields = ['name', 'department_name', 'Designation', 'date_of_joining', 'email_id', 'contact_no'];
    foreach ($required_fields as $field) {
        if (!isset($fields[$field]) || trim($fields[$field]) === '') {
            throw new Exception("Field '$field' is required");
        }
    }

    // Build SET clause with proper field validation
    $sets = [];
    foreach ($fields as $field => $value) {
        // Validate field name to prevent SQL injection
        if (!in_array($field, $required_fields)) {
            continue;
        }
        $sanitized_value = $conn->real_escape_string(trim($value));
        $sets[] = "`$field` = '$sanitized_value'";
    }

    // Handle image upload
    if (isset($_FILES['faculty_image']) && $_FILES['faculty_image']['error'] === UPLOAD_ERR_OK) {
        // Allowed mime types
        $allowed_types = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/bmp' => 'bmp'
        ];
        
        // Get uploaded file's mime type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($_FILES['faculty_image']['tmp_name']);
        
        if (!array_key_exists($mime_type, $allowed_types)) {
            throw new Exception('Invalid image format. Allowed formats: JPEG, PNG, GIF, WEBP, BMP');
        }
        
        // Create unique filename
        $extension = $allowed_types[$mime_type];
        $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9]/", "", pathinfo($_FILES['faculty_image']['name'], PATHINFO_FILENAME));
        
        // Set path relative to Display/img directory
        $relative_path = "img/" . $filename . "." . $extension;
        $full_path = "../Display/" . $relative_path;
        
        // Create directory if it doesn't exist
        $img_dir = "../Display/img";
        if (!is_dir($img_dir)) {
            mkdir($img_dir, 0777, true);
        }
        
        // Move uploaded file
        if (move_uploaded_file($_FILES['faculty_image']['tmp_name'], $full_path)) {
            // Store only the relative path in database (img/filename.ext)
            $sets[] = "`image` = '" . $conn->real_escape_string($relative_path) . "'";
        } else {
            throw new Exception('Failed to save image file');
        }
    }

    if (empty($sets)) {
        throw new Exception('No fields to update');
    }

    // Update query
    $query = "UPDATE faculty_table SET " . implode(', ', $sets) . " WHERE faculty_id = '$faculty_id'";
    
    if (!$conn->query($query)) {
        throw new Exception($conn->error);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Faculty information updated successfully'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Close connection
$conn->close();
?>