<?php
require_once 'DAO/delete-item-modelDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['modelID'] ?? '';

    if (!empty($id)) {
        $dao = new DeleteItemModelDAO();
        $result = $dao->deleteModelByID($id);

        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Model ID is missing.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
