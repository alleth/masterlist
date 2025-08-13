<?php
require_once 'DAO/download-backup-DAO.php';

// Clear output buffer
if (ob_get_length()) ob_end_clean();

// Generate filename with current date
$date = date('Y-m-d'); // YYYY-MM-DD format
$filename = "hw_tbl_backup_{$date}.csv";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Pragma: no-cache');
header('Expires: 0');

$dao = new BackupDownloadDAO();
$rows = $dao->getAllHardwareBackup();

$output = fopen('php://output', 'w');

// CSV headers
$headers = [
    'hw_id','region_name','site_code','major_type','sub_major_type',
    'item_desc','hw_brand_name','hw_model','hw_asset_num','hw_serial_num',
    'hw_date_acq','hw_acq_val','hw_status','hw_host_name','hw_ip_add',
    'hw_mac_add','hw_user_name','hw_primary_role','hw_memory','hdd_capacity',
    'hdd_free_space','hdd_health','os_type','core_buid','rsu_fac','mv_dto',
    'mv_maint','ims_aiu','dl_dto','dl_maint','dotnet','hw_antivi','ports_num',
    'ports_working','ports_deffect','user_id'
];
fputcsv($output, $headers);

// Output each row
foreach ($rows as $row) {
    fputcsv($output, $row);
}

fclose($output);
exit;

