<?php

    include "DAO/hardware-update-details-DAO.php";

    $hw_id = $_POST["hw_id"];

    $action = new updateDetailsDAO();
    $action->updateDetails($hw_id);