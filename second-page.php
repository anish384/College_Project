<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the department_id from the query string
if (isset($_GET['department_id'])) {
    $department_id = intval($_GET['department_id']);

    // Fetch the department name
    $dept_query = "SELECT department_name FROM departments WHERE department_id = $department_id";
    $dept_result = $conn->query($dept_query);
    $department_name = $dept_result->num_rows > 0 ? $dept_result->fetch_assoc()['department_name'] : "Unknown Department";

    // Fetch teachers in the department
    $query = "SELECT * FROM faculty_table WHERE department_id = $department_id";
    $result = $conn->query($query);
} else {
    die("Invalid Department ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers in <?php echo htmlspecialchars($department_name); ?></title>
    <style>
        /* Add your styles for the teacher cards here */
        .card {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            margin-right: 20px;
        }

        .card-content {
            flex: 1;
        }

        .card-content p {
            margin: 4px 0;
            font-size: 16px;
        }

        .card-content strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Teachers in <?php echo htmlspecialchars($department_name); ?></h1>
    <div class="teachers-container">
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<a href='third-page.php?faculty_id=" . htmlspecialchars($row['faculty_id']) . "' class='card-link'>"; // Add link wrapping the card
                    echo "<div class='card'>";
                    echo "<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                    echo "<div class='card-content'>";
                    echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email_id']) . "</p>";
                    echo "<p><strong>Contact:</strong> " . htmlspecialchars($row['contact_no']) . "</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</a>"; // Close the link
                }
            } else {
                echo "<p>No teachers found in this department.</p>";
            }
        ?>
</div>

</body>
</html>
