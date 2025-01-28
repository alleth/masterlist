<?php
include "BaseDAO.php";
class sortCpuDAO extends BaseDAO{
    function sortCpuView($selectedValue, $user_type){
        $status = "Onsite";
        if ($user_type == "ADM" || $user_type == "SPV"){
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE region_name = ? AND hw_status = ?");
            $stmt->bindParam(1, $selectedValue);
            $stmt->bindParam(2, $status);
            $stmt->execute();
            $this->closeConn();

            $chk_age = "";
            while ($row = $stmt->fetch()) {

                if ($row[11] == date("Y")) {
                    if ($row[9] == date("m")) {
                        if ($row[10] == date("d")) {
                            echo $chk_age = (date("d") - $row[10]) . " Days";
                        }
                    } else {
                        $chk_age = (date("m") - $row[9]) . " Months";
                    }
                } else {
                    $chk_age = (date("Y") - $row[11]) . " Years";
                }
                echo "<tr onclick='viewHWDetails(" . $row[0] . ")' style='cursor:pointer;'>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[5] . "</td>";
                echo "<td>" . $row[6] . "</td>";
                echo "<td>" . $row[7] . "</td>";
                echo "<td>" . $row[8] . "</td>";
                echo "<td>" . $chk_age . "</td>";
                echo "<td>" . $row[12] . "</td>";
                echo "</tr>";
            }
        }else{
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE site_code = ? AND hw_status = ?");
            $stmt->bindParam(1, $selectedValue);
            $stmt->bindParam(2, $status);
            $stmt->execute();
            $this->closeConn();

            $chk_age = "";
            while ($row = $stmt->fetch()) {

                if ($row[11] == date("Y")) {
                    if ($row[9] == date("m")) {
                        if ($row[10] == date("d")) {
                            echo $chk_age = (date("d") - $row[10]) . " Days";
                        }
                    } else {
                        $chk_age = (date("m") - $row[9]) . " Months";
                    }
                } else {
                    $chk_age = (date("Y") - $row[11]) . " Years";
                }
                echo "<tr onclick='viewHWDetails(" . $row[0] . ")' style='cursor:pointer;'>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[5] . "</td>";
                echo "<td>" . $row[6] . "</td>";
                echo "<td>" . $row[7] . "</td>";
                echo "<td>" . $row[8] . "</td>";
                echo "<td>" . $chk_age . "</td>";
                echo "<td>" . $row[12] . "</td>";
                echo "</tr>";
            }
        }

    }
}