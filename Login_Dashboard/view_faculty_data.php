<?php
require_once 'config.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user has an active session
if (!isset($_SESSION['faculty_id']) || !isset($_SESSION['login_time']) || !isset($_SESSION['access_token'])) {
    // User is not logged in, redirect to login page
    header("Location: index.php");
    exit();
}

// Validate the token from URL
if (!isset($_GET['token']) || $_GET['token'] !== $_SESSION['access_token']) {
    // Invalid or missing token
    session_destroy();
    header("Location: index.php?error=invalid_session");
    exit();
}

// Check session timeout (30 minutes)
$timeout = 1800; // 30 minutes in seconds
if (time() - strtotime($_SESSION['login_time']) > $timeout) {
    // Session has expired
    session_destroy();
    header("Location: index.php?error=session_expired");
    exit();
}

// Get faculty_id from session (not from URL)
$faculty_id = $_SESSION['faculty_id'];

// Verify faculty exists in database using prepared statement
$stmt = $conn->prepare("SELECT faculty_id FROM faculty_table WHERE faculty_id = ?");
$stmt->bind_param("s", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Faculty ID doesn't exist
    session_destroy();
    header("Location: index.php?error=invalid_faculty");
    exit();
}
$stmt->close();

// Regenerate token periodically for extra security
if (time() - strtotime($_SESSION['login_time']) > 900) { // Every 15 minutes
    $new_token = bin2hex(random_bytes(32));
    $_SESSION['access_token'] = $new_token;
    $_SESSION['login_time'] = date('Y-m-d H:i:s');
    header("Location: view_faculty_data.php?token=" . urlencode($new_token));
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Tables to skip
$skip_tables = ['departments', 'faculty_table'];

// Define all expected tables
$expected_tables = [
    'awards',
    'books_bookchapter',
    'certificates',  // Add this line
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

// Get faculty details
$faculty_query = $conn->prepare("SELECT * FROM faculty_table WHERE faculty_id = ?");
$faculty_query->bind_param("s", $faculty_id);
$faculty_query->execute();
$faculty_result = $faculty_query->get_result();
$faculty_data = $faculty_result->fetch_assoc();
$faculty_query->close();

if (!$faculty_data) {
    header("Location: error.php?message=" . urlencode("Error retrieving faculty data"));
    exit();
}



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
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f5f6fa;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .containerm {
        background-color: #f8f9fa;
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .site_topbar {
        display: flex;
        align-items: center;
        gap: 20px;
        color: #333;
    }

    .site_topbar i {
        color: rgb(43, 69, 152);
        margin-right: 5px;
    }

    .container1 {
        background-color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 15px 0;
        margin-bottom: 30px;
    }

    .row1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 90%;
        margin: 0 auto;
        gap: 20px;
    }

    .site_header_3 {
        color: rgb(43, 69, 152);
        text-align: center;
    }

    .site_header_3 h6 {
        font-size: 1rem;
        margin-bottom: 8px;
    }

    .site_header_3 h2 {
        font-size: 1.5rem;
        margin-bottom: 8px;
    }

    .site_header_3 span {
        font-size: 0.9rem;
        color: #666;
    }

    /* Main Content Styles */
    .container-fluid {
        max-width: 1800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .info-header {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .user-info {
        background: linear-gradient(to right, rgb(43, 69, 152), #4a69bd);
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .time-display {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.1);
        padding: 5px 10px;
        border-radius: 4px;
        color: white;
    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        border: none;
    }

    .card-header {
        background: rgb(43, 69, 152);
        color: white;
        padding: 15px 20px;
        border-radius: 10px 10px 0 0;
        border-bottom: none;
    }

    .card-body {
        padding: 20px;
    }

    .table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        background: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 12px 15px;
        border-bottom: 2px solid #dee2e6;
    }

    .table td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: rgb(43, 69, 152);
        border: none;
    }

    .btn-primary:hover {
        background: #34508a;
    }

    .btn-success {
        background: #28a745;
        border: none;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-danger {
        background: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .btn-group {
        display: flex;
        gap: 5px;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 0.875rem;
    }

    .modal-content {
        border-radius: 10px;
        border: none;
    }

    .modal-header {
        background: rgb(43, 69, 152);
        color: white;
        border-radius: 10px 10px 0 0;
        padding: 15px 20px;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 8px 12px;
    }

    .form-control:focus {
        border-color: rgb(43, 69, 152);
        box-shadow: 0 0 0 0.2rem rgba(43, 69, 152, 0.25);
    }

    .alert {
        border-radius: 8px;
        padding: 15px 20px;
    }

    .alert-info {
        background-color: #e3f2fd;
        border-color: #bee5eb;
        color: #0c5460;
    }

    @media (max-width: 1200px) {
        .row1 {
            flex-direction: column;
            text-align: center;
        }

        .site_header_3 {
            margin: 15px 0;
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 10px;
        }

        .card-header {
            flex-direction: column;
            gap: 10px;
        }

        .btn-group {
            flex-direction: column;
        }
    }
    </style>
</head>
<body>
    <div class="container-fluid mt-4 mb-5">
        <div class="info-header">
            <div class="row">
            <div class="real">
            <div class="containerm">
                <div class="row">
                    <div class="site_topbar">
                        <i class="phone"></i> <b>0831-2438100/123</b>
                        <i class="envelope_icon"></i> info@aitmbgm.ac.in
                    </div>
                </div>
            </div>
        </div>

        <div class="container1">
            <div class="row1">
                <div class="site_header_1">
                    <h2 class="web_title">
                        <a class="back" href="https://aitmbgm.ac.in">
                            <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/Suresh-Angadi.jpg" alt="AITMBGM" title="AITMBGM">
                        </a>
                    </h2>
                </div>

                <div class="site_header_2">
                    <h2 class="web_title">
                        <a class="back" href="https://aitmbgm.ac.in">
                            <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitmbgm-logo.png" alt="AITMBGM" title="AITMBGM">
                        </a>
                    </h2>
                </div>

                <div class="site_header_3">
                    <h6>SURESH ANGADI EDUCATION FOUNDATIONS</h6>
                    <h2>ANGADI INSTITUTE OF TECHNOLOGY AND MANAGEMENT</h2>
                    <span>Approved by AICTE, New Delhi, Affiliated to VTU, Belagavi. <br>Accredited by *NBA and NAAC</span>
                </div>

                <div class="site_header_4">
                    <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitm-logo.png" alt="AITM" title="AITM">
                </div>
            </div>
        </div>

                    <a href="index.php" class="btn btn-secondary mt-2">Logout</a>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Faculty Information</h4>
                    <a href="edit_faculty_info.php?faculty_id=<?php echo htmlspecialchars($faculty_id); ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Faculty Info
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Add image column -->
                        <div class="col-md-3 text-center mb-3">
                            <?php 
                            if (!empty($faculty_data['image'])) {
                                // Get relative path to Display/img directory
                                $image_path = '../Display/' . $faculty_data['image'];
                                if (file_exists($image_path)) {
                                    echo '<img src="' . htmlspecialchars($image_path) . '" 
                                        alt="Faculty Image" 
                                        class="img-fluid rounded" 
                                        style="max-width: 750px; max-height: 750px; object-fit: cover;">';
                                } else {
                                    // Fallback to default if file doesn't exist
                                    echo '<img src="../Display/img/default_profile.png" 
                                        alt="Default Profile" 
                                        class="img-fluid rounded" 
                                        style="max-width: 200px; max-height: 200px; object-fit: cover;">';
                                }
                            } else {
                                // No image path in database
                                echo '<img src="../Display/img/default_profile.png" 
                                    alt="Default Profile" 
                                    class="img-fluid rounded" 
                                    style="max-width: 200px; max-height: 200px; object-fit: cover;">';
                            }
                            ?>
                        </div>
                        <!-- Faculty information table -->
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Faculty ID</th>
                                        <td><?php echo htmlspecialchars($faculty_data['faculty_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td><?php echo htmlspecialchars($faculty_data['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Designation</th>
                                        <td><?php echo htmlspecialchars($faculty_data['Designation']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td><?php echo htmlspecialchars($faculty_data['department_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date of Joining</th>
                                        <td><?php echo htmlspecialchars($faculty_data['date_of_joining']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email ID</th>
                                        <td><?php echo htmlspecialchars($faculty_data['email_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Orchid ID</th>
                                        <td><?php echo htmlspecialchars($faculty_data['orchid_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Google Scholar</th>
                                        <td><?php echo htmlspecialchars($faculty_data['scholar']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Contact No</th>
                                        <td><?php echo htmlspecialchars($faculty_data['contact_no']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
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
                                                // Initialize display counter for each table
                                                $display_sno = 1;

                                                while ($row = $result->fetch_assoc()) {
                                                    if ($debug) {
                                                        echo "<!-- Row data for $table_name: " . json_encode($row) . " -->";
                                                    }
                                                    echo "<tr>";
                                                    echo "<td>{$display_sno}</td>";  // Display sequential number
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
                                                    $display_sno++; // Increment the display counter
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

        <!-- Faculty Edit Modal -->
        <div class="modal fade" id="facultyEditModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Faculty Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="facultyEditForm">
                            <div class="mb-3">
                            <input type="hidden" id="faculty_id" name="faculty_id">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="faculty_name" name="name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Designation</label>
                                <input type="text" class="form-control" id="faculty_designation" name="designation">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" class="form-control" id="faculty_department" name="department_name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date of Joining</label>
                                <input type="date" class="form-control" id="faculty_doj" name="date_of_joining">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email ID</label>
                                <input type="email" class="form-control" id="faculty_email" name="email_id">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contact No</label>
                                <input type="text" class="form-control" id="faculty_contact" name="contact_no">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateFacultyInfo()">Save changes</button>
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

    let facultyEditModal;

    document.addEventListener('DOMContentLoaded', function() {
        // Add this line to your existing DOMContentLoaded handler
        facultyEditModal = new bootstrap.Modal(document.getElementById('facultyEditModal'));
    });

    function editFacultyInfo(facultyData) {
            document.getElementById('faculty_id').value = facultyData.faculty_id;
        document.getElementById('faculty_name').value = facultyData.name;
        document.getElementById('faculty_designation').value = facultyData.Designation;
        document.getElementById('faculty_department').value = facultyData.department_name;
        document.getElementById('faculty_doj').value = facultyData.date_of_joining;
        document.getElementById('faculty_email').value = facultyData.email_id;
        document.getElementById('faculty_contact').value = facultyData.contact_no;
        
        facultyEditModal.show();
}

    function updateFacultyInfo() {
        const formData = {
            faculty_id: document.getElementById('faculty_id').value,
            name: document.getElementById('faculty_name').value,
            designation: document.getElementById('faculty_designation').value,
            department_name: document.getElementById('faculty_department').value,
            date_of_joining: document.getElementById('faculty_doj').value,
            email_id: document.getElementById('faculty_email').value,
            contact_no: document.getElementById('faculty_contact').value
        };

        facultyEditModal.hide();

        fetch('update_faculty.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Faculty information updated successfully!',
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
            location.reload();
        });
    }

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

        console.log('Sending data:', data); // Debug log

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
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Failed to update record'
            }).then(() => {
                location.reload();
            });
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
    function updateFacultyInfo() {
        const formData = new FormData();
        const currentFacultyId = document.getElementById('faculty_id').value;
        
        const fields = {
            faculty_id: document.getElementById('faculty_id').value, // Include faculty_id in fields
            name: document.getElementById('faculty_name').value,
            Designation: document.getElementById('faculty_designation').value,
            department_name: document.getElementById('faculty_department').value,
            date_of_joining: document.getElementById('faculty_doj').value,
            email_id: document.getElementById('faculty_email').value,
            contact_no: document.getElementById('faculty_contact').value
        };

        formData.append('faculty_id', currentFacultyId);
        formData.append('fields', JSON.stringify(fields));

        // Add image if present
        const imageInput = document.getElementById('faculty_image');
        if (imageInput && imageInput.files.length > 0) {
            formData.append('faculty_image', imageInput.files[0]);
        }

        facultyEditModal.hide();

        fetch('update_faculty.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Faculty information updated successfully!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // Redirect if faculty_id changed
                    if (result.new_faculty_id && result.new_faculty_id !== currentFacultyId) {
                        window.location.href = `view_faculty_data.php?faculty_id=${result.new_faculty_id}`;
                    } else {
                        location.reload();
                    }
                });
            } else {
                throw new Error(result.message || 'Update failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Failed to update faculty information'
            });
        });
    }
    </script>
</body>
</html>
