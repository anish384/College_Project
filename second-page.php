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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>college</title>
  </head>
  <style>
    * {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
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
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            margin-right: 20px;
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
      background-color: rgb(43, 69, 152);
    }

    .a {
      color: rgb(255, 255, 255);
    }

    .all {
      height: auto;
      width: auto;
      background-color: rgb(238, 235, 240);
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: flex-start;
    }

    .content {
      display: flex;
      justify-content: space-between;
      flex: 1;
      margin: auto;
      padding: 20px 0;
      gap: 20px;
      position: relative;
    }

    aside {
      border: 1px solid #ccc;
      padding: 20px;
      width: relative;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: -webkit-sticky;
      position: sticky;
      top: 20px;
      color: #333;
      right: 0;
      margin-left: 20px;
    }

    .related-news h3 {
      text-align: center;
      border-radius: 7px;
      padding: 8px;
      background: #000;
      color: #ffffff;
      font-size: 1.4em;
      margin-bottom: 15px;
    }

    .related-news ul {
      list-style: outside;
      padding: 7px;
      margin: 0;
    }

    .related-news li {
      margin-bottom: 12px;
    }

    .related-news a {
      text-decoration: none;
      color: #7b38f7;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .related-news a:hover {
      text-decoration: underline;
    }

    .department {
      flex: 1; /* Allocate space proportionally */
      margin-right: 20px; /* Add some space between department and teachers */
      font-size: 1.2em; /* Adjust font size for better visibility */
    }

    .teachers {
      flex: 1; /* Allocate more space for the teachers section */
      display;
      flex-wrap: wrap; /* Allow teacher cards to wrap if necessary */
      gap: 10px; /* Add spacing between teacher cards */
    }

    .teach1 {
      background-color: rgb(235, 230, 230);
      display: flex;
      flex-direction: row;
      margin-top: 2px;
      margin-left: 2px;
      margin-right: 2px;
      justify-content: space-around;
    }

    .teach1 {
      width: 150px; /* Set a fixed width for each teacher card */
      text-align: center; /* Center-align text and image */
    }

    .img1 {
      width: 100%; /* Make images fit the card width */
      height: auto; /* Maintain aspect ratio */
      border-radius: 8px; /* Add rounded corners for aesthetics */
    }

    footer {
      background-color: rgb(43, 69, 152);
      color: rgb(255, 255, 255);
      text-align: center;
      padding: 10px 20px;
      bottom: 0;
      width: 100%;
      position: fixed;
      height: 20px;
      position: relative;
    }
  </style>
  <body>
    <div id="real" class="real">
      <div class="container">
        <div class="row">
          <div class="site_topbar">
            <i class="phone"></i> <b>0831-2438100/123</b>
            <i class="envelope_icon"></i> info@aitmbgm.ac.in
          </div>
        </div>

        <div class="search-bar">
          <input class="search-bar" type="text" placeholder="search" />
        </div>
      </div>

      <div class="container1">
        <div class="row1">
          <div class="site_header_1">
            <h2 class="web_title">
              <a class="back" href="https://aitmbgm.ac.in">
                <img
                  class="photo"
                  src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/Suresh-Angadi.jpg"
                  alt="AITMBGM"
                  title="AITMBGM"
                />
              </a>
            </h2>
          </div>

          <div class="site_header_2">
            <h2 class="web_title">
              <a class="back" href="https://aitmbgm.ac.in">
                <img
                  class="photo"
                  src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitmbgm-logo.png"
                  alt="AITMBGM"
                  title="AITMBGM"
                />
              </a>
            </h2>
          </div>

          <div class="site_header_3">
            <h6>SURESH ANGADI EDUCATION FOUNDATIONS</h6>
            <h2>ANGADI INSTITUTE OF TECHNOLOGY AND MANAGEMENT</h2>
            <span
              >Approved by AICTE, New Delhi, Affiliated to VTU, Belagavi.
              <br />Accredited by *NBA and NAAC<br
            /></span>
          </div>

          <div class="site_header_4">
            <img
              class="photo"
              src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitm-logo.png"
              alt="AITM"
              title="AITM"
            />
          </div>
        </div>
      </div>

      <nav class="navbar">
        <ul class="nav">
          <button><a href="home">home</a></button>
          <li><a href="about">About</a></li>
          <li><a href="administrtion">adiministration</a></li>
          <li><a href="academic">academic</a></li>
          <li><a href="home">home</a></li>
          <li><a href="about">About</a></li>
          <li><a href="administrtion">adiministration</a></li>
          <li><a href="academic">academic</a></li>
        </ul>
      </nav>
    </div>
    <div class="content">
    <h1>Faculty Members</h1>
    <br>
      <div class="teachers">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <a href="third-page.php?faculty_id=<?php echo $row['faculty_id']; ?>" class="card-link">
                    <div class="card">
                        <img src="<?php echo $row['image']; ?>" alt="Faculty Image">
                        <div class="card-content">
                            <p><strong>Faculty ID:</strong> <?php echo $row['faculty_id']; ?></p>
                            <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
                            <p><strong>Designation:</strong> <?php echo $row['Designation']; ?></p>
                            <p><strong>Department:</strong> <?php echo $row['Department']; ?></p>
                            <p><strong>Date of Joining:</strong> <?php echo $row['date_of_joining']; ?></p>
                            <p><strong>Email:</strong> <?php echo $row['email_id']; ?></p>
                            <p><strong>Contact No:</strong> <?php echo $row['contact_no']; ?></p>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No records found.</p>
        <?php endif; ?>
        <?php $conn->close(); ?>
      </div>
        <aside class="related-news">
            <h3>Department</h3>
            <ul>
            <li><a href="#">Robotics and Automation Department</a></li>
            <li><a href="#">Mechanical Department</a></li>
            <li><a href="#">Civil Department</a></li>
            </ul>
        </aside>
    </div>
    <footer>
      <h2>Angadi Insitute Of Technology And Management</h2>
    </footer>
  </body>
</html>
