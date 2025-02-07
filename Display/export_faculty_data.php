<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get department name
if (isset($_POST['department_name'])) {
    $department_name = $conn->real_escape_string($_POST['department_name']);
} else {
    die("Department name not specified");
}

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Department Report');

// Define styles
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF']
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4472C4']
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true
    ]
];

$titleStyle = [
    'font' => [
        'bold' => true,
        'size' => 14
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true
    ]
];

$dataStyle = [
    'alignment' => [
        'vertical' => Alignment::VERTICAL_TOP,
        'wrapText' => true
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
];

// Style metadata
$sheet->getStyle('A1:A2')->applyFromArray([
    'font' => [
        'italic' => true,
        'size' => 10
    ]
]);

// Set column widths
$columnWidths = [
    'A' => 8,  // Sr. No
    'B' => 15, // Faculty ID
    'C' => 25, // Name
    'D' => 45, // Title
    'E' => 45, // Organization/Journal/Conference
    'F' => 20, // Various
    'G' => 25, // Publisher
    'H' => 20, // Place
    'I' => 15, // Year/Vol
    'J' => 35, // Website/ISSN
    'K' => 20, // Author Type
    'L' => 30, // Remarks
    'M' => 35, // Additional columns for journals
    'N' => 20,
    'O' => 15,
    'P' => 30,
    'Q' => 15,
    'R' => 15,
    'S' => 15,
    'T' => 15,
    'U' => 15
];

foreach ($columnWidths as $col => $width) {
    $sheet->getColumnDimension($col)->setWidth($width);
}

// Current row tracker
$currentRow = 3;

// Faculty Summary Section
$sheet->setCellValue('A' . $currentRow, 'Faculty Summary');
$sheet->mergeCells('A' . $currentRow . ':L' . $currentRow); // Changed from K to L for new column
$sheet->getStyle('A' . $currentRow)->applyFromArray($titleStyle);
$currentRow++;

$summaryHeaders = [
    'S.NO.',
    'Faculty ID',    // Added Faculty ID column
    'NAME OF THE FACULTY',
    'INTERNATIONAL JOURNAL',
    'INTERNATIONAL CONFERENCE',
    'BOOK CHAPTERS',
    'PATENTS',
    'Resource Person',
    'FDP',
    'Citations',
    'Awards',
    'Total'
];
$sheet->fromArray([$summaryHeaders], NULL, 'A' . $currentRow);
$sheet->getStyle('A' . $currentRow . ':L' . $currentRow)->applyFromArray($headerStyle); // Changed from K to L
$currentRow++;

// Query remains the same as it already includes faculty_id
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

$sno = 1;
$startRow = $currentRow;
$totals = array_fill(0, 9, 0); // Array to store column totals

while ($row = $summary_result->fetch_assoc()) {
    // Calculate row total
    $row_total = $row['int_journals'] + 
                 $row['int_conferences'] + 
                 $row['book_chapters'] + 
                 $row['patents'] + 
                 $row['resource_person'] + 
                 $row['fdp_count'];

    $sheet->setCellValue('A' . $currentRow, $sno++)
          ->setCellValue('B' . $currentRow, $row['faculty_id'])  // Added Faculty ID
          ->setCellValue('C' . $currentRow, $row['name'])
          ->setCellValue('D' . $currentRow, $row['int_journals'])
          ->setCellValue('E' . $currentRow, $row['int_conferences'])
          ->setCellValue('F' . $currentRow, $row['book_chapters'])
          ->setCellValue('G' . $currentRow, $row['patents'])
          ->setCellValue('H' . $currentRow, $row['resource_person'])
          ->setCellValue('I' . $currentRow, $row['fdp_count'])
          ->setCellValue('J' . $currentRow, $row['total_citations'])
          ->setCellValue('K' . $currentRow, $row['awards'])
          ->setCellValue('L' . $currentRow, $row_total);

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

    $sheet->getRowDimension($currentRow)->setRowHeight(-1);
    $sheet->getStyle('A' . $currentRow . ':L' . $currentRow)->applyFromArray($dataStyle); // Changed from K to L
    $currentRow++;
}

// Add totals row with bold formatting
$totalStyle = array_merge($dataStyle, [
    'font' => ['bold' => true],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'F0F0F0']
    ]
]);

