<?php
    require_once "auth.php";
    include "DAO/request-decline-DAO.php";

    $requestId = $_POST["requestId"];
    $remarksMess = $_POST["remarks"];
    $user_id = $_SESSION['sess_id'];

    $action = new declineRequestDAO();
    $action->declineRequest($requestId, $remarksMess, $user_id);