<?php
include "BaseDAO.php";
class viewUserDAO extends BaseDAO {
    function displayUserData (){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM user_tbl");
        $stmt->execute();

        $assignedRegion ="";
        while ($row = $stmt->fetch()){
            echo "<tr id='row-$row[0]'><td>".$row[1]."</td>";
            echo "<td>".$row[2]."</td>";

            if($row[3] == "All") {
                $assignedRegion = "All";

            }else if($row[3] == "VisMin" || $row[3] == "Luzon" || $row[3] == "NCR"){
                $assignedRegion = $row[3];
            }else{
                $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
                $region_name->bindParam(1, $row[3]);
                $region_name->execute();

                while ($getRegion = $region_name->fetch()){
                    $assignedRegion = $getRegion[1];
                }
            }

            echo "<td>".$row[5]."</td>";
            echo "<td>".$assignedRegion."</td>";
            echo "<td>".$row[4]."</td>";
            echo "<td>".$row[6]."</td>";
            echo "<td><a type='button' class='btn btn-warning btn-sm'>View Password <i class='fas fa-eye'></i></a></td>";
            echo "<td><a type='button' href='#' data-bs-toggle='tooltip' data-bs-placement='top' title='Edit' class='btn btn-link text-info' onclick='editUser($row[0])'><i class='far fa-edit'></i></a></td>";
            echo "<td><a type='button' href='#' data-bs-toggle='tooltip' data-bs-placement='top' title='Delete' class='btn btn-link text-danger' onclick='deleteUser($row[0])'><i class='far fa-trash-alt'></i></a></td></tr>";
        }

        $this->closeConn();
    }
}