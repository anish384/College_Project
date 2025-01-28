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
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0;
            background-color: #f5f5f5;
        }
        
        header { 
            background-color: #0073e6; 
            color: white; 
            text-align: center; 
            padding: 1rem;
            margin-bottom: 2rem;
        }
        
        main { 
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .table-section { 
            margin-bottom: 2rem;
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .faculty-details {
            display: flex;
            align-items: start;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .faculty-image {
            flex-shrink: 0;
        }
        
        .faculty-info {
            flex-grow: 1;
        }
        
        img {
            max-width: 220px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
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
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .edit-btn, .add-btn {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 4px;
            transition: background-color 0.2s;
        }
        
        .edit-btn:hover, .add-btn:hover {
            background-color: #218838;
        }
        
        .save-btn {
            background-color: #0073e6;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 4px;
        }
        
        .save-btn:hover {
            background-color: #0056b3;
        }
        
        .edit-form, .add-form {
            display: none;
            margin-top: 15px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .button-group {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
        
        .cancel-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .cancel-btn:hover {
            background-color: #c82333;
        }

        .field-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .field-label {
            font-weight: bold;
            min-width: 120px;
        }
    </style>
    
    <script>
        function toggleEditForm(formId) {
            const form = document.getElementById(formId);
            if (form) {
                // Close all other forms first
                const allForms = document.querySelectorAll('.edit-form, .add-form');
                allForms.forEach(f => {
                    if (f.id !== formId) {
                        f.style.display = 'none';
                    }
                });
                
                // Toggle the selected form
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        }

        function toggleAddForm(formId) {
            const form = document.getElementById(formId);
            if (form) {
                // Close all other forms first
                const allForms = document.querySelectorAll('.edit-form, .add-form');
                allForms.forEach(f => {
                    if (f.id !== formId) {
                        f.style.display = 'none';
                    }
                });
                
                // Toggle the selected form
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        }

        function validateForm(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll('input[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '#ddd';
                }
            });
            
            if (!isValid) {
                alert('Please fill in all required fields.');
            }
            
            return isValid;
        }
    </script>
</head>
<body>
    <header>
        <h1>Faculty Dashboard</h1>
    </header>
    
    <main>
        <!-- Faculty Information -->
        <div class="table-section">
            <h2>Faculty Information</h2>
            <?php
            $sql = "SELECT * FROM faculty_table WHERE faculty_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $faculty_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $faculty = $result->fetch_assoc();
                echo "<div class='faculty-details'>";
                echo "<div class='faculty-image'>";
                echo "<img src='" . htmlspecialchars($faculty['image']) . "' alt='Faculty Image'>";
                echo "</div>";
                echo "<div class='faculty-info'>";

                foreach (['name' => 'Name', 'faculty_id' => 'Faculty ID', 'department_name' => 'Department', 
                         'email_id' => 'Email', 'contact_no' => 'Phone', 'Designation' => 'Designation'] as $db_field => $label) {
                    echo "<div class='field-row'>";
                    echo "<span class='field-label'>$label:</span>";
                    echo "<span>" . htmlspecialchars($faculty[$db_field]) . "</span>";
                    echo "<button class='edit-btn' onclick=\"toggleEditForm('edit_faculty_$db_field')\">Edit</button>";
                    echo "<form id='edit_faculty_$db_field' class='edit-form' method='POST' onsubmit='return validateForm(this.id)'>";
                    echo "<input type='hidden' name='edit_entry' value='1'>";
                    echo "<input type='hidden' name='table_name' value='faculty_table'>";
                    echo "<input type='hidden' name='row_id' value='{$faculty['faculty_id']}'>";
                    echo "<div class='form-group'>";
                    echo "<input type='text' name='updates[$db_field]' value='" . htmlspecialchars($faculty[$db_field]) . "' required>";
                    echo "</div>";
                    echo "<div class='button-group'>";
                    echo "<button type='submit' class='save-btn'>Save</button>";
                    echo "<button type='button' class='cancel-btn' onclick=\"toggleEditForm('edit_faculty_$db_field')\">Cancel</button>";
                    echo "</div>";
                    echo "</form>";
                    echo "</div>";
                }
                
                echo "</div></div>";
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
            $result = $stmt->get_result(); // Added semicolon here
        
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
                                    <input type='hidden' name='edit_entry' value='1'>
                                    <input type='hidden' name='table_name' value='$table'>
                                    <input type='hidden' name='row_id' value='{$row[$columns[0]]}'>";
                        
                        foreach ($filtered_columns as $col) {
                            if ($col !== "id") {
                                echo "<div class='form-group'>";
                                echo "<label>" . ucfirst(str_replace("_", " ", $col)) . ":</label>";
                                echo "<input type='text' name='updates[$col]' value='" . htmlspecialchars($row[$col]) . "' required>";
                                echo "</div>";
                            }
                        }
                        
                        echo "<div class='button-group'>
                                <button type='submit' class='save-btn'>Save</button>
                                <button type='button' class='cancel-btn' onclick=\"toggleEditForm('edit_{$table}_{$row[$columns[0]]}')\">Cancel</button>
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

            // Add New Entry Form
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
            echo "<button type='button' class='cancel-btn' onclick=\"toggleAddForm('add_$table')\">Cancel</button>";
            echo "</div></form></div>";
        }
        ?>

    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Faculty Dashboard. All rights reserved.</p>
    </footer>
</body>
</html>