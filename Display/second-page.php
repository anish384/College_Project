<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the department_name from the query string
if (isset($_GET['department_name'])) {
    // Escape the department_name to prevent SQL injection
    $department_name = $conn->real_escape_string($_GET['department_name']);

    // Verify if the department exists
    $dept_query = "SELECT department_name FROM departments WHERE department_name = '$department_name'";
    $dept_result = $conn->query($dept_query);

    if ($dept_result->num_rows > 0) {
        // Fetch teachers in the department using department_name
        $query = "SELECT * FROM faculty_table WHERE department_name = '$department_name'";
        $result = $conn->query($query);
    } else {
        die("Department not found.");
    }
} else {
    die("Invalid Department Name.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers in <?php echo htmlspecialchars($department_name); ?></title>
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

        /* Add your styles for the teacher cards here */

        h1 {
            text-align: center;
            font-size: 2rem;
            color: rgb(0, 0, 0);
        }

        .card {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card img {
            max-width: 200px;
            max-height: 200px;
           
            margin-right: 120px;
        }

        .card-content {
            flex: 1;
        }

        .card-content p {
            margin: 4px 0;
            font-size: 16px;
        }

        .card-content strong {
            font-weight: bold;
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





    <h1>Teachers in <?php echo htmlspecialchars($department_name); ?></h1>
    <div class="teachers-container">
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<a href='third-page.php?faculty_id=" . htmlspecialchars($row['faculty_id']) . "' class='card-link'>"; // Add link wrapping the card
                    echo "<div class='card'>";
                    echo "<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                    echo "<div class='card-content'>";
                    echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email_id']) . "</p>";
                    echo "<p><strong>Contact:</strong> " . htmlspecialchars($row['contact_no']) . "</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</a>"; // Close the link
                }
            } else {
                echo "<p>No teachers found in this department.</p>";
            }
        ?>
      </div>


      
    <footer>
        <h2>Angadi Insitute Of Technology And Management</h2>
    </footer>

</body>
</html>
