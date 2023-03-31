<?php
    //START A SESSION
    session_start();

    include('server.php');

    $username = $permission = $staffID = $profilePicture = $status = $submitErr = $submitOut = "";

    $uid = "";

    //CHECK IF THE USER IS LOGGED IN
    if($_SESSION["login"] !== true){
        header("location: login.php");
        exit;
    }else{
        $uid = $_SESSION["uid"];

        //GET USER INFORMATION
        $sql_userInformation = "SELECT * FROM user WHERE uid='$uid'";
        $res_userInformation = mysqli_query($conn, $sql_userInformation);
        $row_userInformation = mysqli_fetch_array($res_userInformation);

        $username = $row_userInformation['username'];
    }

    $categoryID = $_REQUEST['categoryID'];

    $sql_delete = "DELETE FROM categories WHERE categories_id='$categoryID'";
    
    if(mysqli_query($conn, $sql_delete)){
        header("location: category_information.php?status=Category Successfully Deleted!");
    }else{
        header("location: category_information.php?status=Ops! Something wrong!");
        echo $categoryID;
    }

    mysqli_close($conn);

?>