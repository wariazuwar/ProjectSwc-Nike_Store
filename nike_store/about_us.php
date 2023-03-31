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


?>

<html>
   <head> 
        <name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome!</title>
        <link rel="stylesheet" type="text/css" href="css/style1.css" />
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
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
            <br><br><br>
            <div class="container">
                <div style="width: 60%; height: 300px; overflow: hidden; margin: auto; border-radius: 10px; border: 2px solid black;">
                    <image style="height: 100%; width: 100%;" src="resource/Alamy_2F3Y8J0-crop-ff47efc.jpg"></image>
                </div>
                <div style="width: 70%; margin: auto; font-size: 20px;">
                    <p>
                    Nike is a globally recognized American multinational corporation that specializes in the design, development, marketing, and sale of athletic footwear, apparel, equipment, and accessories. Founded in 1964 by Bill Bowerman and Phil Knight, Nike has become one of the world's most valuable and influential brands, with a mission to bring inspiration and innovation to every athlete in the world.
                    </p>
                    <p>
                    Over the years, Nike has established itself as a leader in the athletic industry, providing innovative products that cater to the needs of athletes from all backgrounds and sports. With a focus on continuous innovation and product improvement, Nike has introduced many game-changing products and technologies, such as the Air Max cushioning system, Flywire technology, and the Nike+ running platform.
                    </p>
                </div>
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

   </body>
</html>