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

// Format current time
$current_time = date('Y-m-d H:i:s');
$current_user = 'vky6366';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(str_replace('_', ' ', $table)); ?> Data</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        .container {
            background-color: rgb(238, 235, 240);
            height: 40px;
            width: auto;
            display: flex;
            flex-direction: row;
            justify-content: start;
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

        .real {
            background-color: white;
            color: blue;
            text-align: center;
            height: auto;
            width: auto;
            margin: 0;
            padding: 0;
        }

        .container1 {
            background-color: rgb(255, 255, 255);
            color: rgb(43, 69, 152);
            height: 120px;
            width: auto;
            position: sticky;
            top: 0;
            z-index: 100;
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

        .time-user-section {
            background: rgb(43, 69, 152);
            color: white;
            padding: 15px 0;
            margin-bottom: 20px;
        }

        .time-user-content {
            max-width: 1800px;
            margin: 0 auto;
            display: flex;
            justify-content: flex-end;
            gap: 30px;
            padding: 0 20px;
        }

        .time-info, .user-info {
            font-size: 14px;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.8);
        }

        .info-value {
            font-weight: bold;
            background: rgba(255, 255, 255, 0.1);
            padding: 5px 10px;
            border-radius: 4px;
            margin-left: 10px;
        }

        .main-content {
            padding: 20px;
            max-width: 1800px;
            margin: 0 auto;
            width: 95%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            background-color: #34508a;
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            min-width: 1000px;
        }

        .data-table th {
            background: rgb(43, 69, 152);
            color: white;
            padding: 15px;
            text-align: left;
            white-space: nowrap;
            font-size: 14px;
        }

        .data-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        .data-table td:first-child,
        .data-table th:first-child {
            width: 80px;
            text-align: center;
        }

        .data-table td:nth-child(2),
        .data-table th:nth-child(2) {
            width: 120px;
        }

        .data-table td:nth-child(3),
        .data-table th:nth-child(3) {
            width: 200px;
        }

        .data-table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .site_header_3 {
            color: rgb(43, 69, 152);
        }

        .site_header_3 h6, .site_header_3 h2 {
            margin: 5px 0;
        }

        .site_header_3 span {
            font-size: 0.9em;
        }

        @media screen and (max-width: 1200px) {
            .time-user-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .main-content {
                width: 98%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="real">
        <div class="container">
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
    <div class="main-content">
        <div class="info-section">
            <div class="header">
                <h1><?php echo ucwords(str_replace('_', ' ', $table)); ?></h1>
                <a href="javascript:history.back()" class="back-button">← Back</a>
            </div>

            <div class="table-container">
                <?php
                try {
                    // If the table is not faculty_table, join with faculty_table to get faculty name
                    if ($table != 'faculty_table' && $table != 'departments') {
                        $sql = "SELECT t.*, f.name as faculty_name 
                                FROM $table t 
                                LEFT JOIN faculty_table f ON t.faculty_id = f.faculty_id";
                    } else {
                        $sql = "SELECT faculty_id, name, department_name, Designation, date_of_joining, email_id, contact_no 
                                FROM faculty_table"; // Explicitly select columns, excluding duplicates
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table class='data-table'>";
                        
                        // Headers
                        echo "<thead><tr>";
                        
                        // Only add Sr No once
                        echo "<th>Sr No</th>";
                        
                        // Get all fields
                        $fields = $result->fetch_fields();
                        
                        // Create an ordered array of column headers
                        $ordered_headers = array();
                        foreach ($fields as $field) {
                            $field_name = $field->name;
                            // Skip adding faculty_id and name again if they're already added
                            if ($field_name == 'faculty_id') {
                                $ordered_headers[1] = $field_name;
                            } elseif ($field_name == 'name' || $field_name == 'faculty_name') {
                                $ordered_headers[2] = $field_name;
                            } elseif ($field_name != 'sr_no') { // Skip sr_no field
                                $ordered_headers[] = $field_name;
                            }
                        }
                        
                        ksort($ordered_headers);
                        
                        foreach ($ordered_headers as $header) {
                            if ($header == 'faculty_id') {
                                echo "<th>Faculty ID</th>";
                            } elseif ($header == 'name' || $header == 'faculty_name') {
                                echo "<th>Faculty Name</th>";
                            } else {
                                echo "<th>" . ucwords(str_replace('_', ' ', $header)) . "</th>";
                            }
                        }
                        echo "</tr></thead><tbody>";

                        $sr_no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $sr_no++ . "</td>";
                            
                            foreach ($ordered_headers as $field) {
                                if ($field != 'sr_no') { // Skip sr_no field
                                    echo "<td>" . htmlspecialchars($row[$field] ?? '') . "</td>";
                                }
                            }
                            echo "</tr>";
                        }
                        
                        echo "</tbody></table>";
                    } else {
                        echo "<p style='text-align: center; padding: 20px; color: #666;'>
                            No records found in " . ucwords(str_replace('_', ' ', $table)) . "</p>";
                    }

                } catch (Exception $e) {
                    echo "<p style='text-align: center; padding: 20px; color: #dc3545;'>
                        Error loading table data: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>