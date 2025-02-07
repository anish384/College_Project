<?php
// Include required PHPSpreadsheet classes
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator('Faculty Management System')
    ->setLastModifiedBy('Faculty Management System')
    ->setTitle('Faculty Department Report')
    ->setSubject('Faculty Department Data')
    ->setDescription('Export of all faculty department data');

// FDP/Seminar/Workshop Details (First Sheet)
$fdpSheet = $spreadsheet->getActiveSheet();
$fdpSheet->setTitle('FDP Details');

// Set headers for FDP sheet
$fdpHeaders = ['Sr. No', 'Faculty ID', 'Name', 'Topic', 'Organizer', 'No. of Days', 'Place', 'Year'];
$fdpSheet->fromArray([$fdpHeaders], NULL, 'A1');

// Query and fill FDP data
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

$row = 2;
$sno = 1;
while ($fdpData = $fdp_result->fetch_assoc()) {
    $fdpSheet->setCellValue('A'.$row, $sno++)
             ->setCellValue('B'.$row, $fdpData['faculty_id'])
             ->setCellValue('C'.$row, $fdpData['faculty_name'])
             ->setCellValue('D'.$row, $fdpData['Topic'])
             ->setCellValue('E'.$row, $fdpData['Organizer'])
             ->setCellValue('F'.$row, $fdpData['no_of_days'])
             ->setCellValue('G'.$row, $fdpData['Place'])
             ->setCellValue('H'.$row, $fdpData['Year']);
    $row++;
}

// Auto-size columns for FDP sheet
foreach (range('A', 'H') as $col) {
    $fdpSheet->getColumnDimension($col)->setAutoSize(true);
}

// Patents Details (Second Sheet)
$patentSheet = $spreadsheet->createSheet();
$patentSheet->setTitle('Patent Details');

// Set headers for Patent sheet
$patentHeaders = ['Sr. No', 'Faculty ID', 'Name', 'Title', 'Co-inventors', 'IP/PCT', 'Year of Publication', 'Status'];
$patentSheet->fromArray([$patentHeaders], NULL, 'A1');

// Query and fill Patent data
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

$row = 2;
$sno = 1;
while ($patentData = $patent_result->fetch_assoc()) {
    $patentSheet->setCellValue('A'.$row, $sno++)
                ->setCellValue('B'.$row, $patentData['faculty_id'])
                ->setCellValue('C'.$row, $patentData['faculty_name'])
                ->setCellValue('D'.$row, $patentData['Title'])
                ->setCellValue('E'.$row, $patentData['Co_inventors'])
                ->setCellValue('F'.$row, $patentData['Ip_pct'])
                ->setCellValue('G'.$row, $patentData['year_of_publication'])
                ->setCellValue('H'.$row, $patentData['Status']);
    $row++;
}

// Auto-size columns for Patent sheet
foreach (range('A', 'H') as $col) {
    $patentSheet->getColumnDimension($col)->setAutoSize(true);
}

// Books/Book Chapters (Third Sheet)
$booksSheet = $spreadsheet->createSheet();
$booksSheet->setTitle('Books Details');

// Set headers for Books sheet
$booksHeaders = ['Sr. No', 'Faculty ID', 'Title', 'Publisher', 'Place', 'Year of Publication', 'ISBN', 'Book/Chapter'];
$booksSheet->fromArray([$booksHeaders], NULL, 'A1');

// Query and fill Books data
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

$row = 2;
$sno = 1;
while ($booksData = $books_result->fetch_assoc()) {
    $booksSheet->setCellValue('A'.$row, $sno++)
               ->setCellValue('B'.$row, $booksData['faculty_id'])
               ->setCellValue('C'.$row, $booksData['Title'])
               ->setCellValue('D'.$row, $booksData['Publisher'])
               ->setCellValue('E'.$row, $booksData['Place'])
               ->setCellValue('F'.$row, $booksData['Year_of_publication'])
               ->setCellValue('G'.$row, $booksData['ISBN'])
               ->setCellValue('H'.$row, $booksData['Book_Chapter']);
    $row++;
}

// Auto-size columns for Books sheet
foreach (range('A', 'H') as $col) {
    $booksSheet->getColumnDimension($col)->setAutoSize(true);
}

// Conference Details (Fourth Sheet)
$conferenceSheet = $spreadsheet->createSheet();
$conferenceSheet->setTitle('Conference Details');

// Set headers for Conference sheet
$conferenceHeaders = ['Sr. No', 'Faculty ID', 'Name', 'Title', 'Name of Conference', 'International/National', 
                     'Publisher', 'Place', 'Year', 'Website Link', 'Author Type', 'Remarks'];
$conferenceSheet->fromArray([$conferenceHeaders], NULL, 'A1');

// Query and fill Conference data
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

$row = 2;
$sno = 1;
while ($conferenceData = $conference_result->fetch_assoc()) {
    $conferenceSheet->setCellValue('A'.$row, $sno++)
                   ->setCellValue('B'.$row, $conferenceData['faculty_id'])
                   ->setCellValue('C'.$row, $conferenceData['name'])
                   ->setCellValue('D'.$row, $conferenceData['Title'])
                   ->setCellValue('E'.$row, $conferenceData['Name_of_the_Conference'])
                   ->setCellValue('F'.$row, $conferenceData['International_National'])
                   ->setCellValue('G'.$row, $conferenceData['publisher'])
                   ->setCellValue('H'.$row, $conferenceData['place'])
                   ->setCellValue('I'.$row, $conferenceData['year'])
                   ->setCellValue('J'.$row, $conferenceData['website_link'])
                   ->setCellValue('K'.$row, $conferenceData['author_type'])
                   ->setCellValue('L'.$row, $conferenceData['remarks']);

    // Add hyperlink for website_link
    if (!empty($conferenceData['website_link'])) {
        $conferenceSheet->getCell('J'.$row)
            ->getHyperlink()
            ->setUrl($conferenceData['website_link']);
    }
    
    $row++;
}

// Add export information at the bottom
$infoRow = $row + 2; // Leave a blank row
$conferenceSheet->setCellValue('A'.$infoRow, 'Export Information:');
$conferenceSheet->setCellValue('A'.($infoRow+1), 'Generated on:');
$conferenceSheet->setCellValue('B'.($infoRow+1), '2025-02-06 17:20:18 UTC');
$conferenceSheet->setCellValue('A'.($infoRow+2), 'Generated by:');
$conferenceSheet->setCellValue('B'.($infoRow+2), 'vky6366');

// Style the export information
$conferenceSheet->getStyle('A'.$infoRow)->getFont()->setBold(true);
$conferenceSheet->getStyle('A'.($infoRow+1).':A'.($infoRow+2))->getFont()->setItalic(true);

// Auto-size columns
foreach (range('A', 'L') as $col) {
    $conferenceSheet->getColumnDimension($col)->setAutoSize(true);
}

// Style header row
$headerRange = 'A1:L1';
$conferenceSheet->getStyle($headerRange)->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF']
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4472C4']
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ]
]);

// Add borders to data cells
$dataRange = 'A1:L'.($row-1);
$conferenceSheet->getStyle($dataRange)->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        ]
    ],
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ]
]);

// Freeze panes
$conferenceSheet->freezePane('A2');

// Set zoom level
$conferenceSheet->getSheetView()->setZoomScale(100);

// Set row height for header
$conferenceSheet->getRowDimension(1)->setRowHeight(30);

// Enable auto-filter
$conferenceSheet->setAutoFilter($headerRange);
