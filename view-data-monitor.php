<?php

    include "DAO/view-data-cpu-pc-DAO.php";
    $hw_type = "Monitor";
    $action = new viewDataDAO();
    $action->displayData($hw_type);