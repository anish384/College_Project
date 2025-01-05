<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the faculty_id from the URL
$faculty_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : null;
if (!$faculty_id) {
    die("Error: Faculty ID not provided.");
}

// List of 17 table names
$tables = [
    'faculty_table',
    'awards',
    'books_bookchapter',
    'chair_resource',
    'conference',
    'experience',
    'fdp_conferences_attended',
    'for_scholars_dr',
    'journals',
    'mtech_guided',
    'patents',
    'phd_guided_guiding',
    'professional_memberships',
    'qualification',
    'research_grants',
    'research_grants_till_now',
    'students_project_grants'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header, footer {
            background-color: #0073e6;
            color: white;
            text-align: center;
            padding: 1rem;
        }
        main {
            padding: 2rem;
        }
        h1, h2 {
            color: #333;
        }
        .table-section {
            margin-bottom: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #0073e6;
            color: white;
        }
        img {
            max-width: 100px;
            height: auto;
            display: block;
        }
        p {
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <h1>Faculty Details for ID: <?php echo htmlspecialchars($faculty_id); ?></h1>
    </header>
    <main>
        <?php
        foreach ($tables as $table) {
            echo "<div class='table-section'>";
            echo "<h2>" . ucfirst(str_replace("_", " ", $table)) . "</h2>";

            // Prepare and execute the query
            $sql = "SELECT * FROM $table WHERE faculty_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $faculty_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr>";

                // Dynamically fetch and print column headers
                while ($field = $result->fetch_field()) {
                    echo "<th>" . ucfirst(str_replace("_", " ", $field->name)) . "</th>";
                }
                echo "</tr></thead>";

                // Dynamically fetch and print rows
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $column => $value) {
                        if ($table === 'faculty_table' && $column === 'image') {
                            // Display image if column is 'image'
                            if (!empty($value)) {
                                echo "<td><img src='" . htmlspecialchars($value) . "' alt='Faculty Image'></td>";
                            } else {
                                echo "<td>No Image</td>";
                            }
                        } else {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No data found for this table.</p>";
            }

            echo "</div>";
            $stmt->close();
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2024 College Database</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
