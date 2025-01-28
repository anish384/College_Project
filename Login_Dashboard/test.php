<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get faculty_id from URL
$faculty_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : null;
if (!$faculty_id) {
    die("Error: Faculty ID not provided.");
}

// Validate faculty_id exists in faculty_table
function validateFacultyId($conn, $faculty_id) {
    $stmt = $conn->prepare("SELECT faculty_id FROM faculty_table WHERE faculty_id = ?");
    $stmt->bind_param("i", $faculty_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Handle new entry submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_entry'])) {
    $table_name = $_POST['table_name'];
    $data = $_POST['data'];

    // Validate table name
    $allowed_tables = [
        'faculty_table', 'awards', 'books_bookchapter', 'chair_resource', 
        'conference', 'experience', 'fdp_conferences_attended', 'for_scholars_dr', 
        'journals', 'mtech_guided', 'patents', 'phd_guided_guiding', 
        'professional_memberships', 'qualification', 'research_grants', 
        'research_grants_till_now', 'students_project_grants'
    ];

    if (!in_array($table_name, $allowed_tables)) {
        die("Invalid table name.");
    }

    // Validate faculty_id exists before insertion
    if (!validateFacultyId($conn, $faculty_id)) {
        die("Error: Faculty ID does not exist in the database.");
    }

    try {
        // Add faculty_id to the data array for tables that need it
        if ($table_name !== 'faculty_table') {
            $data['faculty_id'] = $faculty_id;
        }

        // Prepare column names with proper escaping
        $columns = implode(", ", array_map(function($col) use ($conn) {
            return "`" . $conn->real_escape_string($col) . "`";
        }, array_keys($data)));

        $placeholders = str_repeat("?, ", count($data) - 1) . "?";
        
        // Build the SQL query
        $sql = "INSERT INTO `$table_name` ($columns) VALUES ($placeholders)";
        
        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        // Create types string based on data
        $types = "";
        foreach ($data as $value) {
            if (is_int($value)) $types .= "i";
            elseif (is_float($value)) $types .= "d";
            else $types .= "s";
        }

        // Bind parameters dynamically
        $values = array_values($data);
        $stmt->bind_param($types, ...$values);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
                alert('New entry added successfully!');
                window.location.href='faculty_dashboard.php?faculty_id=$faculty_id';
            </script>";
        } else {
            throw new Exception("Error executing statement: " . $stmt->error);
        }

    } catch (Exception $e) {
        echo "<script>
            alert('Insertion failed: " . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
}

// Handle edit submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_entry'])) {
    $table_name = $_POST['table_name'];
    $row_id = intval($_POST['row_id']);
    $updates = $_POST['updates'];

    try {
        // Build update query
        $set_clause = [];
        $params = [];
        $types = "";

        foreach ($updates as $column => $value) {
            $set_clause[] = "`" . $conn->real_escape_string($column) . "` = ?";
            $params[] = $value;
            $types .= "s"; // Assume string for simplicity, adjust if needed
        }

        $params[] = $row_id;
        $types .= "i";

        $sql = "UPDATE `$table_name` SET " . implode(", ", $set_clause) . " WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            echo "<script>
                alert('Entry updated successfully!');
                window.location.href='faculty_dashboard.php?faculty_id=$faculty_id';
            </script>";
        } else {
            throw new Exception("Error executing statement: " . $stmt->error);
        }

    } catch (Exception $e) {
        echo "<script>
            alert('Update failed: " . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
}

// Tables to display
$tables = [
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
    <title>Faculty Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0;  justify-self: start;}
        header, footer { background-color: #0073e6; color: white; text-align: center; padding: 1rem; }
        main { padding: 2rem; }
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
        .table-section { margin-bottom: 2rem;
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: rgba(9, 30, 66, 0.4) 0px 1px 1px, rgba(9, 30, 66, 0.4) 0px 0px 1px 1px; }
        table { width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 0 auto;}
            img {
            max-width: 220px;
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
        th, td { padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd; }
        th { background-color: #4A90E2;
            color: white;}
        .edit-btn, .add-btn { background-color: #28a745; color: white; padding: 5px 10px; border-radius: 5px; cursor: pointer; border: none; }
        .save-btn { background-color: #0073e6; color: white; padding: 5px 10px; border: none; cursor: pointer; }
        .edit-form, .add-form { display: none; margin-top: 10px; }
    </style>
    <script>
        function toggleEditForm(id) {
            var form = document.getElementById(id);
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
</head>
<body>
    <header><h1>Faculty Dashboard</h1></header>
<main>

    <!-- Faculty Information -->
    <div class="faculty-details table-section">
        <h2>Faculty Information</h2>
        <?php
        $sql = "SELECT * FROM faculty_table WHERE faculty_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $faculty_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $faculty = $result->fetch_assoc();
            echo "<table class='details'>";
            echo "<tr><td rowspan='7'><img src='" . htmlspecialchars($faculty['image']) . "' alt='Faculty Image'></td>";

            foreach (['name' => 'Name', 'faculty_id' => 'Faculty ID','department_name' => 'Department', 'email_id' => 'Email', 
                      'contact_no' => 'Phone', 'Designation' => 'Designation'] as $db_field => $label) {
                echo "<tr><td><strong>$label:</strong> " . htmlspecialchars($faculty[$db_field]) . " ";
                echo "<button class='edit-btn' onclick=\"toggleForm('$db_field')\">Edit</button>";
                echo "<form class='edit-form' id='$db_field' method='POST' style='display:none;'>";
                echo "<input type='hidden' name='faculty_table_edit'>";
                echo "<input type='hidden' name='field_name' value='$db_field'>";
                echo "<input type='text' name='new_value' value='" . htmlspecialchars($faculty[$db_field]) . "' required>";
                echo "<button type='submit' class='save-btn'>Save</button>";
                echo "</form></td></tr>";
            }
            echo "</table>";
        }
        ?>
    </div>

    <!-- Display Other Tables -->
    <?php
    foreach ($tables as $table) {
        echo "<div class='table-section'>";
        echo "<h2>" . ucfirst(str_replace("_", " ", $table)) . "</h2>";

        $sql = "SELECT * FROM $table WHERE faculty_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $faculty_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table><tr>";
            echo "<th>Sr No</th>";
            
            $columns = array_keys($result->fetch_assoc());
            $filtered_columns = array_filter($columns, function($col) {
                return $col !== "faculty_id";
            });

            foreach ($filtered_columns as $col) {
                echo "<th>" . ucfirst(str_replace("_", " ", $col)) . "</th>";
            }
            echo "<th>Action</th></tr>";

            $result->data_seek(0);
            $sr_no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>$sr_no</td>";
                foreach ($filtered_columns as $col) {
                    echo "<td>" . htmlspecialchars($row[$col]) . "</td>";
                }
                echo "<td>
                        <button class='edit-btn' onclick=\"toggleEditForm('edit_{$table}_{$row[$columns[0]]}')\">Edit</button>
                        <form id='edit_{$table}_{$row[$columns[0]]}' class='edit-form' method='POST' onsubmit='return validateForm(this.id)'>
                            <div class='form-group'>
                                <input type='hidden' name='table_name' value='$table'>
                                <input type='hidden' name='row_id' value='{$row[$columns[0]]}'>
                                <input type='hidden' name='field_name' value='{$filtered_columns[1]}'>";
                
                foreach ($filtered_columns as $col) {
                    if ($col !== "id") {
                        echo "<label>" . ucfirst(str_replace("_", " ", $col)) . ":</label>
                              <input type='text' name='new_value' value='" . htmlspecialchars($row[$col]) . "' required>";
                    }
                }
                
                echo "  </div>
                        <div class='button-group'>
                            <button type='submit' class='save-btn'>Save</button>
                            <button type='button' class='edit-btn' onclick=\"toggleEditForm('edit_{$table}_{$row[$columns[0]]}')\">Cancel</button>
                        </div>
                        </form>
                      </td>
                </tr>";
                $sr_no++;
            }
            echo "</table>";
        } else {
            echo "<p>No data found.</p>";
        }

        // Modified Add New Entry button and form
        echo "<button class='add-btn' onclick=\"toggleAddForm('add_$table')\">Add New Entry</button>";
        echo "<form id='add_$table' class='add-form' method='POST' onsubmit='return validateForm(this.id)'>";
        echo "<input type='hidden' name='add_entry' value='1'>";
        echo "<input type='hidden' name='table_name' value='$table'>";
        
        $result_columns = $conn->query("SHOW COLUMNS FROM $table");
        while ($column = $result_columns->fetch_assoc()) {
            if ($column['Field'] !== "id" && $column['Field'] !== "faculty_id") {
                echo "<div class='form-group'>";
                echo "<label>" . ucfirst(str_replace("_", " ", $column['Field'])) . ":</label>";
                echo "<input type='text' name='data[" . $column['Field'] . "]' required>";
                echo "</div>";
            }
        }

        echo "<div class='button-group'>";
        echo "<button type='submit' class='save-btn'>Submit</button>";
        echo "<button type='button' class='edit-btn' onclick=\"toggleAddForm('add_$table')\">Cancel</button>";
        echo "</div></form></div>";
    }
    ?>
</main>



</body>
</html>
