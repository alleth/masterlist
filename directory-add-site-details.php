<?php
header('Content-Type: application/json');
include "DAO/directory-add-site-details-DAO.php";

try {
    // Validate and sanitize inputs
    $region_name = filter_input(INPUT_POST, 'region_name', FILTER_SANITIZE_NUMBER_INT);
    $site_code = filter_input(INPUT_POST, 'site_code', FILTER_SANITIZE_STRING);
    $site_name = filter_input(INPUT_POST, 'site_name', FILTER_SANITIZE_STRING);
    $office_type = filter_input(INPUT_POST, 'office_type', FILTER_SANITIZE_STRING);
    $site_address = filter_input(INPUT_POST, 'site_address', FILTER_SANITIZE_STRING);
    $site_partnership = filter_input(INPUT_POST, 'site_partnership', FILTER_SANITIZE_STRING);
    $trxn_catered = filter_input(INPUT_POST, 'trxn_catered', FILTER_SANITIZE_STRING) ?? '';
    $validate = filter_input(INPUT_POST, 'validate', FILTER_VALIDATE_BOOLEAN);
    $force = filter_input(INPUT_POST, 'force', FILTER_VALIDATE_BOOLEAN);

    if (!$region_name || !$site_code || !$site_name || !$office_type || !$site_address || !$site_partnership) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    // Validate transactions
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

    $action = new addSiteDetailsDAO();

    // Handle validation request
    if ($validate) {
        // Check for exact match (site_name, office_type, site_code)
        $exactMatch = $action->checkExactMatch($site_name, $office_type, $site_code);
        if ($exactMatch) {
            echo json_encode(['success' => false, 'exactMatch' => true, 'message' => 'A site with the same name, office type, and code already exists']);
            exit;
        }

        // Check for partial match (site_name, office_type)
        $nameTypeMatch = $action->checkNameTypeMatch($site_name, $office_type);
        if ($nameTypeMatch) {
            echo json_encode(['success' => false, 'nameTypeMatch' => true, 'message' => 'A site with the same name and office type exists']);
            exit;
        }

        // If no matches, validation passes
        echo json_encode(['success' => true, 'message' => 'Validation passed']);
        exit;
    }

    // Save site if no validation request or confirmed partial match
    if (!$force) {
        // Check for partial match again if not forced
        $nameTypeMatch = $action->checkNameTypeMatch($site_name, $office_type);
        if ($nameTypeMatch) {
            echo json_encode(['success' => false, 'nameTypeMatch' => true, 'message' => 'A site with the same name and office type exists']);
            exit;
        }
    }

    // Proceed with saving
    $result = $action->addSiteDetails($region_name, $site_code, $site_name, $office_type, $site_address, $site_partnership, $trxn_catered);
    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>