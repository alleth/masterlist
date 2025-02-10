<?php
include "DAO/brand-modal-edit-option-DAO.php";
$hw_type = "Printer";
$action = new brandModalEditDAO();
$action->brandModalEdit($hw_type);