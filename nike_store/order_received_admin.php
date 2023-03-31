<?php
    //START A SESSION
   session_start();

   include('server.php');

   $uid = "";
   $cartCounter = 0;

   //CHECK IF THE USER IS LOGGED IN
    if(isset($_SESSION["login"]) && $_SESSION["login"] === true){
        $uid = $_SESSION['uid'];

        //GET USER INFORMATION
        $sql_userInformation = "SELECT * FROM user WHERE uid='$uid'";
        $res_userInformation = mysqli_query($conn, $sql_userInformation);
        $row_userInformation = mysqli_fetch_array($res_userInformation);

        //CART COUNTER
        $sql_cartCounter = "SELECT * FROM cart WHERE uid='$uid' AND status='unpaid'";
        $res_cartCounter = mysqli_query($conn, $sql_cartCounter);

        if(mysqli_num_rows($res_cartCounter) > 0){
            while($row_cartCounter = mysqli_fetch_array($res_cartCounter)){
                $cartCounter = $cartCounter + 1;
            }
        }
    }

    $cartID = $_REQUEST['cartID'];
    $Date = date("Y-m-d");

    $sql_update = "UPDATE cart SET status = 'Order Received', date = '$Date' WHERE cart_id='$cartID'";
    
    if(mysqli_query($conn, $sql_update)){
        header("location: shipment_ongoing.php?status=Product Successfully Sent!");
    }else{
        header("location: shipment_ongoing.php?status=Ops! Something wrong!");
        echo $categoryID;
    }

    mysqli_close($conn);

?>