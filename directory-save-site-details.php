<?php
header('Content-Type: application/json');
include "DAO/directory-save-site-details-DAO.php";

try {
    $site_id = filter_input(INPUT_POST, 'site_id', FILTER_SANITIZE_NUMBER_INT);
    $region_name = filter_input(INPUT_POST, 'region_name', FILTER_SANITIZE_NUMBER_INT);
    $site_code = filter_input(INPUT_POST, 'site_code', FILTER_SANITIZE_STRING);
    $site_name = filter_input(INPUT_POST, 'site_name', FILTER_SANITIZE_STRING);
    $office_type = filter_input(INPUT_POST, 'office_type', FILTER_SANITIZE_STRING);
    $site_address = filter_input(INPUT_POST, 'site_address', FILTER_SANITIZE_STRING);
    $site_partnership = filter_input(INPUT_POST, 'site_partnership', FILTER_SANITIZE_STRING);
    $trxn_catered = filter_input(INPUT_POST, 'trxn_catered', FILTER_SANITIZE_STRING) ?? '';
    $force = isset($_POST['force']) ? filter_var($_POST['force'], FILTER_VALIDATE_BOOLEAN) : false;

    if (!$site_id || !$region_name || !$site_code || !$site_name || !$office_type || !$site_address || !$site_partnership) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    $valid_transactions = ['MV', 'DL', 'LETAS', 'MAIDRS', 'NRU', 'None'];
    if ($trxn_catered !== '') {
        $transactions = explode(',', $trxn_catered);
        foreach ($transactions as $transaction) {
            if (!in_array(trim($transaction), $valid_transactions)) {
                echo json_encode(['success' => false, 'message' => 'Invalid transaction type: ' . htmlspecialchars($transaction)]);
                exit;
            }
        }
    }

    $action = new saveSiteDetailsDAO();
    $result = $action->saveSiteDetails(
        $site_id,
        $region_name,
        $site_code,
        $site_name,
        $office_type,
        $site_address,
        $site_partnership,
        $trxn_catered,
        $force
    );

    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