$sheet->setCellValue('A' . $currentRow, 'Total')
      ->setCellValue('B' . $currentRow, '')  // Empty cell for Faculty ID
      ->setCellValue('C' . $currentRow, '')  // Empty cell for Name
      ->setCellValue('D' . $currentRow, $totals[0])
      ->setCellValue('E' . $currentRow, $totals[1])
      ->setCellValue('F' . $currentRow, $totals[2])
      ->setCellValue('G' . $currentRow, $totals[3])
      ->setCellValue('H' . $currentRow, $totals[4])
      ->setCellValue('I' . $currentRow, $totals[5])
      ->setCellValue('J' . $currentRow, $totals[6])
      ->setCellValue('K' . $currentRow, $totals[7])
      ->setCellValue('L' . $currentRow, $totals[8]);

$sheet->getStyle('A' . $currentRow . ':L' . $currentRow)->applyFromArray($totalStyle); // Changed from K to L

// Add borders to Summary table
$sheet->getStyle('A' . ($startRow - 1) . ':L' . $currentRow)->applyFromArray([ // Changed from K to L
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
]);

// Set column widths
$columnWidths = [
    'A' => 6,   // Sr. No
    'B' => 12,  // Faculty ID
    'C' => 25,  // Name
    'D' => 15,  // Int Journal
    'E' => 15,  // Int Conference
    'F' => 12,  // Book Chapters
    'G' => 10,  // Patents
    'H' => 12,  // Resource Person
    'I' => 10,  // FDP
    'J' => 10,  // Citations
    'K' => 10,  // Awards
    'L' => 10   // Total
];

foreach ($columnWidths as $col => $width) {
    $sheet->getColumnDimension($col)->setWidth($width);
}

// Add spacing
$currentRow += 3;

// 1. FDP Section
$sheet->setCellValue('A' . $currentRow, 'FDP/Seminar/Workshop Details');
$sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
$sheet->getStyle('A' . $currentRow)->applyFromArray($titleStyle);
$currentRow++;

$fdpHeaders = ['Sr. No', 'Faculty ID', 'Name', 'Topic', 'Organizer', 'No. of Days', 'Place', 'Year'];
$sheet->fromArray([$fdpHeaders], NULL, 'A' . $currentRow);
$sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($headerStyle);
$currentRow++;

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

$sno = 1;
$startRow = $currentRow;
while ($fdpData = $fdp_result->fetch_assoc()) {
    $sheet->setCellValue('A' . $currentRow, $sno++)
          ->setCellValue('B' . $currentRow, $fdpData['faculty_id'])
          ->setCellValue('C' . $currentRow, $fdpData['faculty_name'])
          ->setCellValue('D' . $currentRow, $fdpData['Topic'])
          ->setCellValue('E' . $currentRow, $fdpData['Organizer'])
          ->setCellValue('F' . $currentRow, $fdpData['no_of_days'])
          ->setCellValue('G' . $currentRow, $fdpData['Place'])
          ->setCellValue('H' . $currentRow, $fdpData['Year']);
    
    $sheet->getRowDimension($currentRow)->setRowHeight(-1);
    $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($dataStyle);
    $currentRow++;
}

// Add borders to FDP table
$sheet->getStyle('A' . ($startRow - 1) . ':H' . ($currentRow - 1))->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
]);

// Add spacing
$currentRow += 3;

// 2. Patents Section
$sheet->setCellValue('A' . $currentRow, 'Patent Details');
$sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
$sheet->getStyle('A' . $currentRow)->applyFromArray($titleStyle);
$currentRow++;

$patentHeaders = ['Sr. No', 'Faculty ID', 'Name', 'Title', 'Co-inventors', 'IP/PCT', 'Year of Publication', 'Status'];
$sheet->fromArray([$patentHeaders], NULL, 'A' . $currentRow);
$sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($headerStyle);
$currentRow++;

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

$sno = 1;
$startRow = $currentRow;
while ($patentData = $patent_result->fetch_assoc()) {
    $sheet->setCellValue('A' . $currentRow, $sno++)
          ->setCellValue('B' . $currentRow, $patentData['faculty_id'])
          ->setCellValue('C' . $currentRow, $patentData['faculty_name'])
          ->setCellValue('D' . $currentRow, $patentData['Title'])
          ->setCellValue('E' . $currentRow, $patentData['Co_inventors'])
          ->setCellValue('F' . $currentRow, $patentData['Ip_pct'])
          ->setCellValue('G' . $currentRow, $patentData['year_of_publication'])
          ->setCellValue('H' . $currentRow, $patentData['Status']);

    $sheet->getRowDimension($currentRow)->setRowHeight(-1);
    $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($dataStyle);
    $currentRow++;
}

