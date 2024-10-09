<?php
include "DAO/view-site-code-DAO.php";

$site_id = $_POST["site_id"];
$action = new viewSiteCodeDAO();
$action->viewSiteCode($site_id);