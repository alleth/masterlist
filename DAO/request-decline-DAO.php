<?php
    include "BaseDAO.php";
    class declineRequestDAO extends BaseDAO
    {
        function declineRequest($requestId, $remarksMess, $user_id)
        {
            $declineMessage = "Declined";
            $response = "0";
            $this->openConn();
            $stmt = $this->dbh->prepare("UPDATE tracking_tbl SET pullout_status = ?, request_status = ? WHERE tracking_id = ?");
            $stmt->bindParam(1, $declineMessage);
            $stmt->bindParam(2, $response);
            $stmt->bindParam(3, $requestId);
            $stmt->execute();

            $remarks = $this->dbh->prepare("INSERT INTO remarks_tbl (tracking_id, message, user_id) VALUES (? ,? ,?)");
            $remarks->bindParam(1,$requestId);
            $remarks->bindParam(2,$remarksMess);
            $remarks->bindParam(3,$user_id);
            $remarks->execute();

            echo $declineMessage;

            $this->closeConn();
        }
    }