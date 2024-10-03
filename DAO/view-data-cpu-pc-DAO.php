<?php
include "BaseDAO.php";
class viewDataDAO extends BaseDAO {
    function displayData (){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl");
        $stmt->execute();
        $this->closeConn();

        $chk_age = "";
        while ($row = $stmt->fetch()){

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

            echo "<tr id='".$row[0]."'>";
            echo "<td>".$row[1]."</td>";
            echo "<td>".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td>".$row[4]."</td>";
            echo "<td>".$row[5]."</td>";
            echo "<td>".$row[6]."</td>";
            echo "<td>".$row[7]."</td>";
            echo "<td>".$chk_age."</td>";
            echo "<td>".$row[11]."</td>";
            echo "<td><a href='#'>Edit</a></td>";
            echo "</tr>";
        }
    }
}