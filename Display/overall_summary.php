<?php
// overall_summary.php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overall Department Summary</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .meta-info {
            background: #f8f9fa;
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
            border-left: 4px solid #0d6efd;
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


        .timestamp, .user-login {
            display: inline-block;
            margin: 0 20px;
        }

        .time-value, .user-value {
            font-family: 'Roboto Mono', monospace;
            color: #0d6efd;
            background: white;
            padding: 3px 8px;
            border-radius: 4px;
            margin-left: 5px;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        .fdp-table-container {
            margin: 20px;
            overflow-x: auto;
        }

        .fdp-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .fdp-table th, 
        .fdp-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .fdp-table th {
            background-color: #2b4598;
            color: white;
            font-weight: bold;
        }

        .fdp-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .fdp-table tr:hover {
            background-color: #f5f5f5;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2b4598;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px;
        }

        .back-btn:hover {
            background-color: #1a2f6e;
        }

        .patent-table-container {
            margin: 20px;
            overflow-x: auto;
        }

        /* Space between tables */
        .patent-table-container {
            margin-top: 40px;
        }

        footer {
            background-color: rgb(43, 69, 152);
            color: rgb(255, 255, 255);
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
        .books-table-container {
            margin: 20px;
            overflow-x: auto;
        }

        /* Space between tables */
        .books-table-container {
            margin-top: 40px;
        }
        .conference-table-container {
            margin: 20px;
            overflow-x: auto;
        }

        /* Space between tables */
        .conference-table-container {
            margin-top: 40px;
        }

        /* Style for website links */
        .fdp-table td a {
            color: #2b4598;
            text-decoration: none;
        }

        .fdp-table td a:hover {
            text-decoration: underline;
        }
        .journals-table-container {
            margin: 20px;
            overflow-x: auto;
        }

        /* Space between tables */
        .journals-table-container {
            margin-top: 40px;
        }

        /* Improved table styling for better readability with many columns */
        .fdp-table td {
            white-space: nowrap;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .fdp-table td:hover {
            white-space: normal;
            word-wrap: break-word;
        }

        /* Style for numeric columns */
        .fdp-table td:nth-child(17),
        .fdp-table td:nth-child(18),
        .fdp-table td:nth-child(19),
        .fdp-table td:nth-child(20),
        .fdp-table td:nth-child(21) {
            text-align: right;
        }
        .chair-table-container {
            margin: 20px;
            overflow-x: auto;
        }

        /* Space between tables */
        .chair-table-container {
            margin-top: 40px;
        }

        /* Compact styling for this specific table */
        .chair-table-container .fdp-table td {
            padding: 10px;
        }
        .export-button-container {
            margin: 20px;
            text-align: right;
        }

        .export-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background-color: #217346; /* Excel green color */
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .export-btn:hover {
            background-color: #1e6b3d;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .export-btn i {
            font-size: 20px;
        }

        /* Add loading state */
        .export-btn.loading {
            background-color: #999;
            pointer-events: none;
        }

        .export-btn.loading::after {
            content: "...";
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            .export-button-container {
                text-align: center;
            }
            
            .export-btn {
                width: 100%;
                justify-content: center;
            }
        }
        .dashboard-header {
            background: linear-gradient(135deg, #2b4598 0%, #1a2f6e 100%);
            color: white;
            padding: 30px 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header h1 {
            color: white;
            margin: 0;
            font-size: 2.5em;
        }

        .dashboard-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 0.9em;
            opacity: 0.9;
        }

        .department-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .department-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .department-name {
            color: #2b4598;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eef2ff;
            font-size: 1.5em;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
        }

        .stat-value {
            font-size: 2em;
            color: #2b4598;
            font-weight: bold;
            margin: 10px 0;
        }

        .stat-label {
            color: #666;
            font-size: 0.9em;
        }

        .overall-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 30px;
            margin: 40px 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .overall-summary h2 {
            color: #2b4598;
            margin-bottom: 20px;
            text-align: center;
            font-size: 2em;
        }

        .fdp-table {
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .fdp-table th {
            background: linear-gradient(135deg, #2b4598 0%, #1a2f6e 100%);
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        .fdp-table tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        .export-btn {
            margin-top: 20px;
            background: linear-gradient(135deg, #217346 0%, #1e6b3d 100%);
        }

        .summary-filters {
            display: flex;
            gap: 15px;
            margin: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            background: #f8f9fa;
            color: #2b4598;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover, .filter-btn.active {
            background: #2b4598;
            color: white;
        }

        @media screen and (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-meta {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Keep the header section -->
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

    <div class="meta-info">
        <h1>Overall Department Summary</h1>
    </div>

    <?php
    // Get all departments
    $dept_query = "SELECT DISTINCT department_name FROM faculty_table ORDER BY department_name";
    $dept_result = $conn->query($dept_query);

    // Store department totals
    $grand_totals = array(
        'int_journals' => 0,
        'int_conferences' => 0,
        'book_chapters' => 0,
        'patents' => 0,
        'resource_person' => 0,
        'fdp_count' => 0,
        'total_citations' => 0,
        'awards' => 0,
        'faculty_count' => 0
    );

    // Display summary for each department
    while ($dept = $dept_result->fetch_assoc()) {
        $department_name = $dept['department_name'];
        
        // Query to get faculty summary for this department
        $summary_sql = "SELECT 
            COUNT(DISTINCT ft.faculty_id) as faculty_count,
            (SELECT COUNT(*) FROM journals j WHERE j.faculty_id IN 
                (SELECT faculty_id FROM faculty_table WHERE department_name = ?) 
                AND (j.international_national = 'International' OR j.international_national = 'international')
            ) as int_journals,
            (SELECT COUNT(*) FROM conference c WHERE c.faculty_id IN 
                (SELECT faculty_id FROM faculty_table WHERE department_name = ?)
                AND (c.International_National = 'International' OR c.International_National = 'international')
            ) as int_conferences,
            (SELECT COUNT(*) FROM books_bookchapter b WHERE b.faculty_id IN 
                (SELECT faculty_id FROM faculty_table WHERE department_name = ?)
            ) as book_chapters,
            (SELECT COUNT(*) FROM patents p WHERE p.faculty_id IN 
                (SELECT faculty_id FROM faculty_table WHERE department_name = ?)
            ) as patents,
            (SELECT COUNT(*) FROM chair_resource cr WHERE cr.faculty_id IN 
                (SELECT faculty_id FROM faculty_table WHERE department_name = ?)
            ) as resource_person,
            (SELECT COUNT(*) FROM fdp_conferences_attended f WHERE f.faculty_id IN 
                (SELECT faculty_id FROM faculty_table WHERE department_name = ?)
            ) as fdp_count,
            (SELECT COALESCE(SUM(citations), 0) FROM journals j WHERE j.faculty_id IN 
                (SELECT faculty_id FROM faculty_table WHERE department_name = ?)
            ) as total_citations
        FROM faculty_table ft
        WHERE ft.department_name = ?";

        $stmt = $conn->prepare($summary_sql);
        $stmt->bind_param("ssssssss", $department_name, $department_name, $department_name, 
                         $department_name, $department_name, $department_name, $department_name, $department_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo "<div class='department-card'>";
        echo "<h2 class='department-name'>" . htmlspecialchars($department_name) . "</h2>";
        echo "<table class='fdp-table'>";
        echo "<thead>
                <tr>
                    <th>Faculty Count</th>
                    <th>International Journals</th>
                    <th>International Conferences</th>
                    <th>Book Chapters</th>
                    <th>Patents</th>
                    <th>Resource Person</th>
                    <th>FDP</th>
                    <th>Citations</th>
                </tr>
              </thead>";
        echo "<tbody>";
        echo "<tr>";
        echo "<td>" . $row['faculty_count'] . "</td>";
        echo "<td>" . $row['int_journals'] . "</td>";
        echo "<td>" . $row['int_conferences'] . "</td>";
        echo "<td>" . $row['book_chapters'] . "</td>";
        echo "<td>" . $row['patents'] . "</td>";
        echo "<td>" . $row['resource_person'] . "</td>";
        echo "<td>" . $row['fdp_count'] . "</td>";
        echo "<td>" . $row['total_citations'] . "</td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        // Add to grand totals
        foreach ($row as $key => $value) {
            if (isset($grand_totals[$key])) {
                $grand_totals[$key] += $value;
            }
        }
    }

    // Display grand totals
    echo "<div class='department-card'>";
    echo "<h2 class='department-name'>Overall College Summary</h2>";
    echo "<table class='fdp-table'>";
    echo "<thead>
            <tr>
                <th>Total Faculty</th>
                <th>Total International Journals</th>
                <th>Total International Conferences</th>
                <th>Total Book Chapters</th>
                <th>Total Patents</th>
                <th>Total Resource Person</th>
                <th>Total FDP</th>
                <th>Total Citations</th>
            </tr>
          </thead>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td>" . $grand_totals['faculty_count'] . "</td>";
    echo "<td>" . $grand_totals['int_journals'] . "</td>";
    echo "<td>" . $grand_totals['int_conferences'] . "</td>";
    echo "<td>" . $grand_totals['book_chapters'] . "</td>";
    echo "<td>" . $grand_totals['patents'] . "</td>";
    echo "<td>" . $grand_totals['resource_person'] . "</td>";
    echo "<td>" . $grand_totals['fdp_count'] . "</td>";
    echo "<td>" . $grand_totals['total_citations'] . "</td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    ?>

    <footer>
        <h2>Angadi Institute Of Technology And Management</h2>
    </footer>
</body>
</html>
<?php $conn->close(); ?>