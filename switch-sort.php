<?php

    include "DAO/cpu-pc-sort-DAO.php";
    include "auth.php";
    $selectedValue = $_POST["selectedValue"];
    $user_type = $_SESSION['sess_user_type'];
    $hw_type = "Network Equipment";
    $action = new sortCpuDAO();
    $action->sortCpuView($selectedValue, $user_type, $hw_type);