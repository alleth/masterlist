<?php
include "BaseDAO.php";
class activityLogDAO extends BaseDAO {
    function activityLog($user_id){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM log_tbl WHERE log_user = ? ORDER BY log_date DESC");
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        $count = 1;
        // Check if there are any rows returned
        if ($stmt->rowCount() > 0) {
            while($row = $stmt->fetch()){
                echo "<tr>";
                echo "<td>".$count++."</td>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";

                $display_name = $this->dbh->prepare("SELECT * FROM user_tbl WHERE id = ?");
                $display_name->bindParam(1, $row[3]);
                $display_name->execute();

                while ($user_row = $display_name->fetch()){
                    $fname = $user_row[1];
                    $lname = $user_row[2];
                }

                echo "<td>". $fname ."&nbsp;". $lname. "</td>";

                $status = $row[4];

                if($status == "Completed"){
                    echo "<td><span class='badge bg-success'>$status</span></td>";
                }else if($status == "Pending"){
                    echo "<td><span class='badge bg-warning'>$status</span></td>";
                }else{
                    echo "<td><span class='badge bg-danger'>$status</span></td>";
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center text-muted'><i>You do not have any activity yet.</i></td></tr>";
        }
        $this->closeConn();
    }
}


