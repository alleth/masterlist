<?php

    include "DAO/view-data-cpu-pc-DAO.php";
    $hw_type = "Switch";
    $other_type = "Switch";
    $action = new viewDataDAO();
    $action->displayData($hw_type, $other_type);