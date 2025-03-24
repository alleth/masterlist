<?php
include "DAO/directory-specific-officeType-DAO.php";

$region_name = $_POST["region_name"];
$officeType = $_POST["officeType"];

$action = new viewDirectorySpecificOfficeTypeDAO();
$action->viewDirectorySpecificOfficeType($region_name, $officeType);