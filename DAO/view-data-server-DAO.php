<?php
include "BaseDAO.php";
class viewDataDAO extends BaseDAO {
    function displayData (){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM `inventory` WHERE col_7 Like '%CPU-Server%'");
        $stmt->execute();
        $this->closeConn();

        $chk_age = "";
        while ($row = $stmt->fetch()){
            /*
            if($row[10] == date("Y")){
                if($row[8] == date("m")){
                    if($row[9] == date("d")){
                        echo $chk_age = (date("d") - $row[9])." Days";
                    }
                }else{
                    $chk_age = (date("m") - $row[8])." Months";
                }
            }else{
                $chk_age = (date("Y") - $row[10])." Years";
            }
        */
            echo "<tr onclick='viewHWDetails(".$row[0].")' style='cursor:pointer;'>";
            echo "<td>".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td>".$row[4]."</td>";
            echo "<td>".$row[8]."</td>";
            echo "<td>".$row[9]."</td>";
            echo "<td>".$row[11]."</td>";//PE
            echo "<td>".$row[10]."</td>";//serial
            echo "<td>".$row[12]."</td>";//echo "<td>".$chk_age."</td>";
            echo "<td>".$row[14]."</td>";
            echo "</tr>";
        }
    }
}