<?php
    require_once "DAO/hardware-update-details-DAO.php";

    header('Content-Type: application/json');

    if (!isset($_POST["hw_id"])) {
        echo json_encode(['error' => 'Invalid request: Hardware ID is missing.']);
        exit;
    }

    $hw_id = $_POST["hw_id"];
    $action = new updateDetailsDAO();
    $action->updateDetails($hw_id);
?>