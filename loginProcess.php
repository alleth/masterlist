<?php
session_start();

if (isset($_POST["user_name"]) && isset($_POST["user_pass"])) {
    include "DAO/loginDAO.php";

    $user_name = $_POST["user_name"];
    $user_password = $_POST["user_pass"];

    $action = new loginUserDAO();
    $userExist = $action->loginUser($user_name, $user_password);

    if ($userExist == 1) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Incorrect username or password.";
        header("Location: login.php?error=" . urlencode($error));
        exit;
    }
} else {
    $error = "Username and password are required.";
    header("Location: login.php?error=" . urlencode($error));
    exit;
}
