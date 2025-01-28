<?php

    include "DAO/tracking-number-add-DAO.php";
    include "auth.php";
    $tracking_num = $_POST["tracking_num"];
    $hw_id_pullout = $_POST["hw_id_pullout"];
    $user_id = $_SESSION["sess_id"];
    $cluster_name = $_SESSION["sess_cluster"];

    $action = new trackingNumAddDAO();
    $action->trackingNumAdd($tracking_num, $hw_id_pullout, $user_id, $cluster_name);