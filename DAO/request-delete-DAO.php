<?php
    include "BaseDAO.php";

    class deleteRequestDAO extends BaseDAO{
        function deleteRequest($delete_id){
            $this->openConn();

            $stmt = $this->dbh->prepare("DELETE FROM tracking_tbl WHERE tracking_id = ?");
            $stmt->bindParam(1, $delete_id);
            $stmt->execute();

            $this->closeConn();
        }
    }