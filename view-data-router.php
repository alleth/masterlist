<?php

    include "DAO/view-data-cpu-pc-DAO.php";
    $hw_type = "Network Equipment - Router ";
    $action = new viewDataDAO();
    $action->displayData($hw_type);