<?php
include("DAO/setup-add-descriptionDAO.php");
     
$item_desc_add = $_POST['item_desc_add'];

$action = new addItemDescDAO();
$action->addItemDesc($item_desc_add);