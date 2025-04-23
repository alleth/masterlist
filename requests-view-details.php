<?php
    include "DAO/requests-view-details-DAO.php";

    $request_id = $_POST["requestId"];

    $action = new requestViewDetailsDAO();
    $action->requestViewDetails($request_id);