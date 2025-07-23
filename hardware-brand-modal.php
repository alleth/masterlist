<?php

include "DAO/hardware-brand-DAO.php";

header('Content-Type: application/json');

if (!isset($_POST['item_desc']) || empty($_POST['item_desc'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing or empty item_desc"]);
    exit;
}

try {
    $handler = new BrandHandler();
    $brands = $handler->getBrandsByItem($_POST['item_desc']);
    echo json_encode($brands);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}