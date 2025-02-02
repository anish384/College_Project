<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get table name from URL
$table = isset($_GET['table']) ? $_GET['table'] : '';

// List of valid tables
$valid_tables = [
    'faculty_table', 'experience', 'awards', 'books_bookchapter',
    'chair_resource', 'conference', 'fdp_conferences_attended',
    'for_scholars_dr', 'journals', 'mtech_guided', 'patents',
    'phd_guided_guiding', 'professional_memberships', 'qualification',
    'research_grants', 'research_grants_till_now', 'students_project_grants',
    'others'
];

if (!in_array($table, $valid_tables)) {
    die('Invalid table name');
}

$current_time = "2025-02-02 07:55:58";
$current_user = 'vky6366';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(str_replace('_', ' ', $table)); ?> Data</title>
    <!-- Keep your existing styles -->
    <style>
        /* Your existing styles here */
        
        /* Add these new styles */
        .edit-mode {
            background-color: #fff3cd;
        }
        
        .edit-controls {
            display: none;
        }
        
        .editing .edit-controls {
            display: inline-block;
        }
        
        .editing .edit-btn {
            display: none;
        }
        
        .btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .edit-btn {
            background-color: rgb(43, 69, 152);
            color: white;
        }
        
        .save-btn {
            background-color: #28a745;
            color: white;
        }
        
        .cancel-btn {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Keep your existing header HTML -->

    <div class="main-content">
        <div class="info-section">
            <div class="header">
                <h1><?php echo ucwords(str_replace('_', ' ', $table)); ?></h1>
                <a href="javascript:history.back()" class="back-button">← Back</a>
            </div>

            <div class="table-container">
                <?php
                try {
                    $sql = "SELECT * FROM $table";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table class='data-table' id='dataTable'>";
                        
                        // Headers
                        $fields = $result->fetch_fields();
                        echo "<thead><tr>";
                        
                        foreach ($fields as $field) {
                            echo "<th>" . ucwords(str_replace('_', ' ', $field->name)) . "</th>";
                        }
                        echo "<th>Actions</th>";
                        echo "</tr></thead><tbody>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-id='" . htmlspecialchars($row['faculty_id']) . "'>";
                            
                            foreach ($fields as $field) {
                                echo "<td data-field='" . $field->name . "'>" . 
                                     htmlspecialchars($row[$field->name] ?? '') . "</td>";
                            }

                            echo "<td>";
                            echo "<button class='btn edit-btn' onclick='editRow(this)'>Edit</button>";
                            echo "<div class='edit-controls'>";
                            echo "<button class='btn save-btn' onclick='saveRow(this)'>Save</button>";
                            echo "<button class='btn cancel-btn' onclick='cancelEdit(this)'>Cancel</button>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</tbody></table>";
                    } else {
                        echo "<p>No records found</p>";
                    }
                } catch (Exception $e) {
                    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
    let originalData = {};

    function editRow(button) {
        const row = button.closest('tr');
        const rowId = row.dataset.id;
        
        // Store original data
        originalData[rowId] = {};
        row.querySelectorAll('td[data-field]').forEach(cell => {
            originalData[rowId][cell.dataset.field] = cell.innerText;
            cell.contentEditable = true;
        });
        
        row.classList.add('editing');
        row.classList.add('edit-mode');
    }

    function cancelEdit(button) {
        const row = button.closest('tr');
        const rowId = row.dataset.id;
        
        // Restore original data
        row.querySelectorAll('td[data-field]').forEach(cell => {
            cell.innerText = originalData[rowId][cell.dataset.field];
            cell.contentEditable = false;
        });
        
        row.classList.remove('editing');
        row.classList.remove('edit-mode');
        delete originalData[rowId];
    }

    function saveRow(button) {
        const row = button.closest('tr');
        const rowId = row.dataset.id;
        const data = {
            faculty_id: rowId,
            table_name: '<?php echo $table; ?>',
            fields: {}
        };

        // Collect updated data
        row.querySelectorAll('td[data-field]').forEach(cell => {
            data.fields[cell.dataset.field] = cell.innerText;
        });

        console.log('Sending data:', data); // Debugging line

        // Send update request
        if (data.table_name === 'faculty_table') {
            updateFacultyTable(data);
        } else {
            updateGenericTable(data);
        }
    }

    function updateFacultyTable(data) {
        fetch('update_record.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            console.log('Response:', result); // Debugging line
            if (result.success) {
                const row = document.querySelector(`tr[data-id='${data.faculty_id}']`);
                row.classList.remove('editing');
                row.classList.remove('edit-mode');
                row.querySelectorAll('td[data-field]').forEach(cell => {
                    cell.contentEditable = false;
                });
                delete originalData[data.faculty_id];
                alert('Record updated successfully!');
            } else {
                alert('Error updating record: ' + result.message);
            }
        })
        .catch(error => {
            alert('Error updating record: ' + error);
        });
    }

    function updateGenericTable(data) {
        fetch('update_record.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            console.log('Response:', result); // Debugging line
            if (result.success) {
                const row = document.querySelector(`tr[data-id='${data.faculty_id}']`);
                row.classList.remove('editing');
                row.classList.remove('edit-mode');
                row.querySelectorAll('td[data-field]').forEach(cell => {
                    cell.contentEditable = false;
                });
                delete originalData[data.faculty_id];
                alert('Record updated successfully!');
            } else {
                alert('Error updating record: ' + result.message);
            }
        })
        .catch(error => {
            alert('Error updating record: ' + error);
        });
    }
    </script>
</body>
</html>
<?php $conn->close(); ?>