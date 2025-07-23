<?php

include "DAO/hardware-item-description-modal-DAO.php";

header('Content-Type: application/json');

if (!isset($_GET['column']) || !isset($_GET['table'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing parameters"]);
    exit;
}

$table = $_GET['table'];
$column = $_GET['column'];

try {
    $handler = new OptionHandler();
    $options = $handler->fetchOptions($table, $column);
    echo json_encode($options);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}