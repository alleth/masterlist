<?php
 include "DAO/requests-view-DAO.php";
 include "auth.php";

 $user_id = $_SESSION['sess_id'];

 $action = new requestsViewDAO();
 $action->requestView($user_id);