<?php
include "DAO/user-delete-confirmation-DAO.php";
include "auth.php";
$user_id = $_POST["user_id"];

$sess_id = $_SESSION["sess_id"];

$action = new deleteUserDAO();
$action->deleteUser($user_id, $sess_id);