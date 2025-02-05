<?php
// Set time limit and error reporting
set_time_limit(300);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Constants for current time and user
define('CURRENT_TIME', '2025-02-05 15:48:17');
define('CURRENT_USER', 'vky6366');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// Function to download and save image
function downloadImage($url, $outputFile) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $image_data = curl_exec($ch);
    curl_close($ch);
    
    if ($image_data) {
        file_put_contents($outputFile, $image_data);
        return true;
    }
    return false;
}

// Create temp directory if it doesn't exist
$tempDir = __DIR__ . '/temp_images';
if (!file_exists($tempDir)) {
    mkdir($tempDir, 0777, true);
}

// Download images
$image1Path = $tempDir . '/suresh-angadi.jpg';
$image2Path = $tempDir . '/aitmbgm-logo.png';
$image3Path = $tempDir . '/aitm-logo.png';

downloadImage('https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/Suresh-Angadi.jpg', $image1Path);
downloadImage('https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitmbgm-logo.png', $image2Path);
downloadImage('https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitm-logo.png', $image3Path);

// Database connection
$conn = new mysqli("localhost", "root", "", "college_database");
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => "Connection failed: " . $conn->connect_error
    ]));
}

try {
    // Get faculty_id
    $faculty_id = isset($_GET['faculty_id']) ? $_GET['faculty_id'] : null;
    if (!$faculty_id) {
        throw new Exception("Error: Faculty ID not provided.");
    }

    // Create new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set fixed column widths for ALL columns (A-Z)
    foreach (range('A', 'Z') as $column) {
        $sheet->getColumnDimension($column)
              ->setWidth(18)
              ->setAutoSize(false);
    }

    // Add global style to force text wrapping vertically
    $defaultStyle = [
        'alignment' => [
            'wrapText' => true,
            'vertical' => Alignment::VERTICAL_TOP,
            'horizontal' => Alignment::HORIZONTAL_LEFT
        ]
    ];
    $sheet->getStyle('A:Z')->applyFromArray($defaultStyle);

    // Left side images
    if (file_exists($image1Path)) {
        $drawing1 = new Drawing();
        $drawing1->setName('Suresh Angadi');
        $drawing1->setDescription('Suresh Angadi');
        $drawing1->setPath($image1Path);
        $drawing1->setCoordinates('A1');
        $drawing1->setWidth(65);
        $drawing1->setHeight(50);
        $drawing1->setOffsetX(2);
        $drawing1->setWorksheet($sheet);
    }

    if (file_exists($image2Path)) {
        $drawing2 = new Drawing();
        $drawing2->setName('AITM Logo');
        $drawing2->setDescription('AITM Logo');
        $drawing2->setPath($image2Path);
        $drawing2->setCoordinates('B1');
        $drawing2->setWidth(65);
        $drawing2->setHeight(50);
        $drawing2->setOffsetX(2);
        $drawing2->setWorksheet($sheet);
    }

    // Right side image
    if (file_exists($image3Path)) {
        $drawing3 = new Drawing();
        $drawing3->setName('AITM Small Logo');
        $drawing3->setDescription('AITM Small Logo');
        $drawing3->setPath($image3Path);
        $drawing3->setCoordinates('F1');
        $drawing3->setWidth(65);
        $drawing3->setHeight(50);
        $drawing3->setOffsetX(-2);
        $drawing3->setWorksheet($sheet);
    }

    // Set row heights
    $sheet->getRowDimension(1)->setRowHeight(55);
    $sheet->getRowDimension(2)->setRowHeight(10);

    // Contact Information
    $sheet->setCellValue('A7', 'Phone: 0831-2438100/123');
    $sheet->setCellValue('D7', 'Email: info@aitmbgm.ac.in');
    $sheet->mergeCells('A7:C7');
    $sheet->mergeCells('D7:F7');
    $sheet->getStyle('A7:F7')->getFont()->setSize(10);

    // Header Style
    $headerStyle = [
        'font' => [
            'bold' => true,
            'size' => 10,
            'color' => ['rgb' => '000000'],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true,
        ],
        'borders' => [
            'outline' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFFFF'],
        ],
    ];

    // Institute Header
    $sheet->setCellValue('A9', 'SURESH ANGADI EDUCATION FOUNDATIONS');
    $sheet->mergeCells('A9:F9');
    $sheet->setCellValue('A10', 'ANGADI INSTITUTE OF TECHNOLOGY AND MANAGEMENT');
    $sheet->mergeCells('A10:F10');
    $sheet->setCellValue('A11', 'Approved by AICTE, New Delhi, Affiliated to VTU, Belagavi');
    $sheet->mergeCells('A11:F11');
    $sheet->setCellValue('A12', 'Accredited by *NBA and NAAC');
    $sheet->mergeCells('A12:F12');

    // Apply styles
    $sheet->getStyle('A9:F9')->getFont()->setSize(12);
    $sheet->getStyle('A9:F12')->applyFromArray($headerStyle);
    $sheet->getStyle('A7:F7')->getFont()->setBold(true);

    // Row heights for header section
    $sheet->getRowDimension(8)->setRowHeight(10);
    $sheet->getRowDimension(9)->setRowHeight(18);
    $sheet->getRowDimension(10)->setRowHeight(18);
    $sheet->getRowDimension(11)->setRowHeight(15);
    $sheet->getRowDimension(12)->setRowHeight(15);
    $sheet->getRowDimension(13)->setRowHeight(15);

    // Get faculty information
    $faculty_sql = "SELECT * FROM faculty_table WHERE faculty_id = ?";
    $stmt = $conn->prepare($faculty_sql);
    $stmt->bind_param("s", $faculty_id);
    $stmt->execute();
    $faculty_result = $stmt->get_result();
    $faculty_info = $faculty_result->fetch_assoc();

    if ($faculty_info) {
        $startRow = 13;
        $currentRow = $startRow;
    
        // Set column width for image
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
    
        // Add faculty image if it exists
        if (!empty($faculty_info['image'])) {
            // Construct the correct image path
            $baseDir = __DIR__;  // Gets the directory of current script (Display/)
            $imagePath = $baseDir . '/' . $faculty_info['image'];  // Complete path to image
    
            if (file_exists($imagePath)) {
                try {
                    $drawing = new Drawing();
                    $drawing->setName('Faculty Image');
                    $drawing->setDescription('Faculty Image');
                    $drawing->setPath($imagePath);  // Use direct path instead of copying
                    $drawing->setCoordinates('G' . $startRow);
                    $drawing->setWidth(150);
                    $drawing->setHeight(180);
                    $drawing->setOffsetX(2);
                    $drawing->setWorksheet($sheet);
                    
                    // Merge cells for image area
                    $sheet->mergeCells('G' . $startRow . ':H' . ($startRow + 6));
                    
                } catch (Exception $e) {
                    error_log("Error adding faculty image: " . $e->getMessage());
                }
            } else {
                error_log("Faculty image not found at: " . $imagePath);
            }
        }
    
        // Faculty Info Array - for easier management
        $facultyDetails = [
            'Faculty ID:' => 'faculty_id',
            'Name:' => 'name',
            'Department:' => 'department_name',
            'Designation:' => 'Designation',
            'Date of Joining:' => 'date_of_joining',
            'Email:' => 'email_id',
            'Contact:' => 'contact_no'
        ];
    
        // Add faculty details
        foreach ($facultyDetails as $label => $field) {
            $sheet->setCellValue('A' . $currentRow, $label);
            $sheet->setCellValue('B' . $currentRow, $faculty_info[$field]);
            $sheet->mergeCells('B' . $currentRow . ':F' . $currentRow);
    
            // Apply style to current row
            $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray([
                'font' => [
                    'size' => 10,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);
    
            // Set row height
            $sheet->getRowDimension($currentRow)->setRowHeight(25);
            
            $currentRow++;
        }
    
        // Add spacing after faculty info
        $sheet->getRowDimension($currentRow)->setRowHeight(10);
        $currentRow++;
    }
    // List of tables
    $tables_info = [
        'experience' => 'Professional Experience',
        'awards' => 'Awards and Achievements',
        'books_bookchapter' => 'Books & Book Chapters',
        'chair_resource' => 'Resource Person Experience',
        'conference' => 'Conference Publications',
        'fdp_conferences_attended' => 'FDP & Conferences Attended',
        'for_scholars_dr' => 'Scholar Guidance',
        'journals' => 'Journal Publications',
        'mtech_guided' => 'M.Tech Projects Guided',
        'patents' => 'Patents',
        'phd_guided_guiding' => 'PhD Guidance',
        'professional_memberships' => 'Professional Memberships',
        'qualification' => 'Academic Qualifications',
        'research_grants' => 'Research Grants',
        'research_grants_till_now' => 'Cumulative Research Grants',
        'students_project_grants' => 'Student Project Grants',
        'others' => 'Other Achievements'
    ];

    foreach ($tables_info as $table => $display_name) {
        // Section header
        $sheet->setCellValue('A' . $currentRow, strtoupper($display_name));
        $sheet->mergeCells('A' . $currentRow . ':F' . $currentRow);
        $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray($headerStyle);
        $currentRow += 2;

        $sql = "SELECT * FROM $table WHERE faculty_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $faculty_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Get headers
            $headers = [];
            $fields = $result->fetch_fields();
            $col = 'A';
            foreach ($fields as $field) {
                if (!in_array($field->name, ['faculty_id', 'sr_no'])) {
                    $headers[] = ucfirst(str_replace('_', ' ', $field->name));
                    $sheet->setCellValue($col . $currentRow, $headers[count($headers)-1]);
                    $col++;
                }
            }
            
            // Style headers
            $lastCol = --$col;
            $sheet->getStyle('A' . $currentRow . ':' . $lastCol . $currentRow)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F0F0F0'],
                ],
                'alignment' => [
                    'wrapText' => true,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ]);
            $currentRow++;

            // Add data rows with vertical wrapping
            while ($row = $result->fetch_assoc()) {
                $col = 'A';
                foreach ($row as $key => $value) {
                    if (!in_array($key, ['faculty_id', 'sr_no'])) {
                        $sheet->setCellValue($col . $currentRow, $value);
                        $sheet->getStyle($col . $currentRow)->applyFromArray([
                            'alignment' => [
                                'wrapText' => true,
                                'vertical' => Alignment::VERTICAL_TOP,
                                'horizontal' => Alignment::HORIZONTAL_LEFT
                            ]
                        ]);
                        // Set row height to accommodate wrapped text
                        $sheet->getRowDimension($currentRow)->setRowHeight(-1);
                        $col++;
                    }
                }
                $currentRow++;
            }
        } else {
            $sheet->setCellValue('A' . $currentRow, 'No data available');
            $sheet->mergeCells('A' . $currentRow . ':F' . $currentRow);
            $currentRow++;
        }

        $currentRow += 2;
        $stmt->close();
    }

    // Add footer
    $currentRow += 1;
    $sheet->setCellValue('A' . $currentRow, 'Report Generated by: ' . CURRENT_USER);
    $sheet->mergeCells('A' . $currentRow . ':C' . $currentRow);
    $sheet->setCellValue('D' . $currentRow, 'Generated on: ' . CURRENT_TIME);
    $sheet->mergeCells('D' . $currentRow . ':F' . $currentRow);
    $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray([
        'font' => ['italic' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
    ]);

    // Create Excel file
    $writer = new Xlsx($spreadsheet);

    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="AITM_Faculty_Data_' . 
        $faculty_id . '_' . date('Y-m-d', strtotime(CURRENT_TIME)) . '.xlsx"');
    header('Cache-Control: max-age=0');

    // Output file
    $writer->save('php://output');

    // Clean up temporary images
    if (file_exists($image1Path)) unlink($image1Path);
    if (file_exists($image2Path)) unlink($image2Path);
    if (file_exists($image3Path)) unlink($image3Path);
    if (is_dir($tempDir)) rmdir($tempDir);

} catch (Exception $e) {
    error_log("Error in faculty data download: " . $e->getMessage());
    echo "An error occurred while generating the Excel file: " . $e->getMessage();
}

$conn->close();
?>