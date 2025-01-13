<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch departments
$sql = "SELECT department_id, department_name, department_img FROM departments";
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
            padding: 20px;
            font-family: 'Arial', sans-serif;
            color: #000000;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #7b38f7;
            font-size: 2em;
        }

        .content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
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

        .search-bar {
            margin-top: 5px;
        }

        .real {
            background-color: white;
            color: white;
            padding: 10px 20px;
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
        }

        .navbar {
            background-color: rgb(43, 69, 152);
            color: white;
            height: 20px;
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

        .department-box {
            width: 200px;
            background-color: #fff;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
            transition: all 0.3s ease;
        }
        .main {
            background-color: rgb(255, 255, 255);
            color: rgb(255, 255, 255);
            height: 250px;
            width: auto;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .department-box:hover {
            transform: scale(1.05);
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
        footer {
            background-color: rgb(43, 69, 152);
            color: rgb(255, 255, 255);
            text-align: center;
            padding: 10px 20px;
            bottom: 0;
            width: 100%;
            position: fixed;
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

    <div class="search-bar">
        <input class="search-bar" type="text" placeholder="search">
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
    <ul class="nav">
        <li><a href="home">home</a></li>
        <li><a href="about">About</a></li>
        <li><a href="administrtion">adiministration</a></li>
        <li><a href="academic">academic</a></li>
        <li><a href="home">home</a></li>
        <li><a href="about">About</a></li>
        <li><a href="administrtion">adiministration</a></li>
        <li><a href="academic">academic</a></li>
    </ul>
    </nav>
    <h1>Departments</h1>
    <div class="content">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='department-box'>";
                echo "<img src='" . htmlspecialchars($row['department_img']) . "' alt='" . htmlspecialchars($row['department_name']) . " Image'>";
                echo "<a href='second-page.php?department_id=" . $row['department_id'] . "'>" . htmlspecialchars($row['department_name']) . "</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No departments found.</p>";
        }
        ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>
