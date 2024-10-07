<?php

    include "DAO/view-single-data-cpu-pc-DAO.php";
    $hw_id = $_POST["hw_id"];
    $action = new viewSingleDataDAO();
    $action->viewSingleData($hw_id);