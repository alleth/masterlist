<?php

include "DAO/directory-site-DAO.php";

$region_id = $_POST["region_directory"];

$action = new viewSiteDirectoryDAO();
$action->viewSiteDirectory($region_id);