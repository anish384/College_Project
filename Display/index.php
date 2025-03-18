<?php
// Database connection
require_once 'config.php';

// Current UTC time
$current_time = gmdate('Y-m-d H:i:s');
$current_user = 'vky6366';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Departments</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
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
            color: rgb(255, 255, 255);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        h1 {
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
        h1::after {
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
        .main-content {
            display: block;
            padding: 20px;
            width: 100%;
            font-family: 'Poppins', sans-serif;
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
            height: 40px;
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
            padding: 10px 20px;
            font-size: 16px;
        }

        .navbar a:hover {
            background-color: #555;
            border-radius: 4px;
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
        .content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
            padding: 0 20px;
        }
        .program-box {
            width: 250px;
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin: 20px;
        }
        
        .program-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        .program-box img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        
        .program-box a {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            color: rgb(43, 69, 152);
            text-decoration: none;
            padding: 10px 0;
            transition: color 0.3s ease;
        }
        
        .program-box a:hover {
            color: #7b38f7;
            text-decoration: none;
            transform: scale(1.02);
        }

        .programs-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 20px;
            gap: 30px;
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
        <h1>Programs</h1>
        <div class="programs-container">
            <!-- PCM Box -->
            <div class="program-box">
                <img src="path/to/pcm-image.jpg" alt="PCM Programs">
                <a href="first-page.php?program=PCM">Science</a>
            </div>

            <!-- UG Box -->
            <div class="program-box">
                <img src="path/to/ug-image.jpg" alt="Undergraduate Programs">
                <a href="first-page.php?program=UG">Undergraduate Programs</a>
            </div>

            <!-- PG Box -->
            <div class="program-box">
                <img src="path/to/pg-image.jpg" alt="Postgraduate Programs">
                <a href="first-page.php?program=PG">Postgraduate Programs</a>
            </div>
        </div>
    </div>

    </div>
    <footer>
        <h2>Angadi Institute Of Technology And Management</h2>
    </footer>

</body>
</html>
<?php $conn->close(); ?>