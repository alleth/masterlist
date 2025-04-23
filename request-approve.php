<?php
    include "DAO/request-approve-DAO.php";

    $requestId = $_POST["requestId"];
    $update_stat = "Pull out";

    $action = new requestApproveDAO();
    $action->requestApprove($requestId, $update_stat);