<?php
include "DAO/software-cpupc-edit-DAO.php";

$hw_id = isset($_POST['hw_id']) ? intval($_POST['hw_id']) : 0;

$response = ["success" => false, "message" => "", "hw" => []];

if ($hw_id > 0) {
    $dao = new CpuPcEditDAO();
    $hwData = $dao->getCpuPcDetailsById($hw_id);

    if ($hwData) {
        $response["success"] = true;
        $response["hw"] = $hwData;
    } else {
        $response["message"] = "No record found.";
    }
} else {
    $response["message"] = "Invalid hardware ID.";
}

header('Content-Type: application/json');
echo json_encode($response);
