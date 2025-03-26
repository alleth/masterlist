<?php
include "DAO/hardwares-view-specific-details-DAO.php";

$site_name = $_POST["site_name"];
$hw_type = $_POST["hw_type"];

$action = new viewSpecificDetailsDAO();
$action->viewSpecificDetails($site_name, $hw_type);
