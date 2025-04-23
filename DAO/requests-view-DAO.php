<?php
    include "BaseDAO.php";
    class requestsViewDAO extends BaseDAO{
        function requestView($user_id, $getCluster, $getUserType){

            $this->openConn();

            if($getUserType == "SPV"){
                $stmt = $this->dbh->prepare("SELECT * FROM tracking_tbl WHERE cluster_name = ? ORDER BY trxn_date DESC");
                $stmt->bindParam(1, $getCluster);
            }else if($getUserType == "FSE"){
                $stmt = $this->dbh->prepare("SELECT * FROM tracking_tbl WHERE user_id = ? ORDER BY trxn_date DESC");
                $stmt->bindParam(1, $user_id);
            }else{
                $stmt = $this->dbh->prepare("SELECT * FROM tracking_tbl ORDER BY trxn_date DESC");
            }

            $stmt->execute();

            $count = 1;
            while($row = $stmt->fetch()){

                echo "<tr id='$row[0]'>";
                echo "<td>".$count++."</td>";

                $sender_name = $this->dbh->prepare("SELECT * FROM user_tbl WHERE id = ?");
                $sender_name->bindParam(1, $row[5]);
                $sender_name->execute();

                $timestamp = $row[1];
                $date = new DateTime($timestamp);
                $now = new DateTime();

                $today = $now->format('Y-m-d');
                $yesterday = $now->modify('-1 day')->format('Y-m-d');
                $dateOnly = $date->format('Y-m-d');

                $oneYearAgo = (new DateTime())->modify('-1 year');

                if ($dateOnly === $today) {
                    $displayDate = $date->format('g:i A'); // Example: 11:05 AM
                } elseif ($dateOnly === $yesterday) {
                    $displayDate = "Yesterday at " . $date->format('g:i A');
                } elseif ($date < $oneYearAgo) {
                    $displayDate = $date->format('m/d/Y'); // Example: 04/08/2023
                } else {
                    $displayDate = $date->format('M j'); // Example: Mar 8
                }

                while ($name_row = $sender_name->fetch()){
                    $getSender_fname = $name_row[1];
                    $getSender_lname = $name_row[2];
                }
                if ($row[5] == $user_id && $row[10] == 1) {
                    $request_name = "You";
                    $displayApproveButton = "";
                    $displayDeleteButton = "<button title='Delete' class='btn btn-outline-danger btn-sm' onclick='deleteRequest(" . $row[0] . ")'><span class='fas fa-trash-alt'></span></button>";
                }else{
                    $request_name = $getSender_fname."&nbsp;".$getSender_lname;
                    $displayApproveButton = "<button title='Approve' class='btn btn-outline-success btn-sm'><strong><span class='fa fa-check'></span></strong></button>";
                    $displayDeleteButton = "";
                }

                if($row[8] == "Pull out"){
                    $displayDescription = "Hardware Pullout";
                }else{
                    $displayDescription = "Additional Hardware";
                }

                if($row[7] == "In-transit"){
                    $statusMessage = "<span class='badge bg-warning'>$row[7]</span>";
                }else if($row[7] == "Declined"){
                    $statusMessage = "<span class='badge bg-danger'>$row[7]</span>";
                }else{
                    $statusMessage = "<span class='badge bg-success'>$row[7]</span>";
                }

                echo "<td>$displayDate</td>";
                echo "<td>$request_name</td>";
                echo "<td>$displayDescription</td>";
                echo "<td class='status-cell' data-id='$row[0]'>$statusMessage</td>";

                echo "<td>$displayDeleteButton &nbsp;<button title='View Full Details' class='btn btn-outline-info btn-sm view-details-btn' data-id='{$row[0]}' data-status='{$row[10]}')'><span class='fas fa-list-ul'></span></button></td>";
                echo "</tr>";
            }
            $this->closeConn();
        }
    }