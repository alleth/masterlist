<?php
    include "DAO/request-delete-DAO.php";

    $delete_id = $_POST["requestDeleteId"];

    $action = new deleteRequestDAO();
    $action->deleteRequest($delete_id);