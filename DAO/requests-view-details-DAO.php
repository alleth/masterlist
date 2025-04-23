<?php
    include "BaseDAO.php";
    class requestViewDetailsDAO extends BaseDAO{
        function requestViewDetails($request_id){
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM tracking_tbl WHERE tracking_id = ?");
            $stmt->bindParam(1, $request_id);
            $stmt->execute();

            while ($row = $stmt->fetch()){

                $getUser = $this->dbh->prepare("SELECT * FROM user_tbl WHERE id = ?");
                $getUser->bindParam(1, $row[5]);
                $getUser->execute();

                while ($userRow = $getUser->fetch()){
                    $user = $userRow[1]." ".$userRow[2];
                }

                $getHardware = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
                $getHardware->bindParam(1, $row[4]);
                $getHardware->execute();

                while ($hardwareRow = $getHardware->fetch()){
                    $region_id = $hardwareRow[1];
                    $hw_type = $hardwareRow[4];
                    $hw_desc = $hardwareRow[5];
                    $hw_brand = $hardwareRow[6];
                    $hw_model = $hardwareRow[7];
                    $hw_asset = $hardwareRow[8];
                    $hw_serial = $hardwareRow[9];
                    $hw_status = $hardwareRow[12];
                }

                $getRegion = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
                $getRegion->bindParam(1, $region_id);
                $getRegion->execute();

                while ($region_row = $getRegion->fetch()){
                    $region_name = $region_row[1];
                }

                $getSite = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
                $getSite->bindParam(1, $row[3]);
                $getSite->execute();

                while ($siteRow = $getSite->fetch()){
                    $site_name = $siteRow[1]." - ".$siteRow[2];
                }

                if($row[7] == "In-transit"){
                    $statusMessage = "<span class='badge bg-warning'>$row[7]</span>";
                }else if($row[7] == "Declined"){
                    $statusMessage = "<span class='badge bg-danger'>$row[7]</span>";
                }else{
                    $statusMessage = "<span class='badge bg-success'>$row[7]</span>";
                }

                $getremarks = $this->dbh->prepare("SELECT * FROM remarks_tbl WHERE tracking_id = ?");
                $getremarks->bindParam(1, $request_id);
                $getremarks->execute();
                while ($remarksRow = $getremarks->fetch()){
                    $remarks = $remarksRow[2];
                }

                echo "<tr><th>Date Requested:</th><td>$row[1]</td></tr>";
                echo "<tr><th>Request for:</th><td>$row[8]</td></tr>";
                echo "<tr><th>Tracking No.:</th><td>$row[2]</td></tr>";
                echo "<tr><th>Requested By:</th><td>$user</td></tr>";
                echo "<tr><th>Date pulled out:</th><td>$row[6]</td></tr>";
                echo "<tr><th colspan='2' style='text-align: center;'>Hardware details</td></tr>";
                echo "<tr><th>Region:</th><td>$region_name</td></tr>";
                echo "<tr><th>Site Name:</th><td>$site_name</td></tr>";
                echo "<tr><th>Hardware Type:</th><td>$hw_type</td></tr>";
                echo "<tr><th>Hardware Description:</th><td>$hw_desc</td></tr>";
                echo "<tr><th>Brand:</th><td>$hw_brand</td></tr>";
                echo "<tr><th>Model:</th><td>$hw_model</td></tr>";
                echo "<tr><th>Asset Number:</th><td>$hw_asset</td></tr>";
                echo "<tr><th>Serial Number:</th><td>$hw_serial</td></tr>";
                echo "<tr><th>Status:</th><td> $statusMessage</td></tr>";
                if ($remarks == ""){
                    echo "";
                }else{
                    echo "<tr><th>Reason of declining:</th><td> $remarks</td></tr>";
                }
            }
            $this->closeConn();
        }
    }