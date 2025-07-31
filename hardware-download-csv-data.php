<?php
require_once 'DAO/hardware-download-csv-dataDAO.php';
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$site_code = $_GET['site_code'] ?? '';
$region_name = $_GET['region_name'] ?? '';

if (!$site_code) {
    die("Site code is required.");
}

$dao = new HardwareExportDAO();

// Fetch data based on site/region logic
if (strtolower(trim($site_code)) === "all site") {
    if (!$region_name) {
        die("Region name is required for 'All Site'.");
    }
    $data = $dao->fetchHardwareByRegion($region_name);
    $label = preg_replace('/\s+/', '_', $region_name);
} else {
    $data = $dao->fetchHardwareBySite($site_code);
    $label = preg_replace('/\s+/', '_', $site_code);
}

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

// Style the header
$headerStyle = $sheet->getStyle('A1:H1');
$headerStyle->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
$headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4F81BD');
$headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$headerStyle->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

// Fill in the data
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

// Auto left-align all data
$lastRow = $rowNum - 1;
$sheet->getStyle("A2:H{$lastRow}")
      ->getAlignment()
      ->setHorizontal(Alignment::HORIZONTAL_LEFT);

// Set custom column widths (instead of auto size)
$columnWidths = [
    'A' => 20, 'B' => 15, 'C' => 25, 'D' => 25,
    'E' => 20, 'F' => 25, 'G' => 20, 'H' => 25
];
foreach ($columnWidths as $col => $width) {
    $sheet->getColumnDimension($col)->setWidth($width);
}

// Prepare file for download
$timestamp = date('Y-m-d_H-i-s');
$filename = "hardware_inventory_{$label}_{$timestamp}.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
