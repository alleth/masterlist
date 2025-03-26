<?php

    include "DAO/hardwares-view-details-DAO.php";

    $site_name = $_POST["site_name"];

    $action = new viewHardwareDetailsDAO();
    $action->viewHardwareDetails($site_name);
