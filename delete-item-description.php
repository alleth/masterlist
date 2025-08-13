<?php
require_once 'DAO/delete-item-descriptionDAO.php';

if (isset($_POST['id'])) {
    $dao = new DeleteItemDescriptionDAO();
    $result = $dao->deleteItem($_POST['id']);
    echo $result ? "success" : "error";
} else {
    echo "invalid";
}
?>
