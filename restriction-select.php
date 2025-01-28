<?php

include "DAO/restriction-select-DAO.php";
include "auth.php";

$user_type = $_SESSION["sess_user_type"];
$region_assigned = $_SESSION["sess_assigned"];

$action = new restrictSelectDAO();
$action->restrictSelect($user_type, $region_assigned);