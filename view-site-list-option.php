<?php
include "DAO/view-site-list-DAO.php";

$region_id = $_POST["region_id"];
$action = new viewSiteListDAO();
$action->viewSiteList($region_id);