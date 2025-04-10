<?php
     include "DAO/requests-view-DAO.php";
     include "auth.php";
     $user_id = $_SESSION['sess_id'];
     $getCluster = $_SESSION['sess_cluster'];

     $action = new requestsViewDAO();
     $action->requestView($user_id, $getCluster);