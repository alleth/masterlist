<?php
session_start();

if (!isset($_SESSION['sess_id'])) {
    header('Location: login.php');
    $user_type = $_SESSION['sess_user_type'];
    $user_region = $_SESSION['sess_assigned'];
    exit;
}
?>
