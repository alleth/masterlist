<?php
include "DAO/hardwares-view-details-DAO.php";

$region_name = $_POST["region_name"] ?? null;
$site_name = $_POST["site_name"] ?? null;
$hw_type = $_POST["hw_type"] ?? null;

$action = new viewHardwareDetailsDAO();
$action->viewHardwareDetails($site_name, $region_name, $hw_type);