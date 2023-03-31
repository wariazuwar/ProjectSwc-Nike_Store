<?php
    //START A SESSION
    session_start();

    include('server.php');

    $username = $password = $conformPassword = $email = "";
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

    
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $conformPassword = $_POST['conform_password'];

        $username = addslashes($username);
        $email = addslashes($email);
        $password = addslashes($password);
        $conformPassword = addslashes($conformPassword);

        if($password == $conformPassword){
            $sql_insert = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";

            if(mysqli_query($conn, $sql_insert)){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Successfully registered!')
                window.location.href=window.location.href;
                </SCRIPT>");
            }else{
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Database Error!')
                window.location.href=window.location.href;
                </SCRIPT>");
            }
        }else{
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Password Not Match!')
            window.location.href=window.location.href;
            </SCRIPT>");
        }

   }

?>
<html>
   <head> 
        <name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome!</title>
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

        <section class="register-section">
            <h2>Register Page</h2>

            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

            <div class="register-class-container">
                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="Email" required></input>
                <label for="email">Username:</label>
                <input type="text" placeholder="Username" name="username" required></input>
                <label for="email">Password:</label>
                <input type="password" placeholder="Password" name="password" required></input>
                <label for="email">Conform Password:</label>
                <input type="password" placeholder="Conform Password" name="conform_password" required></input>
            </div>
            <p style="text-align: center;">Already have account? <a href="login.php">Login Here</a>!</p>
            <center>
                <input type="submit" id="shop-now-btn" value="Register" name="submit"></input>
            </center>

            </form>
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

   </body>
</html>