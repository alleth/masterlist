<?php
    include "DAO/directory-add-site-details-DAO.php";

    $region_name = $_POST["region_name"];
    $site_code = $_POST["site_code"];
    $site_name = $_POST["site_name"];
    $office_type = $_POST["office_type"];
    $site_address = $_POST["site_address"];
    $site_partnership = $_POST["site_partnership"];

    $action = new addSiteDetailsDAO();
    $action->addSiteDetails($region_name, $site_code, $site_name, $office_type, $site_address, $site_partnership);