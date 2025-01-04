<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "college_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT * FROM faculty_table";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>college</title>
    
</head>
<style>
    * {
    margin: 0;
    padding: 0;
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

.a {
    color: rgb(255, 255, 255);
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

.cse {
    background-color: rgb(255, 255, 255);
    color: antiquewhite;
    height: 250px;
    width: 200px;
    margin-bottom: 2px;
    margin-right: 4px;
    margin-top: 5px;
}

.ai {
    background-color: rgb(255, 255, 255);
    color: antiquewhite;
    height: 250px;
    width: 200px;
    margin-top: 2px;
    margin-bottom: 2px;
    margin-top: 5px;
}

.ec {
    background-color: rgb(254, 255, 255);
    color: antiquewhite;
    height: 250px;
    width: 200px;
    margin-top: 2px;
    margin-bottom: 2px;
    margin-left: 2px;
    margin-top: 5px;
}

.eee {
    background-color: rgb(255, 255, 255);
    color: antiquewhite;
    height: 250px;
    width: 200px;
    margin-top: 2px;
    margin-bottom: 2px;
    margin-left: 2px;
    margin-top: 5px;
}

.civil {
    background-color: rgb(255, 255, 255);
    color: antiquewhite;
    height: 250px;
    width: 200px;
    margin-top: 2px;
    margin-bottom: 2px;
    margin-left: 2px;
    margin-top: 5px;
}

.mech {
    background-color: rgb(255, 255, 255);
    color: antiquewhite;
    height: 250px;
    width: 200px;
    margin-top: 2px;
    margin-bottom: 2px;
    margin-left: 2px;
    margin-top: 5px;
}

.robo {
    background-color: rgb(255, 255, 255);
    color: antiquewhite;
    height: 250px;
    width: 200px;
    margin-top: 2px;
    margin-bottom: 2px;
    margin-left: 4px;
    margin-top: 5px;
}

.logo {
    color: black;
    font-size: 1em;
    text-decoration: none;
}

.img {
    height: 60%;
    width: 80%;
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

        <div class="main">

            <a href="second-page.php">
                <div id="navigateCSE" class="cse">
                    <div class="logo">COMPUTER SCIENCE AND ENGINEERING</div>
                    <img class="img" src="img\cs1.jpg">
                </div>
            </a>

            <a href="#">
                <div class="ai">
                    <div class="logo">ARTIFICIAL INTELLIGENT AND MACHINE LEARNING ENGINEERING</div>
                    <img class="img" src="img\ai1.jpg">
                </div>
            </a>

            <a href="#">
                <div class="ec">
                    <div class="logo">ELECTRONICS AND COMMUNICATION ENGINEERING</div>
                    <img class="img" src="img\ec1.jpg">
                </div>
            </a>

            <a href="#">
                <div class="eee">
                    <div class="logo">ELECTRIC AND ELECTRONICS ENGINEERING</div>
                    <img class="img" src="img\eee1.jpg">
                </div>
            </a>

            <a href="#">
                <div class="civil">
                    <div class="logo">CIVIL ENGINEERING</div>
                    <img class="img" src="img\civil1.jpg">
                </div>
            </a>

            <a href="">
                <div class="mech">
                    <div class="logo">MECHANICAL ENGINEERING</div>
                    <img class="img" src="img\mec1.jpg">
                </div>
            </a>

            <a href="#3">
                <div class="robo">
                    <div class="logo">ROBOTIC AND AUTOMOUS ENGINEERING</div>
                    <img class="img" src="img\robo1.jpeg">
                </div>
            </a>
        </div>
    </div>

    <footer>
        <h2>Angadi Insitute Of Technology And Management</h2>
    </footer>


    <script>
        const navigateCSE = document.getElementById('navigateCSE');
        if (navigateCSE) {
            navigateCSE.addEventListener('click', function () {
                window.location.href = "second-page.php#real";
            });
        }

    </script>



</body>
</html>


