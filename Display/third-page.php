<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the faculty_id from the URL
$faculty_id = isset($_GET['faculty_id']) ? $_GET['faculty_id'] : null;
if (!$faculty_id) {
    die("Error: Faculty ID not provided.");
}

// List of tables
$tables = [
    'faculty_table',
    'experience',
    'certificates',
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
    'students_project_grants',
    'others'
];

// Function to check image accessibility
function check_image_path($path) {
    if (empty($path)) return false;
    if (!file_exists($path)) return false;
    if (!is_readable($path)) return false;
    return true;
}
function getValidImagePath($img_file_name) {
    // Since we're in Display/third-page.php, the img directory is adjacent
    $base_path = "img/";
    
    // Clean the filename to prevent directory traversal
    $img_file_name = basename($img_file_name);
    
    // Construct and validate the path
    $full_path = realpath(__DIR__ . '/' . $base_path . $img_file_name);
    
    if (!empty($img_file_name) && $full_path !== false && file_exists($full_path)) {
        return $base_path . $img_file_name;
    }
    
    return $base_path . "default.jpg"; // Default image in the img directory
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            background-color: rgb(238, 235, 240);
            height: 40px;
            width: auto;
            display: flex;
            flex-direction: row;
            justify-content: start;
            margin: 0;
            padding: 0;
        }

        .real {
            background-color: white;
            color: white;
            padding: 0;
            text-align: center;
            height: auto;
            width: auto;
            margin: 0;
        }

        .row {
            background-color: rgb(238, 235, 240);
            color: rgb(29, 28, 28);
            height: 50%;
            width: 20%;
            margin-right: 60%;
            margin-top: 10px;
            margin-left: 10px;
        }

        .container1 {
            background-color: rgb(255, 255, 255);
            color: rgb(43, 69, 152);
            height: 120px;
            width: auto;
            position: sticky;
        }

        .row1 {
            background-color: rgb(255, 255, 255);
            align-items: center;
            justify-content: space-between;
            text-align: center;
            display: flex;
            flex-direction: row;
            width: 80%;
            margin-left: 10%;
        }

        .site_header_1 {
            height: 100px;
            width: 100px;
        }

        .photo {
            height: 100%;
            width: 100%;
            margin-top: 2px;
        }

        /* New styles for timestamp and user info */
        .meta-info {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #4A90E2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .timestamp, .user-login {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .timestamp i, .user-login i {
            color: #4A90E2;
        }

        .time-value, .user-value {
            font-family: 'Roboto Mono', monospace;
            background: white;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
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

        .time-display {
            font-family: 'Roboto Mono', monospace;
            font-weight: 500;
            color: #0d6efd;
            background: white;
            padding: 3px 8px;
            border-radius: 4px;
            margin-left: 5px;
        }

        header {
            background-color: rgb(255, 255, 255);
            color: black;
            text-align: center;
            padding: 1rem;
            height: 50px;
            font-size: small;
            font-weight: normal;
        }

        main {
            padding: 2rem;
        }

        img {
            width: 200px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            object-fit: cover;
        }

        .details {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .faculty-details {
            margin-bottom: 2rem;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .faculty-details img {
            margin-right: 1rem;
            float: left;
        }

        /* Updated table section styles */
        .table-section {
            margin-bottom: 2rem;
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: rgba(9, 30, 66, 0.4) 0px 1px 1px, rgba(9, 30, 66, 0.4) 0px 0px 1px 1px;
            text-align: center;  /* Changed from left to center */
            overflow-x: auto;
            max-width: 100%;
        }

        /* Scroll indicator */
        .scroll-indicator {
            color: #666;
            font-size: 0.8rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .scroll-indicator i {
            color: #4A90E2;
        }

        /* Table styles */
        table {
            width: 100%;
            min-width: 800px;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            margin: 0 auto;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            min-width: 150px;
            word-wrap: break-word;
            white-space: normal;
            vertical-align: top;
        }

        /* Sticky first column */
        th:first-child,
        td:first-child {
            position: sticky;
            left: 0;
            background: inherit;
            z-index: 1;
            min-width: 70px;
            max-width: 70px;
        }

        th {
            background-color: #4A90E2;
            color: white;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        th:first-child {
            z-index: 3;
            background: #4A90E2;
        }

        tr:nth-child(even) td:first-child {
            background: #fff;
        }

        tr:nth-child(odd) td:first-child {
            background: #fff;
        }

        /* Scrollbar styling */
        .table-section::-webkit-scrollbar {
            height: 8px;
        }

        .table-section::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-section::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .table-section::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Download button styling */
        .download-section {
            text-align: right;
            margin-bottom: 20px;
        }

        .download-btn {
            background-color: #2b4598;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .download-btn:hover {
            background-color: #1a2f6e;
        }

        footer {
            background-color: rgb(43, 69, 152);
            color: rgb(255, 255, 255);
            text-align: center;
            padding: 10px 20px;
            bottom: 0;
            width: 100%;
            position: relative;
        }
    </style>
</head>
<body>
    <div class="real">
        <div class="container">
            <div class="row">
                <div class="site_topbar">
                </div>
            </div>
        </div>
    </div>

    <div class="container1">
        <div class="row1">
            <div class="site_header_1">
                <h2 class="web_title">
                    <a class="back" href="https://aitmbgm.ac.in">
                        <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/Suresh-Angadi.jpg"
                            alt="AITMBGM" title="AITMBGM">
                    </a>
                </h2>
            </div>

            <div class="site_header_2">
                <h2 class="web_title">
                    <a class="back" href="https://aitmbgm.ac.in">
                        <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitmbgm-logo.png"
                            alt="AITMBGM" title="AITMBGM">
                    </a>
                </h2>
            </div>

            <div class="site_header_3">
                <h6>SURESH ANGADI EDUCATION FOUNDATIONS</h6>
                <h2>ANGADI INSTITUTE OF TECHNOLOGY AND MANAGEMENT</h2>
                <span>Approved by AICTE, New Delhi, Affiliated to VTU, Belagavi.<br>Accredited by *NBA and NAAC</span>
            </div>

            <div class="site_header_4">
                <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitm-logo.png" 
                     alt="AITM" title="AITM">
            </div>
        </div>
    </div>
    <main>
        <div class='container4'>
        <div class="download-section" style="text-align: right; margin-bottom: 20px;">
        <a href="download_faculty_data.php?faculty_id=<?php echo htmlspecialchars($faculty_id); ?>" 
           class="download-btn" 
           style="background-color: rgb(43, 69, 152); 
                  color: white; 
                  padding: 10px 20px; 
                  text-decoration: none; 
                  border-radius: 5px;
                  display: inline-flex;
                  align-items: center;
                  gap: 8px;">
            <i class="fas fa-download"></i> Download Excel
        </a>
        <?php
        // Custom handling for faculty_table
        if (in_array('faculty_table', $tables)) {
            $sql = "SELECT * FROM faculty_table WHERE faculty_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $faculty_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $faculty = $result->fetch_assoc();
                echo "<div class='faculty-details'>";
                echo "<table class='faculty_details'>";
                
                // Image handling with error checking
                $img_file_name = $faculty['image'];
                $image_path = "../Display/img" . $img_file_name;
                echo "<tr>";
                if (!empty($img_file_name)) {
                    $image_path = getValidImagePath($img_file_name);
                    echo "<td rowspan='9'><img src='" . htmlspecialchars($image_path) . "' 
                          alt='Faculty Image' 
                          style='height: 200px; border-radius: 5px;'
                          onerror=\"this.src='img/default.jpg'\"></td>";
                } else {
                    echo "<td rowspan='9'><img src='img/default.jpg' 
                          alt='No Image Available' 
                          style='height: 200px; border-radius: 5px;'></td>";
                }
                echo "<td><strong>Name:</strong> " . htmlspecialchars($faculty['name']) . "</td></tr>";
                echo "<tr><td><strong>Faculty ID:</strong> " . htmlspecialchars($faculty['faculty_id']) . "</td></tr>";
                echo "<tr><td><strong>Department:</strong> " . htmlspecialchars($faculty['department_name']) . "</td></tr>";
                echo "<tr><td><strong>Email:</strong> " . htmlspecialchars($faculty['email_id']) . "</td></tr>";
                echo "<tr><td><strong>Phone:</strong> " . htmlspecialchars($faculty['contact_no']) . "</td></tr>";
                echo "<tr><td><strong>Designation:</strong> " . htmlspecialchars($faculty['Designation']) . "</td></tr>";
                echo "<tr><td><strong>Date Of Joining:</strong> " . htmlspecialchars($faculty['date_of_joining']) . "</td></tr>";
                echo "<tr><td><strong>Orchid ID:</strong> " . htmlspecialchars($faculty['orchid_id']) . "</td></tr>";
                echo "<tr><td><strong>Scholar:</strong> <a href='" . htmlspecialchars($faculty['scholar']) . "' target='_blank'>" . htmlspecialchars($faculty['scholar']) . "</a></td></tr>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p>No data found for the faculty.</p>";
            }
            $stmt->close();
        }

        // Display other tables
        foreach ($tables as $table) {
            if ($table === 'faculty_table') continue;

            echo "<div class='table-section'>";
            echo "<h2>" . ucfirst(str_replace("_", " ", $table)) . "</h2>";

            $sql = "SELECT * FROM $table WHERE faculty_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $faculty_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr><th>S.No</th>";

                $fields = $result->fetch_fields();
                foreach ($fields as $field) {
                    if (in_array($field->name, ['faculty_id', 'sr_no'])) continue;
                    echo "<th>" . ucfirst(str_replace("_", " ", $field->name)) . "</th>";
                }
                echo "</tr></thead><tbody>";

                $serial_number = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $serial_number++ . "</td>";
                    foreach ($row as $key => $value) {
                        if (in_array($key, ['faculty_id', 'sr_no'])) continue;
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No data found for this section.</p>";
            }
            echo "</div>";
            $stmt->close();
        }
        ?>
    </div>
    </main>

    <footer>
        <h2>Angadi Institute Of Technology And Management</h2>
    </footer>

</body>
</html>
<?php $conn->close(); ?>
