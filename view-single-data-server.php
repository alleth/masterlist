<?php

    include "DAO/view-single-data-server-DAO.php";
    $hw_id = $_POST["id"];
    $action = new viewSingleDataDAO();
    $action->viewSingleData($hw_id);