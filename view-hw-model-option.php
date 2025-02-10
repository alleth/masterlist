<?php
include "DAO/view-hw-model-option-DAO.php";
$brand_name = $_POST["brand_name"];
$action = new viewModelOptionDAO();
$action->viewModelOption($brand_name);