// Add borders to Patent table
$sheet->getStyle('A' . ($startRow - 1) . ':H' . ($currentRow - 1))->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
]);

// Add spacing
$currentRow += 3;

// 3. Books Section
$sheet->setCellValue('A' . $currentRow, 'Books/Book Chapters');
$sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
$sheet->getStyle('A' . $currentRow)->applyFromArray($titleStyle);
$currentRow++;

$booksHeaders = ['Sr. No', 'Faculty ID', 'Title', 'Publisher', 'Place', 'Year of Publication', 'ISBN', 'Book/Chapter'];
$sheet->fromArray([$booksHeaders], NULL, 'A' . $currentRow);
$sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($headerStyle);
$currentRow++;

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
WHERE ft.department_name = ?";

$stmt = $conn->prepare($books_sql);
$stmt->bind_param("s", $department_name);
$stmt->execute();
$books_result = $stmt->get_result();

$sno = 1;
$startRow = $currentRow;
while ($booksData = $books_result->fetch_assoc()) {
    $sheet->setCellValue('A' . $currentRow, $sno++)
          ->setCellValue('B' . $currentRow, $booksData['faculty_id'])
          ->setCellValue('C' . $currentRow, $booksData['Title'])
          ->setCellValue('D' . $currentRow, $booksData['Publisher'])
          ->setCellValue('E' . $currentRow, $booksData['Place'])
          ->setCellValue('F' . $currentRow, $booksData['Year_of_publication'])
          ->setCellValue('G' . $currentRow, $booksData['ISBN'])
          ->setCellValue('H' . $currentRow, $booksData['Book_Chapter']);

    $sheet->getRowDimension($currentRow)->setRowHeight(-1);
    $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($dataStyle);
    $currentRow++;
}

// Add borders to Books table
$sheet->getStyle('A' . ($startRow - 1) . ':H' . ($currentRow - 1))->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
]);
// Add spacing
$currentRow += 3;

// 4. Journals Section
$sheet->setCellValue('A' . $currentRow, 'Journals');
$sheet->mergeCells('A' . $currentRow . ':T' . $currentRow);
$sheet->getStyle('A' . $currentRow)->applyFromArray($titleStyle);
$currentRow++;

// Define header columns for the Journals table
$journalsHeaders = [
    'Sr. No', 
    'Faculty ID', 
    'Title', 
    'Name of Journal', 
    'Author Type', 
    'Publisher', 
    'Place', 
    'Vol/Issue', 
    'ISSN', 
    'Page No', 
    'Year', 
    'Website Link', 
    'International/National', 
    'Free/Paid', 
    'Indexing', 
    'Impact Factor', 
    'SNIP', 
    'SJR', 
    'H-Index', 
    'Citations'
];
$sheet->fromArray([$journalsHeaders], NULL, 'A' . $currentRow);
$sheet->getStyle('A' . $currentRow . ':T' . $currentRow)->applyFromArray($headerStyle);
$currentRow++;

// SQL query to fetch Journals data for all faculty in the department
$journals_sql = "SELECT 
    j.faculty_id,
    j.Title,
    j.name_of_journal,
    j.author_type,
    j.publisher,
    j.place,
    j.vol_no_issue_no,
    j.ISSN,
    j.page_no,
    j.year,
    j.website_link,
    j.international_national,
    j.free_paid,
    j.indexing,
    j.impact_factor,
    j.SNIP,
    j.SJR,
    j.h_index,
    j.citations
FROM faculty_table ft
JOIN journals j ON ft.faculty_id = j.faculty_id
WHERE ft.department_name = ?";

$stmt = $conn->prepare($journals_sql);
$stmt->bind_param("s", $department_name);
$stmt->execute();
$journals_result = $stmt->get_result();

$sno = 1;
$startRow = $currentRow;

