<?php
include "BaseDAO.php";
class viewSingleDataDAO extends BaseDAO{
    function viewSingleData($hw_id){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
        $stmt->bindParam(1,$hw_id);
        $stmt->execute();


        $alert_message ="";

        while ($row = $stmt->fetch()){

            if($row[12] == "On Site"){
                $text_style = "badge bg-success";
            }else{
                $text_style = "badge bg-danger";
                $alert_message = "<div class='alert alert-danger d-flex align-items-center' role='alert'>
                                    <div>
                                    <i class='fas fa-exclamation-triangle'></i> Action required. This hardware is for return to SMC.
                                    </div>
                                  </div>";
            }

            $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
            $region_name->bindParam(1, $row[1]);
            $region_name->execute();

            // Initialize with a default value
            $region_string = "Unknown region";

            if ($region_row = $region_name->fetch()) {
                $region_string = $region_row[1]; // Assign the actual region name if found
            }


            echo $alert_message;
            echo "<h5>Primary Information</h5>";
            echo "<div class='row'>";
            echo    "<div class='col'>";
            echo        "<dl class='row'>";
            echo            "<input class='input-group' type='hidden' name='dataValue' value='$row[0]' disabled>";
            echo            "<dt class='col-sm-4'>Region:</dt>";
            echo            "<dd class='col-sm-8'>$region_string</dd>";
            echo            "<dt class='col-sm-4'>Site Code: </dt>";
            echo            "<dd class='col-sm-8'>$row[2]</dd>";

                                $site_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
                                $site_name->bindParam(1, $row[2]);
                                $site_name->execute();

                                // Initialize the variable with a default value
                                $get_siteName = "Unknown site";

                                if ($site_row = $site_name->fetch()) {
                                    $get_siteName = $site_row[2]; // Assign the actual site name if found
                                }


            echo            "<dt class='col-sm-4'>Site Name:</dt>";
            echo            "<dd class='col-sm-8'>$get_siteName</dd>";
            echo            "<dt class='col-sm-4'>Brand:</dt>";
            echo            "<dd class='col-sm-8'>$row[6]</dd>";
            echo            "<dt class='col-sm-4'>Model:</dt>";
            echo            "<dd class='col-sm-8'>$row[7]</dd>";


            $acquired_value = (!empty($row[11]) && strtolower($row[11]) !== "None") ? $row[11] : "0.00";

            echo "<dt class='col-sm-4'>Acquired Value:</dt>";
            echo "<dd class='col-sm-8'>$acquired_value</dd>";

            echo         "</dl>";
            echo    "</div>";
            echo    "<div class='col'>";
            echo        "<dl class='row'>";
            echo            "<dt class='col-sm-4'>Asset No.:</dt>";
            echo            "<dd class='col-lg-8'>$row[8]</dd>";
            echo            "<dt class='col-sm-4'>Serial No.:</dt>";
            echo            "<dd class='col-sm-8'>$row[9]</dd>";
            echo            "<dt class='col-sm-4'>Date Acq.:</dt>";
            echo            "<dd class='col-sm-8'>$row[10]</dd>";
            echo            "<dt class='col-sm-4'>Status:</dt>";
            echo            "<dd class='col-sm-8'><span class='$text_style'>$row[12]</span></dd>";
            echo            "</dl>";
            echo    "</div>";
            echo "</div>";
            echo "<hr>";
            echo "<h5>Other Information</h5>";
            echo "<div class='row'>";
            echo    "<div class='col'>";
            echo        "<dl class='row'>";
            echo            "<dt class='col-sm-4'>Hostname:</dt>";
            echo            "<dd class='col-sm-8'>$row[13]</dd>";
            echo            "<dt class='col-sm-4'>IP Address:</dt>";
            echo            "<dd class='col-sm-8'>$row[14]</dd>";
            echo            "<dt class='col-sm-4'>MAC Address:</dt>";
            echo            "<dd class='col-sm-8'>$row[15]</dd>";
            echo            "<dt class='col-sm-4'>Primary Role:</dt>";
            echo            "<dd class='col-sm-8'>$row[16]</dd>";
            echo        "</dl>";
            echo    "</div>";
            echo    "<div class='col'>";

            echo    "</div>";
            echo "</div>";

            $author = $this->dbh->prepare("SELECT * FROM user_tbl WHERE id = ?");
            $author->bindParam(1, $row[18]);
            $author->execute();

            while($getAuthor = $author->fetch()){
                $fname = $getAuthor[1];
                $lname = $getAuthor[2];
            }

            echo "<div class='text-muted'>Updated by <i title='Source Title'>&nbsp; $fname&nbsp;$lname</i></div>";

            $this->closeConn();
        }
    }
}