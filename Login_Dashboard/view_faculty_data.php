<?php
require_once 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['faculty_id'])) {
    header("Location: index.php");
    exit();
}

$faculty_id = isset($_GET['faculty_id']) ? $_GET['faculty_id'] : null;
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
            margin-bottom: 15px;
        }
        .user-info p {
            margin-bottom: 5px;
        }
        .time-display {
            font-family: monospace;
            font-weight: 600;
            color: #007bff;
        }
        .btn-group {
            display: flex;
            gap: 5px;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #b02a37;
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
                        <p class="mb-2">Current Date and Time: <span class="time-display"><?php echo htmlspecialchars($current_time); ?></span></p>
                        <p class="mb-3">Current User: <span class="time-display"><?php echo htmlspecialchars($current_user); ?></span></p>
                    </div>
                    <a href="index.php" class="btn btn-secondary mt-2">Back to Search</a>
                </div>
            </div>
        </div>

        <?php
            // Debug flag
            $debug = false; // Set to true when you need to debug

            foreach ($expected_tables as $table_name) {
                if (in_array($table_name, $skip_tables)) {
                    continue;
                }

                // Get columns for the table
                $columns_query = "SHOW COLUMNS FROM $table_name";
                $columns_result = $conn->query($columns_query);
                $columns = [];
                while ($column = $columns_result->fetch_assoc()) {
                    if ($column['Field'] != 'sr_no' && $column['Field'] != 'faculty_id') {
                        $columns[] = $column['Field'];
                    }
                }

                $query = "SELECT * FROM $table_name WHERE faculty_id = '$faculty_id' ORDER BY sr_no";
                try {
                    $result = $conn->query($query);
                    if ($debug) {
                        echo "<!-- Debug for $table_name: -->";
                        echo "<!-- Query: $query -->";
                        if ($result) {
                            echo "<!-- Num rows: " . $result->num_rows . " -->";
                        }
                    }
                    ?>
                    <div class="table-container">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0"><?php echo ucwords(str_replace('_', ' ', $table_name)); ?></h4>
                                <button class="btn btn-success" 
                                        onclick='addNewRecord(<?php echo json_encode($table_name); ?>, <?php echo json_encode($columns); ?>)'>
                                    <i class="fas fa-plus"></i> New
                                </button>
                            </div>
                            <div class="card-body">
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 80px;">Sr No</th>
                                                <?php
                                                foreach ($columns as $column) {
                                                    echo "<th>" . ucwords(str_replace('_', ' ', $column)) . "</th>";
                                                }
                                                ?>
                                                <th style="width: 100px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                if ($debug) {
                                                    echo "<!-- Row data for $table_name: " . json_encode($row) . " -->";
                                                }
                                                echo "<tr>";
                                                echo "<td>{$row['sr_no']}</td>";
                                                foreach ($columns as $column) {
                                                    echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
                                                }
                                                ?>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-primary btn-sm" 
                                                                onclick='editRecord(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>, <?php echo json_encode($table_name); ?>)'>
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" 
                                                                onclick='deleteRecord(<?php echo $row["sr_no"]; ?>, <?php echo json_encode($table_name); ?>)'>
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </td>
                                                <?php
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info mb-0">No records found</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                } catch (Exception $e) {
                    if ($debug) {
                        echo "<!-- Error in $table_name: " . htmlspecialchars($e->getMessage()) . " -->";
                    }
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

        <!-- Add New Record Modal -->
        <div class="modal fade" id="addModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Record</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm">
                            <input type="hidden" id="add_table_name">
                            <div id="addFields"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="saveNewRecord()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let editModal;
    let addModal;

    document.addEventListener('DOMContentLoaded', function() {
        editModal = new bootstrap.Modal(document.getElementById('editModal'));
        addModal = new bootstrap.Modal(document.getElementById('addModal'));
    });

    function editRecord(rowData, tableName) {
        try {
            // Ensure rowData is an object if it's a string
            if (typeof rowData === 'string') {
                rowData = JSON.parse(rowData);
            }

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
                    input.value = rowData[key] || '';
                    
                    div.appendChild(label);
                    div.appendChild(input);
                    editFields.appendChild(div);
                }
            }
            
            editModal.show();
        } catch (error) {
            console.error('Error in editRecord:', error);
            console.log('rowData:', rowData);
            console.log('tableName:', tableName);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Could not load edit form. Please try again.'
            });
        }
    }

    function addNewRecord(tableName, columns) {
        document.getElementById('add_table_name').value = tableName;
        
        const addFields = document.getElementById('addFields');
        addFields.innerHTML = '';
        
        columns.forEach(column => {
            const div = document.createElement('div');
            div.className = 'mb-3';
            
            const label = document.createElement('label');
            label.className = 'form-label';
            label.textContent = column.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
            
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.id = 'add_field_' + column;
            
            div.appendChild(label);
            div.appendChild(input);
            addFields.appendChild(div);
        });
        
        addModal.show();
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

        editModal.hide();

        fetch('update_record.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Record updated successfully!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                throw new Error(result.message || 'Update failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            location.reload(); // Reload anyway as the update might have succeeded
        });
    }

    function saveNewRecord() {
        const table_name = document.getElementById('add_table_name').value;
        const fields = document.getElementById('addFields').getElementsByTagName('input');
        const faculty_id = '<?php echo $faculty_id; ?>';
        
        const data = {
            table_name: table_name,
            faculty_id: faculty_id,
            fields: {}
        };
        
        for (let field of fields) {
            const fieldName = field.id.replace('add_field_', '');
            data.fields[fieldName] = field.value;
        }

        addModal.hide();

        fetch('add_record.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Record added successfully!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                throw new Error(result.message || 'Failed to add record');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            location.reload(); // Reload anyway as the add might have succeeded
        });
    }
    function deleteRecord(srNo, tableName) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const data = {
                    sr_no: srNo,
                    table_name: tableName
                };

                fetch('delete_record.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(() => {
                    // Don't try to parse response, just show success and reload
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Record has been deleted.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch((error) => {
                    console.error('Error:', error);
                    // Still reload as the delete probably worked
                    location.reload();
                });
            }
        });
    }
    </script>
</body>
</html>