<?php
include "DAO/view-hw-brand-option-DAO.php";
$hw_type = "CPU-PC";
$action = new viewBrandOptionDAO();
$action->viewBrandOption($hw_type);