<?php
include "DAO/hardwares-view-specific-details-DAO.php";

$region_name = $_POST["region_name"] ?? null;
$site_name = $_POST["site_name"] ?? null;
$hw_type = $_POST["hw_type"] ?? null;

$action = new viewSpecificDetailsDAO();
$action->viewSpecificDetails($site_name, $hw_type, $region_name);