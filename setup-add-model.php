<?php
include("DAO/setup-add-modelDAO.php");

$itemSelect3 = $_POST['itemSelect3'];
$itemBrand2 = $_POST['itemBrand2'];
$item_model_add = $_POST['item_model_add'];

$action = new addItemModelDAO();
$action->addItemModel($itemSelect3, $itemBrand2, $item_model_add);