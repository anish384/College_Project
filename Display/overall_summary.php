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
        @media print {
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            thead {
                display: table-header-group;
            }
            h1, h2 {
                page-break-before: always;
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
            .no-print {
                display: none;
            }
        }
        
        /* General styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1, h2 {
            color: #333;
            margin: 20px 0;
        }
        footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            border-top: 1px solid #ddd;
        }
        .current-info {
            margin-bottom: 20px;
            font-size: 0.9em;
            color: #666;
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
        // Query to get overall college summary
        $summary_sql = "SELECT 
            COUNT(DISTINCT ft.faculty_id) as faculty_count,
            (SELECT COUNT(*) FROM journals j 
            WHERE (j.international_national = 'International' OR j.international_national = 'international')
            ) as int_journals,
            (SELECT COUNT(*) FROM conference c 
            WHERE (c.International_National = 'International' OR c.International_National = 'international')
            ) as int_conferences,
            (SELECT COUNT(*) FROM books_bookchapter) as book_chapters,
            (SELECT COUNT(*) FROM patents) as patents,
            (SELECT COUNT(*) FROM chair_resource) as resource_person,
            (SELECT COUNT(*) FROM fdp_conferences_attended) as fdp_count,
            (SELECT COALESCE(SUM(citations), 0) FROM journals) as total_citations
        FROM faculty_table ft";

        $result = $conn->query($summary_sql);
        $row = $result->fetch_assoc();

        // Display college summary
        echo "<div class='summary-container'>";
        echo "<h1 class='summary-title'>College Research Summary</h1>";
        
        // Main summary table
        echo "<table class='fdp-table summary-table'>
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Faculty Members</td>
                        <td>" . $row['faculty_count'] . "</td>
                    </tr>
                    <tr>
                        <td>International Journal Publications</td>
                        <td>" . $row['int_journals'] . "</td>
                    </tr>
                    <tr>
                        <td>International Conference Papers</td>
                        <td>" . $row['int_conferences'] . "</td>
                    </tr>
                    <tr>
                        <td>Books/Book Chapters</td>
                        <td>" . $row['book_chapters'] . "</td>
                    </tr>
                    <tr>
                        <td>Patents</td>
                        <td>" . $row['patents'] . "</td>
                    </tr>
                    <tr>
                        <td>Resource Person Activities</td>
                        <td>" . $row['resource_person'] . "</td>
                    </tr>
                    <tr>
                        <td>FDP/Conferences Attended</td>
                        <td>" . $row['fdp_count'] . "</td>
                    </tr>
                    <tr>
                        <td>Total Citations</td>
                        <td>" . $row['total_citations'] . "</td>
                    </tr>
                </tbody>
            </table>";

        // Calculate and display averages
        $publications_per_faculty = round(($row['int_journals'] + $row['int_conferences']) / $row['faculty_count'], 2);
        $citations_per_faculty = round($row['total_citations'] / $row['faculty_count'], 2);

        echo "</div>";

        // Add some CSS for better presentation
        echo "<style>
            .summary-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }
            .summary-title {
                text-align: center;
                color: #2c3e50;
                margin-bottom: 30px;
            }
            .summary-table, .metrics-table {
                width: 100%;
                margin-bottom: 30px;
                border-collapse: collapse;
            }
            .summary-table th, .metrics-table th {
                background-color: #34495e;
                color: white;
                padding: 12px;
            }
            .summary-table td, .metrics-table td {
                padding: 10px;
                border: 1px solid #ddd;
            }
            .summary-table tr:nth-child(even), .metrics-table tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            .metrics-container {
                margin-top: 30px;
            }
            .metrics-container h2 {
                color: #2c3e50;
                margin-bottom: 20px;
            }
        </style>";
    ?>

<?php
    // 1. Journals Table
    $journal_sql = "SELECT 
        ft.name as faculty_name,
        j.Title,
        j.name_of_journal,
        j.publisher,
        j.place,
        j.vol_no_issue_no,
        j.ISSN,
        j.page_no,
        j.year,
        j.website_link
    FROM faculty_table ft
    JOIN journals j ON ft.faculty_id = j.faculty_id
    ORDER BY j.year ASC";

    $journal_result = $conn->query($journal_sql);

    if ($journal_result->num_rows > 0) {
        echo "<h1>Journal Publications</h1>";
        echo "<table>
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Name of Journal</th>
                    <th>Publisher</th>
                    <th>Place</th>
                    <th>Vol/Issue</th>
                    <th>ISSN</th>
                    <th>Page No</th>
                    <th>Year</th>
                    <th>Website Link</th>
                </tr>
            </thead>
            <tbody>";
        
        $sno = 1;
        while ($row = $journal_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $sno++ . "</td>
                    <td>" . htmlspecialchars($row['faculty_name']) . "</td>
                    <td>" . htmlspecialchars($row['Title']) . "</td>
                    <td>" . htmlspecialchars($row['name_of_journal']) . "</td>
                    <td>" . htmlspecialchars($row['publisher']) . "</td>
                    <td>" . htmlspecialchars($row['place']) . "</td>
                    <td>" . htmlspecialchars($row['vol_no_issue_no']) . "</td>
                    <td>" . htmlspecialchars($row['ISSN']) . "</td>
                    <td>" . htmlspecialchars($row['page_no']) . "</td>
                    <td>" . htmlspecialchars($row['year']) . "</td>
                    <td>" . (!empty($row['website_link']) ? 
                            "<a href='" . htmlspecialchars($row['website_link']) . "' target='_blank' class='journal-link'>" . htmlspecialchars($row['website_link']) . "</a>" 
                            : "N/A") . "</td>
                </tr>";
        }
        echo "</tbody></table>";
    }

    // 2. FDP Conferences Attended
    $fdp_sql = "SELECT 
        ft.name as faculty_name,
        f.Topic,
        f.Organizer,
        f.no_of_days,
        f.Place,
        f.Year
    FROM faculty_table ft
    JOIN fdp_conferences_attended f ON ft.faculty_id = f.faculty_id
    ORDER BY f.Year ASC";

    $fdp_result = $conn->query($fdp_sql);

    if ($fdp_result->num_rows > 0) {
        echo "<h1>FDP/Conferences Attended</h1>";
        echo "<table>
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Faculty Name</th>
                    <th>Topic</th>
                    <th>Organizer</th>
                    <th>Days</th>
                    <th>Place</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>";
        
        $sno = 1;
        while ($row = $fdp_result->fetch_assoc()) {
            echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . htmlspecialchars($row['faculty_name']) . "</td>
                <td>" . htmlspecialchars($row['Topic']) . "</td>
                <td>" . htmlspecialchars($row['Organizer']) . "</td>
                <td>" . htmlspecialchars($row['no_of_days']) . "</td>
                <td>" . htmlspecialchars($row['Place']) . "</td>
                <td>" . htmlspecialchars($row['Year']) . "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }

    // 3. Patents
    $patent_sql = "SELECT 
        ft.name as faculty_name,
        p.Title,
        p.year_of_publication,
        p.Status
    FROM faculty_table ft
    JOIN patents p ON ft.faculty_id = p.faculty_id
    ORDER BY p.year_of_publication ASC";

    $patent_result = $conn->query($patent_sql);

    if ($patent_result->num_rows > 0) {
        echo "<h1>Patent Details</h1>";
        echo "<table>
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Faculty Name</th>
                    <th>Title</th>
                    <th>Year</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";
        
        $sno = 1;
        while ($row = $patent_result->fetch_assoc()) {
            echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . htmlspecialchars($row['faculty_name']) . "</td>
                <td>" . htmlspecialchars($row['Title']) . "</td>
                <td>" . htmlspecialchars($row['year_of_publication']) . "</td>
                <td>" . htmlspecialchars($row['Status']) . "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }

    // 4. Books and Book Chapters
    $books_sql = "SELECT 
        ft.name as faculty_name,
        b.Title,
        b.Publisher,
        b.Place,
        b.Year_of_publication,
        b.ISBN,
        b.Book_Chapter
    FROM faculty_table ft
    JOIN books_bookchapter b ON ft.faculty_id = b.faculty_id
    ORDER BY b.Year_of_publication ASC";

    $books_result = $conn->query($books_sql);

    if ($books_result->num_rows > 0) {
        echo "<h1>Books and Book Chapters</h1>";
        echo "<table>
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Faculty Name</th>
                    <th>Title</th>
                    <th>Publisher</th>
                    <th>Place</th>
                    <th>Year</th>
                    <th>ISBN</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>";
        
        $sno = 1;
        while ($row = $books_result->fetch_assoc()) {
            echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . htmlspecialchars($row['faculty_name']) . "</td>
                <td>" . htmlspecialchars($row['Title']) . "</td>
                <td>" . htmlspecialchars($row['Publisher']) . "</td>
                <td>" . htmlspecialchars($row['Place']) . "</td>
                <td>" . htmlspecialchars($row['Year_of_publication']) . "</td>
                <td>" . htmlspecialchars($row['ISBN']) . "</td>
                <td>" . htmlspecialchars($row['Book_Chapter']) . "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }

    // 5. Chair/Resource Person
    $chair_sql = "SELECT 
        ft.name as faculty_name,
        cr.Organization,
        cr.Chair_Resource,
        cr.Place,
        cr.Year
    FROM faculty_table ft
    JOIN chair_resource cr ON ft.faculty_id = cr.faculty_id
    ORDER BY cr.Year ASC";

    $chair_result = $conn->query($chair_sql);

    if ($chair_result->num_rows > 0) {
        echo "<h1>Chair/Resource Person Details</h1>";
        echo "<table>
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Faculty Name</th>
                    <th>Organization</th>
                    <th>Role</th>
                    <th>Place</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>";
        
        $sno = 1;
        while ($row = $chair_result->fetch_assoc()) {
            echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . htmlspecialchars($row['faculty_name']) . "</td>
                <td>" . htmlspecialchars($row['Organization']) . "</td>
                <td>" . htmlspecialchars($row['Chair_Resource']) . "</td>
                <td>" . htmlspecialchars($row['Place']) . "</td>
                <td>" . htmlspecialchars($row['Year']) . "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }

    
    $grants_sql = "SELECT 
        ft.name as faculty_name,
        rg.research_title,
        rg.funding_organization,
        rg.amount,
        rg.year
    FROM faculty_table ft
    JOIN research_grants rg ON ft.faculty_id = rg.faculty_id
    ORDER BY rg.year ASC";

    $grants_result = $conn->query($grants_sql);

    if ($grants_result->num_rows > 0) {
        echo "<h1>Research Grants Details</h1>";
        echo "<table>
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Faculty Name</th>
                    <th>Research Title</th>
                    <th>Funding Organization</th>
                    <th>Amount (₹)</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>";
        
        $sno = 1;
        while ($row = $grants_result->fetch_assoc()) {
            echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . htmlspecialchars($row['faculty_name']) . "</td>
                <td>" . htmlspecialchars($row['research_title']) . "</td>
                <td>" . htmlspecialchars($row['funding_organization']) . "</td>
                <td>" . number_format($row['amount']) . "</td>
                <td>" . htmlspecialchars($row['year']) . "</td>
            </tr>";
        }
        echo "</tbody></table>";

        // Add total amount
        $total_sql = "SELECT SUM(amount) as total_amount FROM research_grants";
        $total_result = $conn->query($total_sql);
        $total_row = $total_result->fetch_assoc();
        
        echo "<div class='total-amount'>
            <strong>Total Research Grants: ₹" . number_format($total_row['total_amount']) . "</strong>
        </div>";
    } else {
        echo "<p class='no-data'>No Research Grants data available.</p>";
    }
    ?>

    <footer>
        <h2>Angadi Institute Of Technology And Management</h2>
    </footer>
</body>
</html>
<?php $conn->close(); ?>