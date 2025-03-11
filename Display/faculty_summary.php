<?php
// faculty_summary.php
// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get department name from URL
if (isset($_GET['department_name'])) {
    $department_name = $conn->real_escape_string($_GET['department_name']);
} else {
    die("Department name not specified");
}

// Define constants
define('CURRENT_TIME', date('Y-m-d H:i:s'));
define('CURRENT_USER', 'vky6366');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Summary - <?php echo htmlspecialchars($department_name); ?></title>
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
    <div class="meta-info">
        <h1><?php echo htmlspecialchars($department_name); ?></h1>
    </div>
    <a href="javascript:history.back()" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Faculty List
    </a>
    <!-- Add this where you want the export button to appear -->
    <div class="export-button-container">
        <form method="POST" action="export_faculty_data.php">
            <input type="hidden" name="department_name" value="<?php echo htmlspecialchars($department_name); ?>">
            <button type="submit" name="export_excel" class="export-btn">
                <i class="fas fa-file-excel"></i> Export to Excel
            </button>
        </form>
    </div>
    <br>
    <h1>Faculty Summary</h1>
    <?php
    // Query to get faculty summary - simplified and corrected
    $summary_sql = "SELECT 
        ft.faculty_id,
        ft.name,
        (SELECT COUNT(*) 
        FROM journals 
        WHERE faculty_id = ft.faculty_id 
        AND (international_national = 'International' OR international_national = 'international')) as int_journals,
        
        (SELECT COUNT(*) 
        FROM conference 
        WHERE faculty_id = ft.faculty_id 
        AND (International_National = 'International' OR International_National = 'international')) as int_conferences,
        
        (SELECT COUNT(*) 
        FROM books_bookchapter 
        WHERE faculty_id = ft.faculty_id) as book_chapters,
        
        (SELECT COUNT(*) 
        FROM patents 
        WHERE faculty_id = ft.faculty_id) as patents,
        
        (SELECT COUNT(*) 
        FROM chair_resource 
        WHERE faculty_id = ft.faculty_id) as resource_person,
        
        (SELECT COUNT(*) 
        FROM fdp_conferences_attended 
        WHERE faculty_id = ft.faculty_id) as fdp_count,
        
        (SELECT COALESCE(SUM(citations), 0) 
        FROM journals 
        WHERE faculty_id = ft.faculty_id) as total_citations,
        
        0 as awards
    FROM faculty_table ft
    WHERE ft.department_name = ?
    ORDER BY ft.name";

    $stmt = $conn->prepare($summary_sql);
    $stmt->bind_param("s", $department_name);
    $stmt->execute();
    $summary_result = $stmt->get_result();

    if ($summary_result->num_rows > 0) {
        echo "<div class='summary-table-container'>
            <table class='fdp-table'>
                <thead>
                    <tr>
                        <th>S.NO.</th>
                        <th>NAME OF THE FACULTY</th>
                        <th>INTERNATIONAL JOURNAL</th>
                        <th>INTERNATIONAL CONFERENCE</th>
                        <th>BOOK CHAPTERS</th>
                        <th>PATENTS</th>
                        <th>Resource Person</th>
                        <th>FDP</th>
                        <th>Citations</th>
                        <th>Awards</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>";
        
        $sno = 1;
        $totals = array_fill(0, 9, 0); // Array to store column totals

        while ($row = $summary_result->fetch_assoc()) {
            // Calculate total excluding citations and awards
            $row_total = $row['int_journals'] + 
                        $row['int_conferences'] + 
                        $row['book_chapters'] + 
                        $row['patents'] + 
                        $row['resource_person'] + 
                        $row['fdp_count'];

            echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . $row['int_journals'] . "</td>
                <td>" . $row['int_conferences'] . "</td>
                <td>" . $row['book_chapters'] . "</td>
                <td>" . $row['patents'] . "</td>
                <td>" . $row['resource_person'] . "</td>
                <td>" . $row['fdp_count'] . "</td>
                <td>" . $row['total_citations'] . "</td>
                <td>" . $row['awards'] . "</td>
                <td>" . $row_total . "</td>
            </tr>";

            // Add to totals
            $totals[0] += $row['int_journals'];
            $totals[1] += $row['int_conferences'];
            $totals[2] += $row['book_chapters'];
            $totals[3] += $row['patents'];
            $totals[4] += $row['resource_person'];
            $totals[5] += $row['fdp_count'];
            $totals[6] += $row['total_citations'];
            $totals[7] += $row['awards'];
            $totals[8] += $row_total;
        }

        // Add totals row
        echo "<tr style='font-weight: bold; background-color: #f0f0f0;'>
            <td colspan='2'>Total</td>
            <td>" . $totals[0] . "</td>
            <td>" . $totals[1] . "</td>
            <td>" . $totals[2] . "</td>
            <td>" . $totals[3] . "</td>
            <td>" . $totals[4] . "</td>
            <td>" . $totals[5] . "</td>
            <td>" . $totals[6] . "</td>
            <td>" . $totals[7] . "</td>
            <td>" . $totals[8] . "</td>
        </tr>";

        echo "</tbody></table></div>";
    } else {
        echo "<p class='no-data'>No faculty data found for this department.</p>";
    }
    ?>
