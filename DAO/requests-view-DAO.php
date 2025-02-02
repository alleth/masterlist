<?php
    include "BaseDAO.php";
    class requestsViewDAO extends BaseDAO{
        function requestView($user_id){
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM request_tbl WHERE send_to = ?");
            $stmt->bindParam(1, $user_id);
            $stmt->execute();

            $count = 1;
            while($row = $stmt->fetch()){

                echo "<tr>";
                echo "<td>".$count++."</td>";

                $sender_name = $this->dbh->prepare("SELECT * FROM user_tbl WHERE id = ?");
                $sender_name->bindParam(1, $row[1]);
                $sender_name->execute();

                while ($name_row = $sender_name->fetch()){
                    $getSender_fname = $name_row[1];
                    $getSender_lname = $name_row[2];
                }

                echo "<td>$getSender_fname ".$getSender_lname."</td>";
                echo "<td>$row[2]</td>";
                echo "<td>$row[3]</td>";

                if($row[5] == "Pending"){

                }


                echo "<td><span class='badge bg-warning'>$row[5]</span></td>";
                echo "<td><button class='btn btn-outline-danger btn-sm'>Reject</button> &nbsp; <button class='btn btn-outline-primary btn-sm'>Approve</button></td>";
                echo "</tr>";
            }
            $this->closeConn();

        }
    }