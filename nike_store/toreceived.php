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

    if(isset($_POST['delete'])){
        $cartID = $_POST['cart_id'];
        $Date = date("Y-m-d");

        $sql_update = "UPDATE cart SET status = 'Order Received', date = '$Date' WHERE cart_id='$cartID'";
        
        if(mysqli_query($conn, $sql_update)){
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Thank you for the order!')
            window.location.href=window.location.href;
            </SCRIPT>");
        }else{
        }
    }


?>

<html>
   <head> 
        <name="viewport" content="width=device-width, initial-scale=1">
        <title>To Received</title>
        <link rel="stylesheet" type="text/css" href="css/style1.css" />
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
   </head>
   <body>
        <section class="header-section">
            <div class="top-header">
                <div id="cart-counter-container"><span id="cart-counter"><?php echo $cartCounter; ?></span></div>
                <i id="cart-logo" onclick="window.location='mycart.php'" class='bx bx-cart'></i>
                <?php if(empty($uid)){ ?>
                <span onclick="window.location='login.php'" id="login-register">Login/Register</span>
                <?php }else{ ?>
                <span onclick="window.location='logout.php'" id="login-register"><?php echo $row_userInformation['username']; ?></span>
                <?php } ?>
            </div>

            <div class="header">
                <div class="header-inner-div">
                    <div onclick="window.location='homepage.php'" class="header-inner-items">
                        <span>HOME</span>
                    </div>

                    <div onclick="window.location='product.php'" class="header-inner-items">
                        <span id="dropdown-menu-product">PRODUCTS</span>
                    </div>

                    <div onclick="window.location='homepage.php'" style="cursor: pointer; height: 180px; width: 190px; min-width: 190px; min-height: 180px;" class="header-inner-items">
                        <image id="header-logo" src="css/image/logo.png"></image>
                    </div>

                    <div onclick="window.location='contact_us.php'" class="header-inner-items">
                        <span>CONTACT US</span>
                    </div>

                    <div onclick="window.location='about_us.php'" class="header-inner-items">
                        <span>ABOUT US</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="homepage-section">
            <div class="cart-nav-bar">
                <div onclick="window.location='mycart.php'" class="cart-nav-bar-items">
                    <span>To Pay</span>
                </div>

                <div onclick="window.location='toship.php'" class="cart-nav-bar-items">
                    <span>To Ship</span>
                </div>

                <div onclick="window.location='toreceived.php'" class="cart-nav-bar-items">
                    <span style="border-bottom: 2px solid black;">To Received</span>
                </div>

                <div onclick="window.location='completed.php'" class="cart-nav-bar-items">
                    <span>Completed</span>
                </div>
            </div>

            <div class="cart-container">
                <?php
                    $sql_checkCart = "SELECT * FROM cart WHERE uid='$uid' AND status='Ongoing Shipment'";
                    $res_checkCart = mysqli_query($conn, $sql_checkCart);
                    
                    if(mysqli_num_rows($res_checkCart) > 0){
                        while($row = mysqli_fetch_array($res_checkCart)){

                            //PRODUCT INFORMATION
                            $productID = $row['product_id'];
                            $sql_productInformation = "SELECT * FROM product WHERE product_id='$productID'";
                            $res_productInformation = mysqli_query($conn, $sql_productInformation);
                            $row_productInformation = mysqli_fetch_array($res_productInformation);

                            $product_totalPrice = 0;
                            $product_price = $row_productInformation['price'];
                            $amount = $row['amount'];
                            $product_totalPrice = $product_price * $amount;

                            $product_totalPrice = number_format($product_totalPrice, 2);
                            
                            echo "<div class=\"cart-container-flex-box\">";
                                echo "<div class=\"cart-container-flex-box-left\">";
                                    echo "<div class=\"cart-container-flex-box-left-up\">";
                                        echo "<div class=\"cart-container-flex-box-left-img\">";
                                            echo "<img id='mycart-image' src='resource/product_pic/".$row_productInformation['picture']."'></img>";
                                        echo "</div>";

                                        echo "<div class=\"cart-container-flex-box-left-title\">";
                                            echo "<span id='mycart-product-title'>".$row_productInformation['product_name']."</span>";
                                            echo "<br><br>";
                                            echo "<span>Amount:</span>";
                                            echo "<br>";
                                            echo "<span>x ".$row['amount']."</span>";
                                        echo "</div>";
                                    echo "</div>";

                                    echo "<div class=\"cart-container-flex-box-left-down\">";
                                        echo "<span id='mycart-total-price'>Total Price: RM".$product_totalPrice."</span>";
                                        echo "<br>";
                                    echo "</div>";
                                echo "</div>";

                                echo "<div class=\"cart-container-flex-box-right\">";
                                    ?>
                                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                    <?php
                                    echo "<input type='submit' value='Received' id='mycart-btn' name='delete'></input>";
                                    //FOR INVI INPUT
                                    echo "<input type='hidden' name='product_id' value='".$row_productInformation['product_id']."'></input>";
                                    echo "<input type='hidden' name='cart_id' value='".$row['cart_id']."'></input>";
                                    echo "</form>";
                                    echo "<button style='margin-top: 0px;' id='mycart-btn' onclick=\"linkTrack('".$row['tracking_num']."')\">TRACK</button>";
                                    echo "<p>Shipment Date:</p>";
                                    echo "<p>".$row['date']."</p>";
                                echo "</div>";
                            echo "</div>";
                        }
                    }else{

                    }

                ?>
            </div>
        </section>

        <section class="footer">
            <div class="footer-flex-box">
                <div class="footer-flex-items">
                    <h2>Explore</h2>
                    <p>Homepage</p>
                    <p>Contact Us</p>
                    <p>About Us</p>
                    <p>My Cart</p>
                </div>

                <div class="footer-flex-items">
                    <h2>About Us</h2>
                    <p>Today, Nike is a Fortune 500 company with operations in more than 190 countries, employing over 75,000 people worldwide. The company's portfolio includes some of the most recognizable brands in the athletic industry, including Nike, Jordan, Converse, and Hurley.</p>
                </div>

                <div class="footer-flex-items">
                    <h2>Contact Us</h2>
                    <p>Email: admin@gmail.com</p>
                    <p>Phone: +60 19-602-3576</p>
                </div>
            </div>
        </section>
        <div class="copyright">
            <span><i class='bx bx-copyright icon'></i> Copyright 2023</spam>
        </div>

        <script>
            var myIndex = 0;
            carousel();

            function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";  
            }
            myIndex++;
            if (myIndex > x.length) {myIndex = 1}    
            x[myIndex-1].style.display = "block";  
            setTimeout(carousel, 2000); // Change image every 2 seconds
            }
        </script>

        <script src="//www.tracking.my/track-button.js"></script>
        <script>
            function linkTrack(num) {
                TrackButton.track({
                tracking_no: num
                });
            }
        </script>

   </body>
</html>