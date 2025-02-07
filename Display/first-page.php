<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Current UTC time
$current_time = gmdate('Y-m-d H:i:s');
$current_user = 'vky6366';

// Fetch departments
$sql = "SELECT department_name, department_img FROM departments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Departments</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            background-color: rgb(238, 235, 240);
            height: 40px;
            width: auto;
            display: flex;
            flex-direction: row;
            justify-content: start;
        }
        body {
            padding: 0;
            font-family: 'Arial', sans-serif;
            color:rgb(255, 255, 255);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: rgb(43, 69, 152);
            font-size: 2em;
        }

        .main-content {
            display: flex;
            gap: 20px;
            padding: 20px;
            width: 100%;
        }

        .department-section {
            flex: 7;
            padding-right: 20px;
        }

        .content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
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
            margin-top:2px;
        }

        .navbar {
            background-color: rgb(43, 69, 152);
            color: white;
            height: 40px;
            width: auto;
            text-decoration: none;
            font-size: medium;
            padding: 10px 20px;
        }

        .department-box {
            width: 200px;
            background-color: #fff;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
            transition: all 0.3s ease;
        }

        .department-box:hover {
            transform: scale(1.1);
            box-shadow: rgba(9, 30, 66, 0.35) 0px 3px 6px, rgba(9, 30, 66, 0.25) 0px 0px 2px 2px;
        }

        .department-box img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .department-box a {
            display: block;
            color: #7b38f7;
            font-size: 1.2em;
            font-weight: bold;
            text-decoration: none;
        }

        .department-box a:hover {
            text-decoration: underline;
        }

        .table-section {
            flex: 3;
            background: white;
            padding: 20px;
            border-radius: 12px;
            height: fit-content;
            position: sticky;
            top: 20px;
            box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
        }

        .table-list {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 15px;
        }

        .table-list th {
            background: rgb(43, 69, 152);
            color: white;
            padding: 12px;
            text-align: left;
        }

        .table-list td {
            padding: 0;
            border-bottom: 1px solid #ddd;
        }

        .table-list tr:hover {
            background-color: #f5f5f5;
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
                    <i class="phone"></i> <b>x</b>
                    <i class="envelope_icon"></i> 
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

    <nav class="navbar">
        <ul>
            <li>Department</li>
        </ul>
    </nav>

    <div class="main-content">
        <!-- Left side - Departments (70%) -->
        <div class="department-section">
            <h1>Departments</h1>
            <div class="content">
                <?php
                $query = "SELECT department_name, department_img FROM departments";
                $result = $conn->query($query);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='department-box'>";
                        echo "<img src='" . htmlspecialchars($row['department_img']) . "' alt='" . htmlspecialchars($row['department_name']) . " Image'>";
                        echo "<a href='second-page.php?department_name=" . urlencode($row['department_name']) . "'>" . htmlspecialchars($row['department_name']) . "</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No departments found.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Right side - Database Tables (30%) -->
        <div class="table-section">
            <h2>Database Tables</h2>
            <?php
            $tables = [
                    'journals',
                    'conference',
                    'books_bookchapter',
                    'patents',
                    'fdp_conferences_attended',
                    'chair_resource',
                    'for_scholars_dr',
            ];

            $tables = array_unique($tables);

            echo "<table class='table-list'>";
            echo "<thead><tr><th>Summary</th></tr></thead><tbody>";
            
            foreach ($tables as $table) {
                echo "<tr>";
                echo "<td>";
                echo "<a href='view_table_data.php?table=" . urlencode($table) . "' 
                        style='color: #0066cc; text-decoration: none; display: block; padding: 12px;'>";
                echo ucwords(str_replace('_', ' ', $table));
                echo "</a></td>";
                echo "</tr>";
            }
            
            echo "</tbody></table>";
            ?>
        </div>
    </div>

    <footer>
        <h2>Angadi Institute Of Technology And Management</h2>
    </footer>

</body>
</html>
<?php $conn->close(); ?>