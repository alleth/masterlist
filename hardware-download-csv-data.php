<?php
require_once 'DAO/hardware-download-csv-dataDAO.php';

$site_code = $_GET['site_code'] ?? '';
if (!$site_code) {
    die("Site code is required.");
}

$dao = new HardwareExportDAO();
$data = $dao->fetchHardwareBySite($site_code);

$timestamp = date('Y-m-d_H-i-s');
$filename = "hardware_inventory_{$site_code}_{$timestamp}.csv";

header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"$filename\"");

$output = fopen('php://output', 'w');
fputcsv($output, [
    'Region',
    'Site Code',
    'Item Description',
    'Item Brand',
    'Item Model',
    'Asset Number',
    'Serial Number'
]);

foreach ($data as $row) {
    fputcsv($output, $row);
}

fclose($output);
exit;
