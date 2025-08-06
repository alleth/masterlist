<?php
require_once 'DAO/delete-item-brandDAO.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $dao = new ItemBrandDeleteDAO();
    $result = $dao->deleteItemBrand($id);

    echo $result ? "success" : "error";
} else {
    echo "invalid";
}
exit;
