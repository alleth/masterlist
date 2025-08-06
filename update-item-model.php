<?php
require_once 'DAO/update-item-model-DAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['editModelID'] ?? '';
    $model = $_POST['editItemModel'] ?? '';

    if (empty($id) || empty($model)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        exit;
    }

    $dao = new UpdateItemModelDAO();
    $result = $dao->updateItemModel($id, $model);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Model updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update model.']);
    }
}
?>
