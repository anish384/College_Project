<?php
require_once 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['faculty_id'])) {
    header("Location: index.php");
    exit();
}

$faculty_id = $conn->real_escape_string($_GET['faculty_id']);
$current_user = 'vky6366';
$current_time = date('Y-m-d H:i:s');

// Tables to skip
$skip_tables = ['departments', 'faculty_table'];

// Define all expected tables
$expected_tables = [
    'awards',
    'books_bookchapter',
    'chair_resource',
    'conference',
    'experience',
    'fdp_conferences_attended',
    'for_scholars_dr',
    'journals',
    'mtech_guided',
    'others',
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
    <title>Faculty Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add SweetAlert2 for better alerts -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .table-container { margin-bottom: 30px; }
        .info-header { 
            background-color: #f8f9fa; 
            padding: 15px; 
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f1f1f1;
            padding: 15px;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .user-info {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4 mb-5">
        <div class="info-header">
            <div class="row">
                <div class="col-md-6">
                    <h2>Faculty Database Records</h2>
                    <h5>Faculty ID: <?php echo htmlspecialchars($faculty_id); ?></h5>
                </div>
                <div class="col-md-6 text-end">
                    <div class="user-info">
                        <p class="mb-2">Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted): <?php echo htmlspecialchars($current_time); ?></p>
                        <p class="mb-3">Current User's Login: <?php echo htmlspecialchars($current_user); ?></p>
                    </div>
                    <a href="index.php" class="btn btn-secondary">Back to Search</a>
                </div>
            </div>
        </div>

        <?php
        foreach ($expected_tables as $table_name) {
            if (in_array($table_name, $skip_tables)) {
                continue;
            }

            $query = "SELECT * FROM $table_name WHERE faculty_id = '$faculty_id' ORDER BY sr_no";
            try {
                $result = $conn->query($query);
                
                if ($result && $result->num_rows > 0) {
                    $columns = array_keys($result->fetch_assoc());
                    $result->data_seek(0); // Reset pointer
                    ?>
                    <div class="table-container">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0"><?php echo ucwords(str_replace('_', ' ', $table_name)); ?></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 80px;">Sr No</th>
                                                <?php
                                                foreach ($columns as $column) {
                                                    if ($column != 'sr_no' && $column != 'faculty_id') {
                                                        echo "<th>" . ucwords(str_replace('_', ' ', $column)) . "</th>";
                                                    }
                                                }
                                                ?>
                                                <th style="width: 100px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>{$row['sr_no']}</td>";
                                                foreach ($columns as $column) {
                                                    if ($column != 'sr_no' && $column != 'faculty_id') {
                                                        echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
                                                    }
                                                }
                                                ?>
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-sm" 
                                                            onclick='editRecord(<?php echo json_encode($row); ?>, <?php echo json_encode($table_name); ?>)'>
                                                        Edit
                                                    </button>
                                                </td>
                                                <?php
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } catch (Exception $e) {
                continue;
            }
        }
        ?>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Record</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            <input type="hidden" id="edit_sr_no">
                            <input type="hidden" id="edit_table_name">
                            <div id="editFields"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateRecord()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let editModal;
    
    document.addEventListener('DOMContentLoaded', function() {
        editModal = new bootstrap.Modal(document.getElementById('editModal'));
    });

    function editRecord(rowData, tableName) {
        document.getElementById('edit_sr_no').value = rowData.sr_no;
        document.getElementById('edit_table_name').value = tableName;
        
        const editFields = document.getElementById('editFields');
        editFields.innerHTML = '';
        
        for (let key in rowData) {
            if (key !== 'sr_no' && key !== 'faculty_id') {
                const div = document.createElement('div');
                div.className = 'mb-3';
                
                const label = document.createElement('label');
                label.className = 'form-label';
                label.textContent = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
                
                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control';
                input.id = 'edit_field_' + key;
                input.value = rowData[key];
                
                div.appendChild(label);
                div.appendChild(input);
                editFields.appendChild(div);
            }
        }
        
        editModal.show();
    }

    function updateRecord() {
        const sr_no = document.getElementById('edit_sr_no').value;
        const table_name = document.getElementById('edit_table_name').value;
        const fields = document.getElementById('editFields').getElementsByTagName('input');
        
        const data = {
            sr_no: sr_no,
            table_name: table_name,
            fields: {}
        };
        
        for (let field of fields) {
            const fieldName = field.id.replace('edit_field_', '');
            data.fields[fieldName] = field.value;
        }

        // Close the modal first
        editModal.hide();

        fetch('update_record.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(() => {
            // Show success message and reload
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Record updated successfully!',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        })
        .catch(() => {
            // Even on error, reload to show current data
            location.reload();
        });
    }
    </script>
</body>
</html>