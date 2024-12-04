<?php  
    /*
    function countServers()
        {
        try{
            require_once("BaseDAO.php");
            $SQL = 'SELECT * FROM srvr_tbl';
            $result = $dbh->query($SQL);
            $num_row = $result->rowCount();
            }
            catch(Exception $e){
                $error = $e->getMessage();
            }
            echo '<h3 class="font-weight-bolder mb-0">1234</h3>';
        }*/
    function countCPU()
        {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "hw_db";

            $con = mysqli_connect($servername, $username, $password, $database);
            
            
            $count_query = "SELECT * FROM hw_tbl";
            $count_result = mysqli_query($con, $count_query);

                            if($count_total = mysqli_num_rows($count_result))
                            {
                                echo '<h3 class="font-weight-bolder mb-0">'.$count_total.'</h3>';
                            }else{
                                echo '<h3 class="font-weight-bolder mb-0">0</h3>';
                            }
        }
?>