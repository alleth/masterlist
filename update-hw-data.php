<?php
include "DAO/update-hw-data-DAO.php";
$hwValue = $_POST["hwValue"];
$action = new updateHWDataDAO();
$action->updateHWData($hwValue);