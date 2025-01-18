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

// Handle form submission for faculty_table
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['faculty_table_edit'])) {
    $update_field = $_POST['field_name'];
    $new_value = $conn->real_escape_string($_POST['new_value']);

    $update_query = "UPDATE faculty_table SET $update_field = ? WHERE faculty_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_value, $faculty_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Updated successfully!'); window.location.href='dashboard.php?faculty_id=$faculty_id';</script>";
    } else {
        echo "<script>alert('Update failed. Try again!');</script>";
    }

    $stmt->close();
}

// Tables except faculty_table
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
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header, footer { background-color: #0073e6; color: white; text-align: center; padding: 1rem; }
        main { padding: 2rem; }
        .table-section { margin-bottom: 2rem; background-color: #fff; padding: 25px; border-radius: 12px; box-shadow: rgba(0, 0, 0, 0.2) 0px 1px 5px; }
        table { width: 100%; border-collapse: collapse; background-color: #fff; border-radius: 10px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #4A90E2; color: white; }
        img { max-width: 150px; border-radius: 10px; }
        .edit-btn { background-color: #28a745; color: white; padding: 5px 10px; border: none; cursor: pointer; }
        .edit-form { display: none; margin-top: 10px; }
        .save-btn { background-color: #0073e6; color: white; padding: 5px 10px; border: none; cursor: pointer; }
        .faculty-details { margin-bottom: 2rem; }
    </style>
    <script>
        function toggleEditForm(id) {
            var form = document.getElementById(id);
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
</head>
<body>
    <header>
        <h1>Faculty Dashboard - ID: <?php echo htmlspecialchars($faculty_id); ?></h1>
    </header>
    <main>

        <!-- 🎯 Faculty Details Section (Editable) -->
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
                echo "<table border='0' class='details'>";
                echo "<tr><td rowspan='6'><img src='" . htmlspecialchars($faculty['image']) . "' alt='Faculty Image'></td>";
                
                // Editable Fields
                $fields = [
                    'name' => 'Name',
                    'department_name' => 'Department',
                    'email_id' => 'Email',
                    'contact_no' => 'Phone',
                    'Designation' => 'Designation'
                ];

                foreach ($fields as $db_field => $label) {
                    echo "<tr><td><strong>$label:</strong> " . htmlspecialchars($faculty[$db_field]) . " ";
                    echo "<button class='edit-btn' onclick=\"toggleEditForm('$db_field')\">Edit</button>";
                    echo "<form id='$db_field' class='edit-form' method='POST' style='display:none;'>";
                    echo "<input type='hidden' name='faculty_table_edit' value='1'>";
                    echo "<input type='hidden' name='field_name' value='$db_field'>";
                    echo "<input type='text' name='new_value' value='" . htmlspecialchars($faculty[$db_field]) . "' required>";
                    echo "<button type='submit' class='save-btn'>Save</button>";
                    echo "</form></td></tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No data found for this faculty.</p>";
            }
            $stmt->close();
            ?>
        </div>

        <!-- 📌 Dynamic Tables for Other Faculty Data -->
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
                echo "<table>";
                echo "<tr>";
                $columns = array_keys($result->fetch_assoc());
                foreach ($columns as $col) {
                    echo "<th>" . ucfirst(str_replace("_", " ", $col)) . "</th>";
                }
                echo "<th>Action</th>";
                echo "</tr>";

                $result->data_seek(0);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($columns as $col) {
                        echo "<td>" . htmlspecialchars($row[$col]) . "</td>";
                    }
                    echo "<td>";
                    echo "<button class='edit-btn' onclick=\"toggleEditForm('$table-{$row[$columns[0]]}')\">Edit</button>";
                    echo "<form id='$table-{$row[$columns[0]]}' class='edit-form' method='POST' style='display:none;'>";
                    echo "<input type='hidden' name='table_name' value='$table'>";
                    echo "<input type='hidden' name='field_name' value='{$columns[1]}'>";
                    echo "<input type='text' name='new_value' value='" . htmlspecialchars($row[$columns[1]]) . "' required>";
                    echo "<button type='submit' class='save-btn'>Save</button>";
                    echo "</form>";
                    echo "</td></tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No data found.</p>";
            }

            $stmt->close();
            echo "</div>";
        }
        ?>

    </main>
</body>
</html>
