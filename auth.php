<?php
session_start();

if (!isset($_SESSION['sess_id'])) {
    header('Location: login.php?error=' . urlencode('You must log in to access this page.'));
    $user_type = $_SESSION['sess_user_type'];
    $user_region = $_SESSION['sess_assigned'];
    exit;
}
?>
