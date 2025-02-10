<?php
include "DAO/view-hw-brand-option-DAO.php";
$hw_type = "Switch";
$action = new viewBrandOptionDAO();
$action->viewBrandOption($hw_type);