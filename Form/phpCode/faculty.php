<?php
$host = 'localhost';
$dbname = 'college_database';
$username = 'root';
$password = '';

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging: Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $faculty_id      = $_POST['faculty_id'];
    $name            = $_POST['name'];
    $designation     = $_POST['Designation'];
    $department      = $_POST['Department'];
    $date_of_joining = $_POST['date_of_joining'];
    $email           = $_POST['email'];
    $contact_no      = $_POST['con'];
    
    // Handle optional fields
    $orchid_id = $_POST['orchid_id'] ?? NULL;
    $scholar = $_POST['scholar'] ?? NULL;

    // Set default image path (relative to Display/img)
    $image = "img/default.jpg"; // Default image

    // **Image Upload Handling**
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $upload_dir = __DIR__ . '/../../Display/img/';
        $relative_path = "img/";

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $image_name  = basename($_FILES['img']['name']);
        $unique_name = time() . "_" . $image_name; 
        $target_path = $upload_dir . $unique_name;  

        $file_type     = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
                $image = $relative_path . $unique_name;
            } else {
                die("Error uploading image. Check folder permissions.");
            }
        } else {
            die("Invalid file format. Only JPG, JPEG, PNG, and GIF allowed.");
        }
    }

    // -----------------------------------------------
    // Ensure that the provided department exists in the 'departments' table.
    $dept_check_stmt = $conn->prepare("SELECT department_name FROM departments WHERE department_name = ?");
    $dept_check_stmt->bind_param("s", $department);
    $dept_check_stmt->execute();
    $dept_result = $dept_check_stmt->get_result();

    if ($dept_result->num_rows === 0) {
        die("Error: The department '$department' does not exist. Please provide a valid department.");
    }
    $dept_check_stmt->close();
    // -----------------------------------------------

    // **Check if faculty_id already exists**
    $check_stmt = $conn->prepare("SELECT * FROM faculty_table WHERE faculty_id = ?");
    $check_stmt->bind_param("s", $faculty_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // **UPDATE existing record**
        $stmt = $conn->prepare("UPDATE faculty_table SET name=?, Designation=?, department_name=?, date_of_joining=?, email_id=?, scholar=?, contact_no=?, orchid_id=?, image=? WHERE faculty_id=?");
        $stmt->bind_param("ssssssssss", $name, $designation, $department, $date_of_joining, $email, $scholar, $contact_no, $orchid_id, $image, $faculty_id);
    } else {
        // **INSERT new record**
        $stmt = $conn->prepare("INSERT INTO faculty_table (faculty_id, name, Designation, department_name, date_of_joining, email_id, contact_no, orchid_id, scholar, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $faculty_id, $name, $designation, $department, $date_of_joining, $email, $contact_no, $orchid_id, $scholar, $image);
    }

    // **Execute the query**
    if ($stmt->execute()) {
        echo "Faculty record successfully saved!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $check_stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>