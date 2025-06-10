<?php
include "DAO/hardwares-change-model-DAO.php";

$hw_id = isset($_POST["hw_id"]) ? $_POST["hw_id"] : "";
$brand_name = isset($_POST["brand_name"]) ? $_POST["brand_name"] : "";

if (empty($hw_id) || empty($brand_name)) {
    echo json_encode(["hw_model" => [], "error" => "Missing hardware ID or brand name"]);
    return;
}

$action = new changeModelDAO();
$action->changeModel($hw_id, $brand_name);
?>