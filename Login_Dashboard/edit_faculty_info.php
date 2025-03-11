<?php
require_once 'config.php';

// Constants for current time and user
define('CURRENT_TIME', '2025-02-02 09:07:30');
define('CURRENT_USER', 'vky6366');

// Check if faculty_id is provided
if (!isset($_GET['faculty_id'])) {
    header("Location: error.php?message=No faculty ID provided");
    exit();
}

$faculty_id = $conn->real_escape_string($_GET['faculty_id']);

// Fetch faculty data
$sql = "SELECT * FROM faculty_table WHERE faculty_id = '$faculty_id'";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    header("Location: error.php?message=Faculty not found");
    exit();
}

$faculty_data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Faculty Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
        }

        .header h1 {
            color: rgb(43, 69, 152);
            margin: 0;
        }

        .back-button {
            background-color: rgb(43, 69, 152);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: rgb(33, 53, 121);
            color: white;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        .current-image {
            margin-bottom: 20px;
        }

        .btn-save {
            background-color: #28a745;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-save:hover {
            background-color: #218838;
        }

        .success-message, .error-message {
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            display: none;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
    </style>
</head>
<body>
<div class="container-fluid mt-4 mb-5">
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
    
    <div class="container">
        <div class="header">
            <h1>Edit Faculty Information</h1>
            <a href="view_faculty_data.php?faculty_id=<?php echo htmlspecialchars($faculty_id); ?>" class="back-button">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <form id="facultyForm" enctype="multipart/form-data">
            <!-- Image Preview and Upload Section -->
            <div class="form-group text-center">
                <div class="current-image">
                    <?php 
                    if (!empty($faculty_data['image'])) {
                        // For debugging
                        $image_path = '../Display/' . $faculty_data['image'];
                        echo "<!-- Debug: Image path is: " . htmlspecialchars($image_path) . " -->";
                        
                        // Check if file exists
                        if (file_exists($image_path)) {
                            echo '<img src="' . htmlspecialchars($image_path) . '" 
                                alt="Current Faculty Image" 
                                class="img-fluid rounded" 
                                style="max-width: 500px; max-height: 500px; object-fit: cover;">';
                        } else {
                            // If file doesn't exist, show default with error comment
                            echo "<!-- Debug: Image file not found at: " . htmlspecialchars($image_path) . " -->";
                            echo '<img src="../Display/img/default_profile.png" 
                                alt="Default Profile" 
                                class="img-fluid rounded" 
                                style="max-width: 500px; max-height: 500px; object-fit: cover;">';
                        }
                    } else {
                        // No image path in database
                        echo "<!-- Debug: No image path in database -->";
                        echo '<img src="../Display/img/default_profile.png" 
                            alt="Default Profile" 
                            class="img-fluid rounded" 
                            style="max-width: 500px; max-height: 500px; object-fit: cover;">';
                    }
                    
                    // Debug output
                    echo "<!-- Debug: Current directory: " . getcwd() . " -->";
                    echo "<!-- Debug: Faculty image data: " . htmlspecialchars(print_r($faculty_data['image'], true)) . " -->";
                    ?>
                </div>
                
                <!-- Preview of selected image before upload -->
                <div id="imagePreview" class="mt-3" style="display: none;">
                    <h5>Selected Image Preview:</h5>
                    <img id="preview" src="#" alt="Preview" 
                        class="img-fluid rounded" 
                        style="max-width: 500px; max-height: 500px; object-fit: cover;">
                </div>

                <label for="faculty_image" class="mt-3">Update Faculty Image</label>
                <input type="file" 
                    id="faculty_image" 
                    name="faculty_image" 
                    accept="image/jpeg,image/png,image/gif,image/webp,image/bmp" 
                    class="form-control">
                <small class="text-muted">Supported formats: JPEG, PNG, GIF, WEBP, BMP</small>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="faculty_id">Faculty ID:</label>
                        <input type="text" 
                               id="faculty_id" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($faculty_data['faculty_id']); ?>" 
                               readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" 
                               id="name" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($faculty_data['name']); ?>" 
                               required>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department_name">Department:</label>
                            <select id="department_name" 
                                    class="form-control" 
                                    required>
                                <option value="">Select Department</option>
                                <option value="Artificial Intelligence & Data Science" <?php echo ($faculty_data['department_name'] == 'Artificial Intelligence & Data Science') ? 'selected' : ''; ?>>Artificial Intelligence & Data Science</option>
                                <option value="Chemistry" <?php echo ($faculty_data['department_name'] == 'Chemistry') ? 'selected' : ''; ?>>Chemistry</option>
                                <option value="Civil Engineering" <?php echo ($faculty_data['department_name'] == 'Civil Engineering') ? 'selected' : ''; ?>>Civil Engineering</option>
                                <option value="Computer Science & Engineering" <?php echo ($faculty_data['department_name'] == 'Computer Science & Engineering') ? 'selected' : ''; ?>>Computer Science & Engineering</option>
                                <option value="Diploma" <?php echo ($faculty_data['department_name'] == 'Diploma') ? 'selected' : ''; ?>>Diploma</option>
                                <option value="Electrical & Electronic Engineering" <?php echo ($faculty_data['department_name'] == 'Electrical & Electronic Engineering') ? 'selected' : ''; ?>>Electrical & Electronic Engineering</option>
                                <option value="Electronics & Communication Engineering" <?php echo ($faculty_data['department_name'] == 'Electronics & Communication Engineering') ? 'selected' : ''; ?>>Electronics & Communication Engineering</option>
                                <option value="M.Tech(Civil)" <?php echo ($faculty_data['department_name'] == 'M.Tech(Civil)') ? 'selected' : ''; ?>>M.Tech(Civil)</option>
                                <option value="M.Tech(Mechanical)" <?php echo ($faculty_data['department_name'] == 'M.Tech(Mechanical)') ? 'selected' : ''; ?>>M.Tech(Mechanical)</option>
                                <option value="Mathematics" <?php echo ($faculty_data['department_name'] == 'Mathematics') ? 'selected' : ''; ?>>Mathematics</option>
                                <option value="MBA" <?php echo ($faculty_data['department_name'] == 'MBA') ? 'selected' : ''; ?>>MBA</option>
                                <option value="MCA" <?php echo ($faculty_data['department_name'] == 'MCA') ? 'selected' : ''; ?>>MCA</option>
                                <option value="Mechanical Engineering" <?php echo ($faculty_data['department_name'] == 'Mechanical Engineering') ? 'selected' : ''; ?>>Mechanical Engineering</option>
                                <option value="Physics" <?php echo ($faculty_data['department_name'] == 'Physics') ? 'selected' : ''; ?>>Physics</option>
                                <option value="Robotics & Automation" <?php echo ($faculty_data['department_name'] == 'Robotics & Automation') ? 'selected' : ''; ?>>Robotics & Automation</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Designation">Designation:</label>
                        <input type="text" 
                               id="Designation" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($faculty_data['Designation']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="date_of_joining">Date of Joining:</label>
                        <input type="date" 
                               id="date_of_joining" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($faculty_data['date_of_joining']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="email_id">Email ID:</label>
                        <input type="email" 
                               id="email_id" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($faculty_data['email_id']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="orchid_id">Email ID:</label>
                        <input type="text" 
                               id="orchid_id" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($faculty_data['orchid_id']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="scholar">Email ID:</label>
                        <input type="text" 
                               id="scholar" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($faculty_data['scholar']); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="contact_no">Contact No:</label>
                        <input type="text" 
                               id="contact_no" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($faculty_data['contact_no']); ?>" 
                               required>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>

        <div class="success-message"></div>
        <div class="error-message"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        document.getElementById('facultyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('faculty_id', document.getElementById('faculty_id').value);
            
            const fields = {
                name: document.getElementById('name').value,
                department_name: document.getElementById('department_name').value,
                Designation: document.getElementById('Designation').value,
                date_of_joining: document.getElementById('date_of_joining').value,
                email_id: document.getElementById('email_id').value,
                contact_no: document.getElementById('contact_no').value
            };
            
            formData.append('fields', JSON.stringify(fields));
            
            // Add image if selected
            const imageFile = document.getElementById('faculty_image').files[0];
            if (imageFile) {
                formData.append('faculty_image', imageFile);
            }

            fetch('update_faculty.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    document.querySelector('.success-message').textContent = 'Changes saved successfully!';
                    document.querySelector('.success-message').style.display = 'block';
                    document.querySelector('.error-message').style.display = 'none';
                    
                    // Redirect after 1.5 seconds
                    setTimeout(() => {
                        window.location.href = 'view_faculty_data.php?faculty_id=' + 
                            document.getElementById('faculty_id').value;
                    }, 1500);
                } else {
                    document.querySelector('.error-message').textContent = result.message;
                    document.querySelector('.error-message').style.display = 'block';
                    document.querySelector('.success-message').style.display = 'none';
                }
            })
            .catch(error => {
                document.querySelector('.error-message').textContent = 'An error occurred while saving changes.';
                document.querySelector('.error-message').style.display = 'block';
                document.querySelector('.success-message').style.display = 'none';
            });
        });

        // Preview image before upload
        document.getElementById('faculty_image').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.current-image img').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>