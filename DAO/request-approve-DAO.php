<?php
    include "BaseDAO.php";

    class requestApproveDAO extends BaseDAO{
        function requestApprove($requestId, $update_stat)
        {
            $this->openConn();;
            $stmt = $this->dbh->prepare("SELECT * FROM tracking_tbl WHERE tracking_id = ?");
            $stmt->bindParam(1, $requestId);
            $stmt->execute();

            while ($row = $stmt->fetch()){
                $getInfo = $this->dbh->prepare("UPDATE hw_tbl SET hw_status = ?  WHERE hw_id = ?");
                $getInfo->bindParam(1, $update_stat);
                $getInfo->bindParam(2, $row[4]);
                $getInfo->execute();
                echo $row[4];
            }

            $chg_status = "Received";
            $response = "0";
            $this->openConn();
            $status = $this->dbh->prepare("UPDATE tracking_tbl SET pullout_status = ?, request_status = ? WHERE tracking_id = ?");
            $status->bindParam(1, $chg_status);
            $status->bindParam(2, $response);
            $status->bindParam(3, $requestId);
            $status->execute();

            $this->closeConn();
        }
    }