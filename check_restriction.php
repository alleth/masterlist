<?php
include "auth.php";
// Use isset() instead of null coalescing (??) for PHP 5.x
$user_type = isset($_SESSION['sess_user_type']) ? $_SESSION['sess_user_type'] : '';

if ($user_type == "ADM" || $user_type == "SPV") {
    $user_id = isset($_SESSION['sess_id']) ? $_SESSION['sess_id'] : '';
} else {
    // Redirect to unauthorized page
    header("Location: unauthorized.php");
    exit;
}
?>