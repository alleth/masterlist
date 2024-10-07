<?php
include "BaseDAO.php";
class viewSingleDataDAO extends BaseDAO{
    function viewSingleData($hw_id){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
        $stmt->bindParam(1,$hw_id);
        $stmt->execute();
        $this->closeConn();

        $text_style = "";
        $alert_message ="";

        while ($row = $stmt->fetch()){

            if($row[11] == "ON SITE"){
                $text_style = "text-success";
            }else{
                $text_style = "text-danger";
                $alert_message = "<div class='alert alert-danger d-flex align-items-center' role='alert'>
                                    <div>
                                    <i class='fas fa-exclamation-triangle'></i> Action required. This hardware need to return to SMC.
                                    </div>
                                  </div>";
            }

            echo $alert_message;
            echo "<h5>Primary Information</h5>";
            echo "<br>";
            echo "<div class='row'>";
            echo "<div class='col'>";
            echo "<dl class='row'>";
            echo "<dt class='col-sm-4'>Region:</dt>";
            echo "<dd class='col-sm-8'>$row[1]</dd>";
            echo "<dt class='col-sm-4'>Site Code: </dt>";
            echo "<dd class='col-sm-8'>$row[2]</dd>";
            echo "<dt class='col-sm-4'>Site Name:</dt>";
            echo "<dd class='col-sm-8'>$row[3]</dd>";
            echo "<dt class='col-sm-4'>Brand:</dt>";
            echo "<dd class='col-sm-8'>$row[4]</dd>";
            echo "<dt class='col-sm-4'>Model:</dt>";
            echo "<dd class='col-sm-8'>$row[5]</dd>";
            echo "</dl>";
            echo "</div>";
            echo "<div class='col'>";
            echo "<dl class='row'>";
            echo "<dt class='col-sm-4'>Asset No.:</dt>";
            echo "<dd class='col-lg-8'>$row[6]</dd>";
            echo "<dt class='col-sm-4'>Serial No.:</dt>";
            echo "<dd class='col-sm-8'>$row[7]</dd>";
            echo "<dt class='col-sm-4'>Date Acq.:</dt>";
            echo "<dd class='col-sm-8'>$row[8] / $row[9] / $row[10]</dd>";
            echo "<dt class='col-sm-4'>Status:</dt>";
            echo "<dd class='col-sm-8 $text_style'>$row[11]</dd>";
            echo "</dl>";
            echo "</div>";
            echo "</div>";
            echo "<hr>";
            echo "<h5>Other Information</h5>";
            echo "<br>";
            echo "<div class='row'>";
            echo "<div class='col'>";
            echo "<dl class='row'>";
            echo "<dt class='col-sm-4'>Hostname:</dt>";
            echo "<dd class='col-sm-8'>$row[12]</dd>";
            echo "<dt class='col-sm-4'>IP Address:</dt>";
            echo "<dd class='col-sm-8'>$row[13]</dd>";
            echo "<dt class='col-sm-4'>MAC Address:</dt>";
            echo "<dd class='col-sm-8'>$row[14]</dd>";
            echo "<dt class='col-sm-4'>User Name:</dt>";
            echo "<dd class='col-sm-8'>$row[15]</dd>";
            echo "<dt class='col-sm-4'>Primary Role:</dt>";
            echo "<dd class='col-sm-8'>$row[16]</dd>";
            echo "</dl>";
            echo "</div>";
            echo "<div class='col'>";
            echo "<dl class='row'>";
            echo "<dt class='col-sm-4'>Acquired Val.:</dt>";
            echo "<dd class='col-sm-8'>$row[17]</dd>";
            echo "<dt class='col-sm-4'>Updated By:</dt>";
            echo "</dl>";
            echo "</div>";
            echo "</div>";
        }
    }
}