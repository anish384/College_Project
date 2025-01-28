<?php
// Database connection details
$host = 'localhost'; // Database host
$dbname = 'college_database'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO faculty_table (faculty_id, name, Designation, department_name, date_of_joining, email_id, contact_no, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $faculty_id, $name, $designation, $department, $date_of_joining, $email, $contact_no, $image);

// Set parameters and execute
$faculty_id = $_POST['faculty_id'];
$name = $_POST['name'];
$designation = $_POST['Designation'];
$department = $_POST['Department'];
$date_of_joining = $_POST['date_of_joining'];
$email = $_POST['email'];
$contact_no = $_POST['con'];
if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
    // Define the target upload directory
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/Display/img/"; // Absolute path for Display/img
    $relative_path = "img/"; // Path to store in the database

    // Ensure the Display/img directory exists
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $image_name = basename($_FILES['img']['name']);
    $unique_name = time() . "_" . $image_name; // Make filename unique

    // Define the full storage path
    $target_path = $upload_dir . $unique_name;

    // Allowed image types
    $file_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed_types = ["jpg", "jpeg", "png", "gif"];

    if (in_array($file_type, $allowed_types)) {
        // Move file to Display/img directory
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
            $image = $relative_path . $unique_name; // Store "img/filename.png" in the database
        } else {
            die("Error uploading image.");
        }
    } else {
        die("Invalid file format. Only JPG, JPEG, PNG, and GIF allowed.");
    }
} else {
    $image = "img/default.jpg"; // Default image path
}



// **Insert into database**
$stmt = $conn->prepare("INSERT INTO faculty_table (faculty_id, name, Designation, department_name, date_of_joining, email_id, contact_no, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $faculty_id, $name, $designation, $department, $date_of_joining, $email, $contact_no, $image);

if ($stmt->execute()) {
    echo "New faculty record created successfully!";
} else {
    echo "Error: " . $stmt->error;
}


// Close connections
$stmt->close();
$conn->close();
?>
