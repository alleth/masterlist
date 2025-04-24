<?php
include("DAO/setup-add-brandDAO.php");

$itemSelect2 = $_POST['itemSelect2'];
$item_brand_add = $_POST['item_brand_add'];

$action = new addItemBrandDAO();
$action->addItemBrand($itemSelect2, $item_brand_add);