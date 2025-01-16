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
$stmt = $conn->prepare("INSERT INTO faculty_table (faculty_id, name, Designation, Department, date_of_joining, email_id, contact_no, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $faculty_id, $name, $designation, $department, $date_of_joining, $email, $contact_no, $image);

// Set parameters and execute
$faculty_id = $_POST['faculty_id'];
$name = $_POST['name'];
$designation = $_POST['Designation'];
$department = $_POST['Department'];
$date_of_joining = $_POST['date_of_joining'];
$email = $_POST['email'];
$contact_no = $_POST['con'];
$image = $_POST['img'];

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
