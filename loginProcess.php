<?php
    session_start();
    if(isset ($_POST["user_name"]) && $_POST["user_pass"]){
        include "DAO/loginDAO.php";
        $user_name = $_POST["user_name"];
        $user_password = $_POST["user_pass"];
        $action = new loginUserDAO();
        $userExist = $action->loginUser($user_name, $user_password);
        if($userExist==1){
            $user_id = $_SESSION["sess_id"];
            header("location: index.php");
        }else{
            echo "Username or password is incorrect";
        }
    }else{
        echo "Empty Set";
    }