<?php
    include "DAO/server-update-details-DAO.php";

    $server_id = $_POST["id"];

    $action = new serverUpdateDetailsDAO();
    $action->serverUpdateDetails($server_id);