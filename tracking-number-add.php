<?php

    include "DAO/tracking-number-add-DAO.php";
    include "auth.php";
    $tracking_num = $_POST["tracking_num"];
    $hw_id_pullout = $_POST["hw_id_pullout"];
    $datePullout = $_POST["datePullout"];
    $user_id = $_SESSION["sess_id"];

    $action = new trackingNumAddDAO();
    $action->trackingNumAdd($tracking_num, $hw_id_pullout, $datePullout, $user_id);