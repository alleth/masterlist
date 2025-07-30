<?php
require_once 'DAO/hardware-download-csv-dataDAO.php';
require_once 'vendor/autoload.php'; // Autoload PhpSpreadsheet classes

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Get site_code from query
$site_code = $_GET['site_code'] ?? '';
if (!$site_code) {
    die("Site code is required.");
}

// Fetch data
$dao = new HardwareExportDAO();
$data = $dao->fetchHardwareBySite($site_code);

// Create spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header row
$headers = [
    'Region',
    'Site Code',
    'Site Name',
    'Item Description',
    'Item Brand',
    'Item Model',
    'Asset Number',
    'Serial Number'
];
$sheet->fromArray($headers, NULL, 'A1');

// Write data rows starting from row 2
$rowNum = 2;
foreach ($data as $row) {
    $sheet->fromArray([
        $row['region_name'],
        $row['site_code'],
        $row['site_name'],
        $row['item_desc'],
        $row['hw_brand_name'],
        $row['hw_model'],
        $row['hw_asset_num'],
        $row['hw_serial_num']
    ], NULL, "A{$rowNum}");
    $rowNum++;
}

// Optional: Set column widths for better spacing
$columnWidths = [
    'A' => 20, // Region
    'B' => 15, // Site Code
    'C' => 25, // Site Name
    'D' => 25, // Item Description
    'E' => 20, // Item Brand
    'F' => 25, // Item Model
    'G' => 20, // Asset Number
    'H' => 25  // Serial Number
];

foreach ($columnWidths as $col => $width) {
    $sheet->getColumnDimension($col)->setWidth($width);
}

// Prepare XLSX download
$timestamp = date('Y-m-d_H-i-s');
$filename = "hardware_inventory_{$site_code}_{$timestamp}.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
