<?php
require_once 'DAO/item-model-get-by-idDAO.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $dao = new ItemModelDAO();
    $model = $dao->getModelById($id);

    if ($model) {
        echo json_encode($model);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Model not found.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing ID.']);
}
