<?php
require_once "DAO/hardware-update-details-DAO.php";

header('Content-Type: application/json');

if (!isset($_POST["action"])) {
    echo json_encode(['error' => 'Invalid request: Action is missing.']);
    exit;
}

$action_type = $_POST["action"];
$action = new updateDetailsDAO();

if ($action_type === 'fetch_hardware') {
    if (!isset($_POST["hw_id"])) {
        echo json_encode(['error' => 'Invalid request: Hardware ID is missing.']);
        exit;
    }
    $hw_id = $_POST["hw_id"];
    $action->updateDetails($hw_id);
} elseif ($action_type === 'fetch_brands') {
    if (!isset($_POST["item_desc"])) {
        echo json_encode(['error' => 'Invalid request: Item Description is missing.']);
        exit;
    }
    $item_desc = $_POST["item_desc"];
    $action->fetchBrands($item_desc);
} elseif ($action_type === 'fetch_models') {
    if (!isset($_POST["item_desc"]) || !isset($_POST["brand"])) {
        echo json_encode(['error' => 'Invalid request: Item Description or Brand is missing.']);
        exit;
    }
    $item_desc = $_POST["item_desc"];
    $brand = $_POST["brand"];
    $action->fetchModels($item_desc, $brand);
} else {
    echo json_encode(['error' => 'Invalid action specified.']);
}
?>