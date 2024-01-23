<?php

session_start();

require "connection.php";

if (isset($_SESSION["u"])) {
    $umail = $_SESSION["u"]["email"];
    $pid = isset($_GET["id"]) ? $_GET["id"] : null;

    if (!$pid) {
        // Redirect to home.php if $pid is not set or empty
        header("Location: home.php");
        exit();
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice | Cake Hub</title>
        <link rel="shortcut icon" type="image" href="styles/logo.png">
        <link rel="stylesheet" href="style1.css">
        <!-- bootstrap links -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- bootstrap links -->
        <!-- fonts links -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <!-- fonts links -->
        <!-- icons links -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <!-- icons links -->
        <!-- animation links -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <!-- animation links -->
    </head>

    <body>
        <div class="all-content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-md" id="navbar">
                <!-- Brand -->
                <a class="navbar-brand" href="home.php" id="logo"><img src="styles/logo1.png" alt="" width="50px">Cake Hub</a>

                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span><img src="styles/menu.png" alt="" width="30px"></span>
                </button>


                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>

                        <form class="form-inline my-2 my-lg-0">
                            <div class="input-group">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="kw">
                                <div class="input-group-append">
                                    <div class="input-group-text custom-search-icon" onclick="basicSearch(0);">
                                        <i class='bx bx-search-alt'></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- dropdown -->
                        <li class="nav-item dropdown" id="c">
                            <a href="#" class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown" value="0">
                                Category
                            </a>
                            <div class="dropdown-menu">
                                <?php
                                $catagory_rs = Database::search("SELECT * FROM `category`");
                                $catagory_num = $catagory_rs->num_rows;
                                for ($x = 0; $x < $catagory_num; $x++) {
                                    $catagory_data = $catagory_rs->fetch_assoc();
                                ?>
                                    <a href="#" class="dropdown-item" value="<?php echo $catagory_data["cat_id"]; ?>"><?php echo $catagory_data["cat_name"]; ?></a>

                                <?php

                                }
                                ?>
                            </div>
                        </li>
                        <!-- dropdown -->
                        <li class="nav-item">
                            <a class="nav-link" href="advancedsearch.php">Galary</a>
                        </li>
                        <!-- <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <?php
                        if (isset($_SESSION["u"])) {
                            $session_data = $_SESSION["u"];
                        ?>
                            <div class="nav-item">
                                <a class="nav-link" href="#"><?php echo $session_data["fname"] . " " . $session_data["lname"]; ?> </a>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="nav-item">
                                <a class="nav-link" href="#"> </a>
                            </div>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
                if (isset($_SESSION["u"])) {
                    $session_data = $_SESSION["u"];
                    $email = $session_data["email"];

                    // Fetch user profile image
                    $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email` = '" . $email . "'");
                    $image_data = $image_rs->fetch_assoc();
                }
                ?>
                <?php
                if (isset($_SESSION["u"])) {
                    if (empty($image_data["path"])) {
                        echo '<img src="styles/placeholder.jpg" alt="" width="30px" class="pro">';
                    } else {
                        echo '<img src="' . $image_data["path"] . '" alt="" width="30px" class="pro">';
                    }
                }
                ?>

                <?php
                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `users_email`='" . $_SESSION["u"]["email"] . "'");
                $watchlist_num = $watchlist_rs->num_rows;

                $result = Database::search("SELECT is_admin FROM users WHERE email='" . $email . "'");
                if ($result && $row = $result->fetch_assoc()) {
                    $is_admin = $row['is_admin'];
                    if ($is_admin == 1) {

                        // Display the HTML for admin user
                        echo '
                    <div class="icons dropdown">
                        <img src="styles/user.png" alt="" width="20px" class="dropdown-toggle" data-toggle="dropdown" id="userIcon">
                        <div class="dropdown-menu custom-dropdown-menu" aria-labelledby="userIcon">
                            <a class="dropdown-item" href="myprofile.php"><i class="bx bx-user"></i>&nbsp; My Profile</a>
                            <a class="dropdown-item" href="#"><i class="bx bxs-user-detail"></i>&nbsp; Admin Panel</a>
                            <a class="dropdown-item" href="listitems.php"><i class="bx bx-plus-circle"></i>&nbsp; List Item</a>
                            <a class="dropdown-item" href="#" onclick="logout()"><i class="bx bx-log-out-circle"></i>&nbsp; Log Out</a>
                        </div>
                        <img src="styles/heart.png" alt="" width="20px" onclick="watchlis();">
                        <span class="num">' . $watchlist_num . '</span>
                        <img src="styles/add.png" alt="" width="24px">
                    </div>';
                    } else {
                        // Display the HTML for non-admin user
                        echo '
                    <div class="icons dropdown">
                        <img src="styles/user.png" alt="" width="20px" class="dropdown-toggle" data-toggle="dropdown" id="userIcon">
                        <div class="dropdown-menu custom-dropdown-menu" aria-labelledby="userIcon">
                            <a class="dropdown-item" href="myprofile.php"><i class="bx bx-user"></i>&nbsp; My Profile</a>
                            <a class="dropdown-item" href="#" onclick="logout()"><i class="bx bx-log-out-circle"></i>&nbsp; Log Out</a>
                        </div>
                        <img src="styles/heart.png" alt="" width="20px">
                        <img src="styles/add.png" alt="" width="24px">
                    </div>';
                    }
                } else {
                    echo '
               <div class="nav-item">
                    <a class="nav-link" href="index.php">Log In </a>
                </div>';
                }


                ?>
            </nav>
            <h1 style="text-align: center;font-weight: bold;margin-top: 50px; color: rgba(161, 109, 14, 1);text-shadow: 1px 1px 1px black;border-bottom: 2px solid rgba(161, 109, 14, 1);margin-left:9%;margin-right:9%;" data-aos="fade-up" data-aos-duration="1500">Thanks For Your Order</h1>
            <section id="product-cards" data-aos="fade-up" data-aos-duration="1500">
                <div class="container">

                    <div class="row" style="margin-top:50px;">
                        <div class="col-md-3 py-3 py-md-0">
                            <?php

                            $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $pid . "'");
                            $invoice_data = $invoice_rs->fetch_assoc();

                            ?>
                            <div class="card" style="width: 435%; height:500px;">
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Order Id</h6>
                                    <h6 style="margin-left: 48%;">#<?php echo $invoice_data["order_id"]; ?></h6>

                                </div>
                                <?php
                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $invoice_data["product_id"] . "'");
                                $product_data = $product_rs->fetch_assoc();
                                ?>
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Item Name</h6>
                                    <h6 style="margin-left: 49.5%;"><?php echo $product_data["title"]; ?></h6>

                                </div>
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Qty</h6>
                                    <h6 style="margin-left: 72%;">x<?php echo $invoice_data["qty"]; ?></h6>

                                </div>
                                <?php

                                $city_rs = Database::search("SELECT distric.distric_id AS `did` FROM `users_has_address` INNER JOIN `city` ON users_has_address.city_city_id=city_city_id INNER JOIN `distric` ON  city.distric_distric_id=distric_distric_id WHERE `users_email`='" . $umail . "'");
                                $city_data = $city_rs->fetch_assoc();

                                $delivery = 0;
                                if ($city_data["did"] == 7) {
                                    $delivery = $product_data["delivery_fee_colombo"];
                                } else {
                                    $delivery = $product_data["delivery_fee_other"];
                                }

                                $t = $invoice_data["total"];
                                $g = $t - $delivery;

                                ?>
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Subtotal</h6>
                                    <h6 style="margin-left: 55%;">Rs.<?php echo $g; ?>.00</h6>

                                </div>

                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Delivery Cost</h6>
                                    <h6 style="margin-left: 51%;">Rs.<?php echo $delivery; ?>.00</h6>

                                </div>
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Payment Method</h6>
                                    <h6 style="margin-left: 46%;">Debit card</h6>

                                </div>
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Estimated Total</h6>
                                    <h6 style="margin-left: 47.8%;">Rs.<?php echo $invoice_data["total"] ?>.00</h6>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <h1 style="text-align: center;font-weight: bold;margin-top: 50px; color: rgba(161, 109, 14, 1);text-shadow: 1px 1px 1px black;border-bottom: 2px solid rgba(161, 109, 14, 1);margin-left:9%;margin-right:9%;" data-aos="fade-up" data-aos-duration="1500">Billing Details</h1>
            <section id="product-cards" data-aos="fade-up" data-aos-duration="1500">
                <div class="container">

                    <div class="row" style="margin-top:50px;">
                        <div class="col-md-3 py-3 py-md-0">
                            <?php

                            $address_rs = Database::search("SELECT * FROM `users_has_address` WHERE `users_email`='" . $umail . "'");
                            $address_data = $address_rs->fetch_assoc();

                            $user_rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $umail . "'");
                            $user_data = $user_rs->fetch_assoc();
                            ?>
                            <div class="card" style="width: 435%; height:285px;">
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Customer Name</h6>
                                    <h6 style="margin-left: 43%;"><?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]; ?></h6>
                                </div>
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Email</h6>
                                    <h6 style="margin-left: 39%;"><?php echo $umail; ?></h6>
                                </div>
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Mobile Number</h6>
                                    <h6 style="margin-left: 49%;"><?php echo $user_data["mobile"] ?></h6>
                                </div>
                                <div style="display: flex;flex-wrap: wrap; padding:20px;margin-left:20%">
                                    <h6>Address</h6>
                                    <h6 style="margin-left: 43%;"><?php echo $address_data["line1"];  ?></h6>

                                </div>
                                <div style="margin-left: 22%;display: flex;flex-wrap: wrap;">
                                    <button class="boto" type="button" style="margin-right:170px;"> 
                                        <a style="text-decoration: none; color:black;" onmouseover="this.style.color='#FFFFFF'"; onMouseOut="this.style.color='#000000'"; href="<?php echo "emailtemplate.php?id=" . $pid; ?>">Invoice</a>
                                    </button>
                                    <button class="boto" onclick="window.location='home.php'">Home</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- footer -->
            <footer id="footer" data-aos="fade-up" data-aos-duration="1500">
                <div class="footer-top">
                    <div class="container">
                        <div class="row">

                            <div class="col-lg-3 col-md-6 footer-contact">
                                <h3>Cake Hub</h3>
                                <p>
                                    Colombo <br>
                                    Rathnapura <br>
                                    Kandy <br>
                                </p>
                                <strong>Phone:</strong> +94 77 2875 84 <br>
                                <strong>Email:</strong> info@cakehub.com <br>
                            </div>

                            <div class="col-lg-3 col-md-6 footer-links">
                                <h4>Usefull Links</h4>
                                <ul>
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Services</a></li>
                                    <li><a href="#">Terms of service</a></li>
                                    <li><a href="#">Privacy policy</a></li>
                                </ul>
                            </div>





                            <div class="col-lg-3 col-md-6 footer-links">
                                <h4>Our Services</h4>

                                <ul>
                                    <li><a href="#">Island Wide Delivery</a></li>
                                    <li><a href="#">75 Years Trust</a></li>
                                    <li><a href="#">100% Fresh Products</a></li>
                                    <li><a href="#">Low Delivery Charges</a></li>
                                    <li><a href="#">100+ Popular Recipes</a></li>
                                </ul>
                            </div>

                            <div class="col-lg-3 col-md-6 footer-links">
                                <h4>Our Social Networks</h4>
                                <p>Find Us On</p>

                                <div class="socail-links mt-3">
                                    <a href="#"><i class='bx bxl-twitter'></i></a>
                                    <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                                    <a href="#"><i class='bx bxl-instagram-alt'></i></a>
                                    <a href="#"><i class='bx bxl-skype'></i></a>
                                    <a href="#"><i class='bx bxl-linkedin-square'></i></a>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <hr>
                <div class="container py-4">
                    <div class="copyright">
                        &copy; Copyright <strong><span>Cake Hub</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        Designed by <a href="#">Sachith@JAVA Ins</a>
                    </div>
                </div>
            </footer>
            <!-- footer -->

            <a href="#" class="arrow"><i><img src="styles/up-arrow.png" alt="" width="50px"></i></a>



        </div>




       
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="script.js"></script>

        <script>
            AOS.init();
        </script>
    </body>

    </html>

<?php
} else {
    header("Location: home.php");
    exit();
}

// error_reporting(0);
?>