<?php
    include "BaseDAO.php";

    class requestsViewDAO extends BaseDAO{
        function requestView($user_id){
            $stmt = $this->dbh->prepare("SELECT * FROM request_tbl WHERE send_to = ?");
            $stmt->bindParam($user_id);
        }
    }