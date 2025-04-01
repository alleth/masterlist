<?php

include "DAO/hardware-brand-DAO.php";

$item_name = $_POST["item_name"];

$action = new hardwareBrandDAO();
$action->hardwareBrand($item_name);
