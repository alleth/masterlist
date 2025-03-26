<?php
    include "DAO/hardwares-view-site-DAO.php";

    $region_name = $_POST["region_name"];

    $action = new hardwaresViewSiteDAO();
    $action->hardwaresViewSite($region_name);