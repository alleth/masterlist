<?php
include "DAO/view-hw-brand-option-DAO.php";
$hw_type = "Monitor";
$action = new viewBrandOptionDAO();
$action->viewBrandOption($hw_type);