<?php
include "BaseDAO.php";
class viewDataDAO extends BaseDAO {
    function displayData (){
        $status = "Onsite";
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_status = ?");
        $stmt->bindParam(1, $status);
        $stmt->execute();

        $chk_age = "";
        while ($row = $stmt->fetch()){

            if($row[10] == date("Y")){
                if($row[8] == date("m")){
                    if($row[9] == date("d")){
                        echo $chk_age = (date("d") - $row[10])." Days";
                    }
                }else{
                    $chk_age = (date("m") - $row[9])." Months";
                }
            }else{
                $chk_age = (date("Y") - $row[11])." Years";
            }
            echo "<tr onclick='viewHWDetails(".$row[0].")' style='cursor:pointer;'>";

            $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
            $region_name->bindParam(1, $row[1]);
            $region_name->execute();

            while ($region_row = $region_name->fetch()){
                $getRegion = $region_row[1];
            }

            echo "<td>".$getRegion."</td>";
            echo "<td>".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td>".$row[5]."</td>";
            echo "<td>".$row[6]."</td>";
            echo "<td>".$row[7]."</td>";
            echo "<td>".$row[8]."</td>";
            echo "<td>".$chk_age."</td>";
            echo "<td>".$row[12]."</td>";
            echo "</tr>";
        }

        $this->closeConn();
    }
}