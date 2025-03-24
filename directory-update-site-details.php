<?php

include "DAO/directory-update-site-details-DAO.php";
$site_id = $_POST["site_id"];
$action = new updateSiteDetailsDAO();
$action->updateSiteDetails($site_id);