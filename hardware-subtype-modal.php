<?php
include "DAO/hardware-subtype-modal-DAO.php";

if (!isset($_POST['item_desc'])) {
    echo json_encode(["error" => "Missing item_desc"]);
    exit;
}

$item_desc = $_POST['item_desc'];

$dao = new SubTypeDAO();
$result = $dao->getSubTypeByItemDesc($item_desc);
echo json_encode($result);
