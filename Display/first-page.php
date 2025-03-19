<?php
require_once 'config.php';

// Get the program type from URL
$program = isset($_GET['program']) ? $_GET['program'] : '';

// Fetch departments for the selected program
$sql = "SELECT department_name, department_img FROM departments WHERE department_type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $program);
$stmt->execute();
$result = $stmt->get_result();

$departments = [];
while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            font-family: 'Poppins', sans-serif;
        }
        .main-content h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: rgb(43, 69, 152);
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }
        .main-content h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: rgb(43, 69, 152);
            border-radius: 2px;
        }
        .department-section {
            /* Updated to take full width */
            width: 100%;
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
            height: 50px;
            width: auto;
            text-decoration: none;
            font-size: medium;
            padding: 10px 20px;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .navbar li {
            display: inline;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            font-size: 16px;
            font-weight: 500;
            background-color: rgba(81, 110, 255, 0.1);
            border-radius: 6px;
            transition: all 0.3s ease;
            border: 1px solid rgba(45, 69, 255, 0.66);
            display: inline-block;
            letter-spacing: 0.5px;
        }

        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-color: rgba(255, 255, 255, 0.4);
        }
        .department-box {
            width: 250px;
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .department-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .department-box img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .department-box a {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            color: rgb(43, 69, 152);
            text-decoration: none;
            padding: 10px 0;
            transition: color 0.3s ease;
        }

        .department-box a:hover {
            color: #7b38f7;
            text-decoration: none;
            transform: scale(1.02);
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
        .department-section {
            width: 100%;
            padding-right: 20px;
            margin-bottom: 30px;
        }

        .department-type {
            margin-bottom: 40px;
        }

        .department-type h2 {
            color: rgb(43, 69, 152);
            margin-bottom: 20px;
            padding-left: 20px;
            font-size: 1.5em;
            position: relative;
        }

        .department-type h2::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 4px;
            height: 20px;
            background-color: rgb(43, 69, 152);
            transform: translateY(-50%);
        }

        .content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
            padding: 0 20px;
        }
        .departments-container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="real">
        <div class="container">
            <div class="row">
                <div class="site_topbar">
                    <i class="phone"></i> <b></b>
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
            <li><a href="overall_summary.php">Summary</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <h1><?php echo htmlspecialchars($program); ?> Departments</h1>
        <div class="departments-container">
            <?php foreach ($departments as $dept): ?>
            <div class="department-box">
                <img src="<?php echo htmlspecialchars($dept['department_img']); ?>" 
                    alt="<?php echo htmlspecialchars($dept['department_name']); ?> Image">
                <a href="second-page.php?department_name=<?php echo urlencode($dept['department_name']); ?>">
                    <?php echo htmlspecialchars($dept['department_name']); ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <h2>Angadi Institute Of Technology And Management</h2>
    </footer>

</body>
</html>
<?php $conn->close(); ?>