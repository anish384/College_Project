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
            justify-self: start;
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
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: rgba(9, 30, 66, 0.4) 0px 1px 1px, rgba(9, 30, 66, 0.4) 0px 0px 1px 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            
        }
        th {
            background-color: #4A90E2;
            color: white;
        }
        img {
            max-width: 180px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 10px;

        }
        .faculty-details {
            margin-bottom: 2rem;
            justify: Center;
        }
        .faculty-details img {
            margin-right: 1rem;
            float: left;
        }
        p {
            color: black;
        }
        .details {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .details th,
        .details td {
            border: 1px solid white;
            padding: 4px;
            text-align: left;
        }

    </style>
</head>
<body>
    <header>
        <h1>Faculty Details for ID: <?php echo htmlspecialchars($faculty_id); ?></h1>
    </header>
    <main>
        <?php
        // Custom handling for `faculty_table`
        if (in_array('faculty_table', $tables)) {
            echo "<div class='faculty-details'>";
            echo "<table class='faculty_details'>";
            // Fetch data from `faculty_table`
            $sql = "SELECT * FROM faculty_table WHERE faculty_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $faculty_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $faculty = $result->fetch_assoc();
                echo "<table border='0' class='details'>";
                echo "<tr>";
                echo "<td rowspan='6'><img src='" . htmlspecialchars($faculty['image']) . "' alt='Faculty Image' style='max-width: auto; height: 200px ; border-radius: 5px;'></td>";
                echo "<td><strong>Name:</strong> " . htmlspecialchars($faculty['name']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Department:</strong> " . htmlspecialchars($faculty['Department']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Email:</strong> " . htmlspecialchars($faculty['email_id']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Phone:</strong> " . htmlspecialchars($faculty['contact_no']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Designation:</strong> " . htmlspecialchars($faculty['Designation']) . "</td>";
                echo "</tr>";
                echo "</table>";

            } else {
                echo "<p>No data found for the faculty table.</p>";
            }
            
            echo "</div>";
            $stmt->close();
        }

        // Display other tables dynamically
        foreach ($tables as $table) {
            if ($table === 'faculty_table') continue; // Skip faculty_table here
        
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
        
                // Add S.No header
                echo "<th>S.No</th>";
        
                // Dynamically fetch and print column headers, excluding 'faculty_id'
                $fields = $result->fetch_fields();
                foreach ($fields as $field) {
                    if ($field->name === 'faculty_id') continue; // Skip faculty_id
                    echo "<th>" . ucfirst(str_replace("_", " ", $field->name)) . "</th>";
                }
                echo "</tr></thead>";
        
                // Dynamically fetch and print rows, excluding 'faculty_id'
                echo "<tbody>";
                $serial_number = 1; // Initialize S.No counter
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
        
                    // Print S.No
                    echo "<td>" . $serial_number++ . "</td>";
        
                    // Print other columns
                    foreach ($row as $key => $value) {
                        if ($key === 'faculty_id') continue; // Skip faculty_id
                        echo "<td>" . htmlspecialchars($value) . "</td>";
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
