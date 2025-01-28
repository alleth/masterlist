<?php
include "DAO/activity-log-view-DAO.php";
include "auth.php";
$user_id = $_SESSION["sess_id"];
$action = new activityLogDAO();
$action->activityLog($user_id);