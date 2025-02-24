<?php

    include "DAO/view-data-cpu-pc-DAO.php";
    $hw_type = "CPU-PC";
    $action = new viewDataDAO();
    $action->displayData($hw_type);