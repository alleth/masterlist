<?php
    include "DAO/hardwares-site-modal-DAO.php";

    $region_name = $_POST["region_name"];

    $action = new hardwareSelectSiteDAO();
    $action->hardwaresSelectSite($region_name);