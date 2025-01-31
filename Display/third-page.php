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

// List of 17 table names
$tables = [
    'faculty_table',
    'experience',
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

        header {
            background-color:rgb(255, 255, 255);
            color:black;
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
            border: 1px  #ddd;
            border-radius: 10px;


        }
        
        .details {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        .faculty-details {
            margin-bottom: 2rem;
           
        }
        .faculty-details img {
            margin-right: 1rem;
            float: left;
        }
        p {
            color: black;
        }
        
        .details td {
            border: 1px solid white;
            padding: 4px;
            
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
            width: 100px; 
    word-wrap: break-word;
    white-space: normal;
    vertical-align: top;
     

           
        }


       
        th {
            background-color: #4A90E2;
            color: white;
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
                <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/Suresh-Angadi.jpg"
                    alt="AITMBGM" title="AITMBGM">
            </a>
        </h2>
    </div>

    <div class="site_header_2">
        <h2 class="web_title ">
            <a class="back" href="https://aitmbgm.ac.in">
                <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitmbgm-logo.png"
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
        <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitm-logo.png" alt="AITM"
            title="AITM">
    </div>
</div>

</div>

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
                echo "<td rowspan='7'><img src='" . htmlspecialchars($faculty['image']) . "' 
        alt='Faculty Image' style='height: 200px; border-radius: 5px;'></td>";

                echo "<td><strong>Name:</strong> " . htmlspecialchars($faculty['name']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Faculty ID:</strong> " . htmlspecialchars($faculty['faculty_id']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Department:</strong> " . htmlspecialchars($faculty['department_name']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Email:</strong> " . htmlspecialchars($faculty['email_id']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Phone:</strong> " . htmlspecialchars($faculty['contact_no']) . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Designation:</strong> " . htmlspecialchars($faculty['Designation']) . "</td>";
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
                    if (in_array($field->name, ['faculty_id', 'sr_no'])) continue; // Correct
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
                        if (in_array($key, ['faculty_id', 'sr_no'])) continue; // Skip faculty_id and sr_no
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
        <h2>Angadi Insitute Of Technology And Management</h2>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