// Loop through each row of Journals data and add it to the sheet
while ($journalsData = $journals_result->fetch_assoc()) {
    $sheet->setCellValue('A' . $currentRow, $sno++)
          ->setCellValue('B' . $currentRow, $journalsData['faculty_id'])
          ->setCellValue('C' . $currentRow, $journalsData['Title'])
          ->setCellValue('D' . $currentRow, $journalsData['name_of_journal'])
          ->setCellValue('E' . $currentRow, $journalsData['author_type'])
          ->setCellValue('F' . $currentRow, $journalsData['publisher'])
          ->setCellValue('G' . $currentRow, $journalsData['place'])
          ->setCellValue('H' . $currentRow, $journalsData['vol_no_issue_no'])
          ->setCellValue('I' . $currentRow, $journalsData['ISSN'])
          ->setCellValue('J' . $currentRow, $journalsData['page_no'])
          ->setCellValue('K' . $currentRow, $journalsData['year'])
          ->setCellValue('L' . $currentRow, $journalsData['website_link'])
          ->setCellValue('M' . $currentRow, $journalsData['international_national'])
          ->setCellValue('N' . $currentRow, $journalsData['free_paid'])
          ->setCellValue('O' . $currentRow, $journalsData['indexing'])
          ->setCellValue('P' . $currentRow, $journalsData['impact_factor'])
          ->setCellValue('Q' . $currentRow, $journalsData['SNIP'])
          ->setCellValue('R' . $currentRow, $journalsData['SJR'])
          ->setCellValue('S' . $currentRow, $journalsData['h_index'])
          ->setCellValue('T' . $currentRow, $journalsData['citations']);

    // Adjust row height to accommodate text wrapping
    $sheet->getRowDimension($currentRow)->setRowHeight(-1);
    // Apply data style for the current row
    $sheet->getStyle('A' . $currentRow . ':T' . $currentRow)->applyFromArray($dataStyle);
    $currentRow++;
}

// Add borders around the Journals table
$sheet->getStyle('A' . ($startRow - 1) . ':T' . ($currentRow - 1))->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
]);


// 5. Conference Section
$sheet->setCellValue('A' . $currentRow, 'Conference Details');
$sheet->mergeCells('A' . $currentRow . ':L' . $currentRow);
$sheet->getStyle('A' . $currentRow)->applyFromArray($titleStyle);
$currentRow++;

$conferenceHeaders = [
    'Sr. No', 'Faculty ID', 'Name', 'Title', 'Conference Name', 
    'International/National', 'Publisher', 'Place', 'Year', 
    'Website Link', 'Author Type', 'Remarks'
];
$sheet->fromArray([$conferenceHeaders], NULL, 'A' . $currentRow);
$sheet->getStyle('A' . $currentRow . ':L' . $currentRow)->applyFromArray($headerStyle);
$currentRow++;

$conference_sql = "SELECT 
    c.faculty_id,
    ft.name,
    c.Title,
    c.Name_of_the_Conference,
    c.International_National,
    c.publisher,
    c.place,
    c.year,
    c.website_link,
    c.author_type,
    c.remarks
FROM faculty_table ft
JOIN conference c ON ft.faculty_id = c.faculty_id
WHERE ft.department_name = ?";

$stmt = $conn->prepare($conference_sql);
$stmt->bind_param("s", $department_name);
$stmt->execute();
$conference_result = $stmt->get_result();

$sno = 1;
$startRow = $currentRow;
while ($conferenceData = $conference_result->fetch_assoc()) {
    $sheet->setCellValue('A' . $currentRow, $sno++)
          ->setCellValue('B' . $currentRow, $conferenceData['faculty_id'])
          ->setCellValue('C' . $currentRow, $conferenceData['name'])
          ->setCellValue('D' . $currentRow, $conferenceData['Title'])
          ->setCellValue('E' . $currentRow, $conferenceData['Name_of_the_Conference'])
          ->setCellValue('F' . $currentRow, $conferenceData['International_National'])
          ->setCellValue('G' . $currentRow, $conferenceData['publisher'])
          ->setCellValue('H' . $currentRow, $conferenceData['place'])
          ->setCellValue('I' . $currentRow, $conferenceData['year'])
          ->setCellValue('J' . $currentRow, $conferenceData['website_link'])
          ->setCellValue('K' . $currentRow, $conferenceData['author_type'])
          ->setCellValue('L' . $currentRow, $conferenceData['remarks']);

    $sheet->getRowDimension($currentRow)->setRowHeight(-1);
    $sheet->getStyle('A' . $currentRow . ':L' . $currentRow)->applyFromArray($dataStyle);
    $currentRow++;
}

// Add borders to Conference table
$sheet->getStyle('A' . ($startRow - 1) . ':L' . ($currentRow - 1))->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
]);
// Final formatting
for ($row = 1; $row <= $currentRow; $row++) {
    $sheet->getRowDimension($row)->setRowHeight(-1);
}

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $department_name . '_Faculty_Report_' . date('Y-m-d') . '.xlsx"');
header('Cache-Control: max-age=0');

// Create Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>