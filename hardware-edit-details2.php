<?php
include "DAO/hardware-edit-details-DAO2.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hw_id'])) {
    $dao = new HardwareEditFetchDAO();
    $id = intval($_POST['hw_id']);

    header('Content-Type: application/json');
    echo json_encode($dao->getHardwareById($id));
    exit;
}
