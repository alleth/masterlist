<?php

include "DAO/hardware-brand-DAO2.php";

$item_name2 = $_POST["item_name2"];

$action = new hardwareBrand2DAO();
$action->hardwareBrand2($item_name2);
