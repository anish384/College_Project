<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the faculty_id from the URL
$faculty_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : null;
if (!$faculty_id) {
    die("Error: Faculty ID not provided.");
}

// List of 17 table names
$tables = [
    'faculty_table',
    'experience',
    'awards',
    'books_bookchapter',
    'chair_resource',
    'conference',
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            justify-self: start;
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
            color: rgb(11, 11, 12);
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
        .navbar {
            background-color: rgb(43, 69, 152);
            color: white;
            height: 30px;
            width: auto;
            text-decoration: none;
            font-size: medium;
            padding: 10px 20px;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            color: rgb(255, 255, 255);
            display: flex;
            flex-direction: row;
        }

        .nav li {
            margin: o 15px;
            justify-content: start;
            color: rgb(254, 255, 255);
            font-size: 14.5px;
            background-color: rgb(43, 69, 152) ;
        }
        header, footer {
            background-color: #0073e6;
            color: white;
            text-align: center;
            padding: 1rem;
        }
        main {
            padding: 2rem;
        }
        h1, h2 {
            color: #333;
        }
        .table-section {
            margin-bottom: 2rem;
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: rgba(9, 30, 66, 0.4) 0px 1px 1px, rgba(9, 30, 66, 0.4) 0px 0px 1px 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
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
        img {
            max-width: 180px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 10px;

        }
        .faculty-details {
            margin-bottom: 2rem;
            justify: Center;
        }
        .faculty-details img {
            margin-right: 1rem;
            float: left;
        }
        p {
            color: black;
        }
        .details {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .details th,
        .details td {
            border: 1px solid white;
            padding: 4px;
            text-align: left;
        }

    </style>
</head>
<body>
<div class="real">

<div class="container">

    <div class="row">
        <div class="site_topbar">
            <i class="phone"></i> <b>0831-2438100/123</b>
            <i class="envelope_icon">info@aitmbgm.ac.in</i> 
        </div>
    </div>

</div>

<div class="container1">

    <div class="row1">

        <div class="site_header_1">
            <h2 class="web_title">
                <a class="back" href="https://aitmbgm.ac.in">
                    <img class="photo"
                        src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/Suresh-Angadi.jpg"
                        alt="AITMBGM" title="AITMBGM">
                </a>
            </h2>
        </div>

        <div class="site_header_2">
            <h2 class="web_title ">
                <a class="back" href="https://aitmbgm.ac.in">
                    <img class="photo"
                        src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitmbgm-logo.png"
                        alt="AITMBGM" title="AITMBGM">
                </a>
            </h2>
        </div>

        <div class="site_header_3">
            <h6>SURESH ANGADI EDUCATION FOUNDATIONS</h6>
            <h2>ANGADI INSTITUTE OF TECHNOLOGY AND MANAGEMENT</h2>
            <span>Approved by AICTE, New Delhi, Affiliated to VTU, Belagavi. <br>Accredited by *NBA and
                NAAC<br></span>
        </div>

        <div class="site_header_4 ">
            <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitm-logo.png"
                alt="AITM" title="AITM">
        </div>
    </div>

</div>
<nav class="navbar">
    </nav>
    <main>
        <?php
        // Custom handling for `faculty_table`
        if (in_array('faculty_table', $tables)) {
            echo "<div class='faculty-details'>";
            echo "<table class='faculty_details'>";
            // Fetch data from `faculty_table`
            $sql = "SELECT * FROM faculty_table WHERE faculty_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $faculty_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $faculty = $result->fetch_assoc();
                echo "<table border='0' class='details'>";
                echo "<tr>";
                echo "<td rowspan='6'><img src='" . htmlspecialchars($faculty['image']) . "' alt='Faculty Image' style='max-width: auto; height: 200px; border-radius: 5px;'></td>";
                echo "<td><strong>Name:</strong> " . htmlspecialchars($faculty['name']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Designation:</strong> " . htmlspecialchars($faculty['Designation']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Department:</strong> " . htmlspecialchars($faculty['department_name']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Faculty-ID:</strong> " . htmlspecialchars($faculty['faculty_id']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Email:</strong> " . htmlspecialchars($faculty['email_id']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Phone:</strong> " . htmlspecialchars($faculty['contact_no']) . "</td>";
                echo "</tr>";
                echo "</table>";

            } else {
                echo "<p>No data found for the faculty table.</p>";
            }
            
            echo "</div>";
            $stmt->close();
        }

        // Display other tables dynamically
        foreach ($tables as $table) {
            if ($table === 'faculty_table') continue; // Skip faculty_table here
        
            echo "<div class='table-section'>";
            echo "<h2>" . ucfirst(str_replace("_", " ", $table)) . "</h2>";
        
            // Prepare and execute the query
            $sql = "SELECT * FROM $table WHERE faculty_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $faculty_id);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr>";
        
                // Add S.No header
                echo "<th>S.No</th>";
        
                // Dynamically fetch and print column headers, excluding 'faculty_id'
                $fields = $result->fetch_fields();
                foreach ($fields as $field) {
                    if ($field->name === 'faculty_id') continue; // Skip faculty_id
                    echo "<th>" . ucfirst(str_replace("_", " ", $field->name)) . "</th>";
                }
                echo "</tr></thead>";
        
                // Dynamically fetch and print rows, excluding 'faculty_id'
                echo "<tbody>";
                $serial_number = 1; // Initialize S.No counter
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
        
                    // Print S.No
                    echo "<td>" . $serial_number++ . "</td>";
        
                    // Print other columns
                    foreach ($row as $key => $value) {
                        if ($key === 'faculty_id') continue; // Skip faculty_id
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No data found for this table.</p>";
            }
        
            echo "</div>";
            $stmt->close();
        }
        
        
        ?>
    </main>
    <footer>
        <p>&copy; 2024 College Database</p>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
