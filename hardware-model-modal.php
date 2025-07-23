<?php
include "DAO/hardware-model-DAO.php";

header('Content-Type: application/json');

if (!isset($_POST['item_desc']) || !isset($_POST['brand'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing parameters"]);
    exit;
}

$item_desc = $_POST['item_desc'];
$brand = $_POST['brand'];

try {
    $handler = new ModelHandler();
    $models = $handler->getModelsByItemAndBrand($item_desc, $brand);
    echo json_encode($models);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>