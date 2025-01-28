<?php

include "DAO/user-enroll-DAO.php";
include "auth.php";
$f_name = $_POST["f_name"];
$l_name = $_POST["l_name"];
$region_name = $_POST["assignmentName"];
$clusterName = $_POST["clusterName"];
$user_type = $_POST["user_type"];
$user_name = $_POST["user_name"];

$user_id = $_SESSION["sess_id"];

$action = new addUserDAO();
$action->addUserData($f_name, $l_name, $region_name, $clusterName, $user_type, $user_name, $user_id);