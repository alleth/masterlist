<?php
    include "DAO/hardwares-site-modal-DAO.php";

    $site_name = $_POST["site_name"];

    $action = new hardwareSelectSiteDAO();
    $action->hardwaresSelectSite($site_name);