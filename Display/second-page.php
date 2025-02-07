<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the department_name from the query string
if (isset($_GET['department_name'])) {
    $department_name = $conn->real_escape_string($_GET['department_name']);
    $dept_query = "SELECT department_name FROM departments WHERE department_name = '$department_name'";
    $dept_result = $conn->query($dept_query);

    if ($dept_result->num_rows > 0) {
        $query = "SELECT * FROM faculty_table WHERE department_name = '$department_name'";
        $result = $conn->query($query);
    } else {
        die("Department not found.");
    }
} else {
    die("Invalid Department Name.");
}

// Function to check and format image path
function getImagePath($imagePath) {
    // If path is empty, return placeholder
    if (empty($imagePath)) {
        return 'placeholder.jpg';
    }

    // Check if file exists in different possible locations
    $possiblePaths = [
        $imagePath,
        'img/' . basename($imagePath),
        '../uploads/' . basename($imagePath),
        './uploads/' . basename($imagePath)
    ];

    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            return $path;
        }
    }

    // If no valid path found, return placeholder
    return 'placeholder.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers in <?php echo htmlspecialchars($department_name); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .user-info {
            background: #f8f9fa;
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
            border-left: 4px solid #0d6efd;
        }

        .time-display {
            font-family: 'Roboto Mono', monospace;
            color: #0d6efd;
            background: white;
            padding: 3px 8px;
            border-radius: 4px;
            margin-left: 5px;
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            color: rgb(0, 0, 0);
            margin: 20px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .teachers-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
            transition: transform 0.2s;
        }

        .card-link:hover {
            transform: translateY(-5px);
        }

        .card {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: white;
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 200px;
            height: 200px;
            margin-right: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .card-content {
            flex: 1;
        }

        .card-content p {
            margin: 8px 0;
            font-size: 16px;
            line-height: 1.5;
        }

        .card-content strong {
            font-weight: 500;
            color: #2c3e50;
        }

        footer {
            background-color: rgb(43, 69, 152);
            color: rgb(255, 255, 255);
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .card {
                flex-direction: column;
                text-align: center;
            }

            .card img {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }
        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary-btn {
            background-color: #2b4598;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .summary-btn:hover {
            background-color: #1a2f6e;
            transform: translateY(-2px);
        }

        .summary-btn:active {
            transform: translateY(0);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 20px;
            width: 90%;
            max-width: 1200px;
            border-radius: 8px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .close-btn {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .close-btn:hover {
            color: #000;
        }

        @media (max-width: 768px) {
            .meta-info {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="real">
        <div class="container">
            <div class="row">
                <div class="site_topbar">
                    <i class="phone"></i> <b></b>
                    <i class="envelope-mail"></i> 
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

    <h1>Faculty Members - <?php echo htmlspecialchars($department_name); ?></h1>

    <div style="text-align: center; margin: 20px 0;">
        <a href="faculty_summary.php?department_name=<?php echo urlencode($department_name); ?>" class="summary-btn">
            <i class="fas fa-chart-bar"></i> View Department Summary
        </a>
    </div>

    <div class="teachers-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePath = getImagePath($row['image']);
                echo "<a href='third-page.php?faculty_id=" . htmlspecialchars($row['faculty_id']) . "' class='card-link'>";
                echo "<div class='card'>";
                echo "<img src='" . htmlspecialchars($imagePath) . "' 
                      alt='" . htmlspecialchars($row['name']) . "' 
                      onerror=\"this.src='placeholder.jpg'\">";
                echo "<div class='card-content'>";
                echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
                echo "<p><strong>Designation:</strong> " . htmlspecialchars($row['Designation']) . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</a>";
            }
        } else {
            echo "<div class='no-results'>No faculty members found in this department.</div>";
        }
        ?>
    </div>

    <footer>
        <h2>Angadi Institute Of Technology And Management</h2>
    </footer>

    <script>
        // Add JavaScript for image error handling
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.onerror = function() {
                    this.src = 'placeholder.jpg';
                    this.onerror = null; // Prevent infinite loop
                }
            });
        });
    </script>

</body>
</html>
<?php $conn->close(); ?>