<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the department_name from the query string
if (isset($_GET['department_name'])) {
    // Escape the department_name to prevent SQL injection
    $department_name = $conn->real_escape_string($_GET['department_name']);

    // Verify if the department exists
    $dept_query = "SELECT department_name FROM departments WHERE department_name = '$department_name'";
    $dept_result = $conn->query($dept_query);

    if ($dept_result->num_rows > 0) {
        // Fetch teachers in the department using department_name
        $query = "SELECT * FROM faculty_table WHERE department_name = '$department_name'";
        $result = $conn->query($query);
    } else {
        die("Department not found.");
    }
} else {
    die("Invalid Department Name.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers in <?php echo htmlspecialchars($department_name); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            padding: 20px;
            font-family: 'Arial', sans-serif;
            color: #000000;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
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
        .department-box {
            width: 200px;
            background-color: #fff;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
            transition: all 0.3s ease;
        }
        .department-box img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .department-box a {
            display: block;
            color: #7b38f7;
            font-size: 1.2em;
            font-weight: bold;
            text-decoration: none;
        }
        .department-box a:hover {
            text-decoration: underline;
        }
        .content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .main {
            background-color: rgb(255, 255, 255);
            color: rgb(255, 255, 255);
            height: 250px;
            width: auto;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <h1>Teachers in <?php echo htmlspecialchars($department_name); ?></h1>
    <div class="department-box">
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