<?php
        // Query to get Journal details for all faculty in the department
        $journal_sql = "SELECT 
            j.faculty_id,
            ft.name AS faculty_name,
            j.Title,
            j.name_of_journal,
            j.author_type,
            j.publisher,
            j.place,
            j.vol_no_issue_no,
            j.ISSN,
            j.page_no,
            j.year,
            j.website_link
        FROM faculty_table ft
        JOIN journals j ON ft.faculty_id = j.faculty_id
        WHERE ft.department_name = ?";

        $stmt = $conn->prepare($journal_sql);
        $stmt->bind_param("s", $department_name);
        $stmt->execute();
        $journal_result = $stmt->get_result();

        if ($journal_result->num_rows > 0) {
            echo "<h1>Journal</h1>";
            echo "<div class='journal-table-container'>
                    <table class='fdp-table'>
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Name of Journal</th>
                                <th>Author Type</th>
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
                // Get the website link
                $website_link = htmlspecialchars($row['website_link']);
                
                echo "<tr>
                    <td>" . $sno++ . "</td>
                    <td>" . htmlspecialchars($row['faculty_name']) . "</td>
                    <td>" . htmlspecialchars($row['Title']) . "</td>
                    <td>" . htmlspecialchars($row['name_of_journal']) . "</td>
                    <td>" . htmlspecialchars($row['author_type']) . "</td>
                    <td>" . htmlspecialchars($row['publisher']) . "</td>
                    <td>" . htmlspecialchars($row['place']) . "</td>
                    <td>" . htmlspecialchars($row['vol_no_issue_no']) . "</td>
                    <td>" . htmlspecialchars($row['ISSN']) . "</td>
                    <td>" . htmlspecialchars($row['page_no']) . "</td>
                    <td>" . htmlspecialchars($row['year']) . "</td>
                    <td>" . (!empty($website_link) ? 
                            "<a href='" . $website_link . "' target='_blank' class='journal-link'>" . $website_link . "</a>" 
                            : "N/A") . "</td>
                </tr>";
            }
            
            echo "</tbody>
                </table>
                </div>";
            
            // Add CSS for the link styling
            echo "<style>
                .journal-link {
                    color: #0066cc;
                    text-decoration: none;
                }
                .journal-link:hover {
                    text-decoration: underline;
                    color: #003399;
                }
            </style>";
        } else {
            echo "<p class='no-data'>No Journal data found for this department.</p>";
        }
    ?>
    <br>
    <h1>FDP Attended</h1>
    <?php
    // Query to get FDP Conference details
    $fdp_sql = "SELECT 
        f.faculty_id,
        ft.name as faculty_name,
        f.Topic,
        f.Organizer,
        f.no_of_days,
        f.Place,
        f.Year
    FROM faculty_table ft
    JOIN fdp_conferences_attended f ON ft.faculty_id = f.faculty_id
    WHERE ft.department_name = ?";

    $stmt = $conn->prepare($fdp_sql);
    $stmt->bind_param("s", $department_name);
    $stmt->execute();
    $fdp_result = $stmt->get_result();

    if ($fdp_result->num_rows > 0) {
        echo "<div class='fdp-table-container'>
            <table class='fdp-table'>
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Topic</th>
                        <th>Organizer</th>
                        <th>No. of Days</th>
                        <th>Place</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>";
        
        $sno = 1;
        while ($row = $fdp_result->fetch_assoc()) {
            echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . htmlspecialchars($row['Topic']) . "</td>
                <td>" . htmlspecialchars($row['Organizer']) . "</td>
                <td>" . htmlspecialchars($row['no_of_days']) . "</td>
                <td>" . htmlspecialchars($row['Place']) . "</td>
                <td>" . htmlspecialchars($row['Year']) . "</td>
            </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p class='no-data'>No FDP Conference data found for this department.</p>";
    }
    ?>
    <br>
    <h1>Patent Details</h1>

    <?php
    // Query to get Patent details for all faculty in the department
    $patent_sql = "SELECT 
        p.faculty_id,
        ft.name as faculty_name,
        p.Title,
        p.Co_inventors,
        p.Ip_pct,
        p.year_of_publication,
        p.Status
    FROM faculty_table ft
    JOIN patents p ON ft.faculty_id = p.faculty_id
    WHERE ft.department_name = ?";

    $stmt = $conn->prepare($patent_sql);
    $stmt->bind_param("s", $department_name);
    $stmt->execute();
    $patent_result = $stmt->get_result();

    if ($patent_result->num_rows > 0) {
        echo "<div class='patent-table-container'>
            <table class='fdp-table'> <!-- Using same table styling as FDP -->
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Co-inventors</th>
                        <th>IP/PCT</th>
                        <th>Year of Publication</th>
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
                <td>" . htmlspecialchars($row['Co_inventors']) . "</td>
                <td>" . htmlspecialchars($row['Ip_pct']) . "</td>
                <td>" . htmlspecialchars($row['year_of_publication']) . "</td>
                <td>" . htmlspecialchars($row['Status']) . "</td>
            </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p class='no-data'>No Patent data found for this department.</p>";
    }
    ?>
    <br>
    <?php
// Query to get Books/Book Chapters details
$books_sql = "SELECT 
    b.faculty_id,
    b.Title,
    b.Publisher,
    b.Place,
    b.Year_of_publication,
    b.ISBN,
    b.Book_Chapter
FROM faculty_table ft
JOIN books_bookchapter b ON ft.faculty_id = b.faculty_id
WHERE ft.department_name = ?
ORDER BY b.Book_Chapter, b.Year_of_publication DESC"; // Added ordering

$stmt = $conn->prepare($books_sql);
$stmt->bind_param("s", $department_name);
$stmt->execute();
$books_result = $stmt->get_result();

// Initialize arrays to store books and chapters separately
$books = [];
$chapters = [];

// Separate the results into books and chapters
while ($row = $books_result->fetch_assoc()) {
    if (strtolower($row['Book_Chapter']) == 'book') {
        $books[] = $row;
    } else if (strtolower($row['Book_Chapter']) == 'chapter') {
        $chapters[] = $row;
    }
}

// Function to generate table
function generateTable($data, $type) {
    if (count($data) > 0) {
        echo "<h2>" . ucfirst($type) . "s</h2>";
        echo "<div class='" . strtolower($type) . "s-table-container'>
            <table class='fdp-table'>
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Title</th>
                        <th>Publisher</th>
                        <th>Place</th>
                        <th>Year of Publication</th>
                        <th>ISBN</th>
                    </tr>
                </thead>
                <tbody>";
        
        $sno = 1;
        foreach ($data as $row) {
            echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . htmlspecialchars($row['Title']) . "</td>
                <td>" . htmlspecialchars($row['Publisher']) . "</td>
                <td>" . htmlspecialchars($row['Place']) . "</td>
                <td>" . htmlspecialchars($row['Year_of_publication']) . "</td>
                <td>" . htmlspecialchars($row['ISBN']) . "</td>
            </tr>";
        }
        echo "</tbody></table></div><br>";
    }
}

// Display header
echo "<h1>Books and Book Chapters</h1>";

// Check if any data exists
if ($books_result->num_rows > 0) {
    // Display Books table
    generateTable($books, 'Book');
    
    // Display Chapters table
    generateTable($chapters, 'Chapter');
} else {
    echo "<p class='no-data'>No Books/Book Chapters data found for this department.</p>";
}
?>
    
    <br>
    <h1>Chair/Resource Person Details</h1>

    <?php
    // Query to get Chair/Resource Person details
    $chair_sql = "SELECT 
        cr.faculty_id,
        cr.Organization,
        cr.Chair_Resource,
        cr.Place,
        cr.Year
    FROM faculty_table ft
    JOIN chair_resource cr ON ft.faculty_id = cr.faculty_id
    WHERE ft.department_name = ?";

    $stmt = $conn->prepare($chair_sql);
    $stmt->bind_param("s", $department_name);
    $stmt->execute();
    $chair_result = $stmt->get_result();

    if ($chair_result->num_rows > 0) {
        echo "<div class='chair-table-container'>
            <table class='fdp-table'> <!-- Using same table styling as before -->
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Organization</th>
                        <th>Chair/Resource</th>
                        <th>Place</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>";
        
        $sno = 1;
        while ($row = $chair_result->fetch_assoc()) {
            echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . htmlspecialchars($row['Organization']) . "</td>
                <td>" . htmlspecialchars($row['Chair_Resource']) . "</td>
                <td>" . htmlspecialchars($row['Place']) . "</td>
                <td>" . htmlspecialchars($row['Year']) . "</td>
            </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p class='no-data'>No Chair/Resource Person data found for this department.</p>";
    }
    ?>

    <footer>
        <h2>Angadi Institute Of Technology And Management</h2>
    </footer>
</body>
</html>
<?php $conn->close(); ?>