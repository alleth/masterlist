<?php
     include "DAO/requests-view-DAO.php";
     include "auth.php";
     $user_id = $_SESSION['sess_id'];
     $getCluster = $_SESSION['sess_cluster'];
     $getUserType = $_SESSION['sess_user_type'];

     $action = new requestsViewDAO();
     $action->requestView($user_id, $getCluster, $getUserType);