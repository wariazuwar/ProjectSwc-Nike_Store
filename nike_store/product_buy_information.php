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

    //PRODUCT INFORMATIONS
    $productID = $_REQUEST['productID'];
    $sql_productInformation = "SELECT * FROM product WHERE product_id='$productID'";
    $res_productInformation = mysqli_query($conn, $sql_productInformation);
    $row_productInformation = mysqli_fetch_array($res_productInformation);

    if(isset($_POST['submit'])){
        $size = $_POST['radio'];
        $Date = date("Y-m-d");
        $amount = $_POST['amount'];

        $sql_insert = "INSERT INTO cart (uid, product_id, size, amount, date) VALUES ('$uid', '$productID', '$size', '$amount', '$Date')";

        if(mysqli_query($conn, $sql_insert)){
            
        }else{
            echo "Error: " . $sql . "<br />" . mysqli_error($conn);
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

        <section class="homepage-section">
            <div class="product-buy-information-flex-box">
                <div class="product-buy-information-left">
                    <div id="product-img-container">
                        <image id="product-img" src="resource/product_pic/<?php echo $row_productInformation['picture']; ?>"></image>
                    </div>
                </div>

                <div class="product-buy-information-right">
                    <h1><?php echo $row_productInformation['name']; ?></h1>
                    <p style="color: red; font-size: 1.2rem;">RM<?php echo $row_productInformation['price']; ?></p>
                    <hr>
                    <h3>Description:</h3>
                    <div class="product-buy-description-container">
                        <p style="margin-top: 0px;"><?php echo $row_productInformation['description'] ?></p>
                    </div>

                    <?php if(!empty($uid)){ ?>
                    <div onclick="showSize();" id="add-to-cart-btn">
                        <span>Add To Cart</span>
                    </div>
                    <?php }else{ ?>
                    <div id="add-to-cart-btn">
                        <span>Please Login</span>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </section>

        <section style="display: none;" id="add-to-cart-hidden">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="size-container">
                            <h1>Please Choose a Size</h1>
                            <label class="container-radio">S
                            <input type="radio" value="S" checked="checked" name="radio">
                            <span class="checkmark"></span>
                            </label>
                            <label class="container-radio">M
                            <input type="radio" value="M" name="radio">
                            <span class="checkmark"></span>
                            </label>
                            <label class="container-radio">XL
                            <input type="radio" value="XL" name="radio">
                            <span class="checkmark"></span>
                            </label>
                            <label class="container-radio">XXL
                            <input type="radio" value="XXL" name="radio">
                            <span class="checkmark"></span>
                            </label>
                            <hr>
                            <h1>Amount</h1>
                            <input type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" min="1" style="width: 100%; height: 30px;" name="amount">
                            <br><br>
                    <input type="submit" name="submit" id="add-to-cart-btn" value="Conform"></input>
                </div>

                <div onclick="showSize();" id="cancel-btn"><span>Cancel</span></div>
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
                    <p>The teroka store main purpose is as online thrift store.We as thrift store we create value for people and society in general by delivering our customer offering and by developing with a focus on sustainable and profitable growth.We also offer fashion, design and services that inspire individuals and allow them to express their own unique style, making it simpler to live a more circular lifestyle.</p>
                </div>

                <div class="footer-flex-items">
                    <h2>Contact Us</h2>
                    <p>Email: terokastore@teroka.com</p>
                    <p>Phone: +60 11-5198-9644</p>
                </div>
            </div>
        </section>
        <div class="copyright">
            <span><i class='bx bx-copyright icon'></i> Copyright 2021</spam>
        </div>

        <script>
            function showSize() {
                var x = document.getElementById("add-to-cart-hidden");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
        </script>

   </body>
</html>