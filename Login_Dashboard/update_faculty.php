<?php
require_once 'config.php';
header('Content-Type: application/json');

try {
    // Get current faculty_id and fields
    $current_faculty_id = $_POST['faculty_id'] ?? null;
    $fields = json_decode($_POST['fields'], true) ?? null;

    if (!$current_faculty_id || !$fields) {
        throw new Exception('Invalid input data');
    }

    // Start transaction
    $conn->begin_transaction();

    // Sanitize faculty IDs
    $current_faculty_id = $conn->real_escape_string($current_faculty_id);
    $new_faculty_id = isset($fields['faculty_id']) ? $conn->real_escape_string($fields['faculty_id']) : $current_faculty_id;

    // If faculty_id is being changed, verify new ID doesn't exist
    if ($new_faculty_id !== $current_faculty_id) {
        $check_query = "SELECT faculty_id FROM faculty_table WHERE faculty_id = '$new_faculty_id'";
        $check_result = $conn->query($check_query);
        if ($check_result->num_rows > 0) {
            throw new Exception('New faculty ID already exists');
        }

        // Get all tables with faculty_id as foreign key
        $tables_query = "
            SELECT TABLE_NAME 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE REFERENCED_TABLE_NAME = 'faculty_table' 
            AND REFERENCED_COLUMN_NAME = 'faculty_id' 
            AND TABLE_SCHEMA = DATABASE()";
        
        $tables_result = $conn->query($tables_query);
        
        // Update faculty_id in all related tables
        while ($table = $tables_result->fetch_assoc()) {
            $table_name = $table['TABLE_NAME'];
            $update_query = "UPDATE `$table_name` 
                           SET faculty_id = '$new_faculty_id' 
                           WHERE faculty_id = '$current_faculty_id'";
            
            if (!$conn->query($update_query)) {
                throw new Exception("Failed to update faculty_id in $table_name");
            }
        }
    }

    // Build SET clause for faculty_table
    $sets = [];
    foreach ($fields as $field => $value) {
        if ($field === 'faculty_id') {
            // Add faculty_id update if it's changed
            if ($value !== $current_faculty_id) {
                $sanitized_value = $conn->real_escape_string(trim($value));
                $sets[] = "`faculty_id` = '$sanitized_value'";
            }
            continue;
        }
        
        $sanitized_value = $conn->real_escape_string(trim($value));
        $sets[] = "`$field` = '$sanitized_value'";
    }

    // Handle image upload
    if (isset($_FILES['faculty_image']) && $_FILES['faculty_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/bmp' => 'bmp'
        ];
        
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($_FILES['faculty_image']['tmp_name']);
        
        if (!array_key_exists($mime_type, $allowed_types)) {
            throw new Exception('Invalid image format. Allowed formats: JPEG, PNG, GIF, WEBP, BMP');
        }
        
        $extension = $allowed_types[$mime_type];
        $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9]/", "", pathinfo($_FILES['faculty_image']['name'], PATHINFO_FILENAME));
        
        $relative_path = "img/" . $filename . "." . $extension;
        $full_path = "../Display/" . $relative_path;
        
        $img_dir = "../Display/img";
        if (!is_dir($img_dir)) {
            mkdir($img_dir, 0777, true);
        }
        
        if (move_uploaded_file($_FILES['faculty_image']['tmp_name'], $full_path)) {
            $sets[] = "`image` = '" . $conn->real_escape_string($relative_path) . "'";
        } else {
            throw new Exception('Failed to save image file');
        }
    }

    if (empty($sets)) {
        throw new Exception('No fields to update');
    }

    // Update faculty_table
    $update_query = "UPDATE faculty_table 
                    SET " . implode(', ', $sets) . " 
                    WHERE faculty_id = '$current_faculty_id'";
    
    if (!$conn->query($update_query)) {
        throw new Exception($conn->error);
    }

    // If everything is successful, commit the transaction
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Faculty information updated successfully',
        'new_faculty_id' => $new_faculty_id
    ]);

} catch (Exception $e) {
    // Rollback on error
    if ($conn->connect_errno === 0) {
        $conn->rollback();
    }
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>