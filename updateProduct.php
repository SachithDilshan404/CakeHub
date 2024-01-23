<?php
session_start();

require "connection.php";

// Check if the user is logged in
if (!isset($_SESSION["u"])) {
    header("Location: index.php");  // Redirect to login page if not logged in
    exit();
}

// Check if the logged-in user is an admin
$email = $_SESSION["u"]["email"];
$result = Database::search("SELECT is_admin FROM users WHERE email='" . $email . "'");

if ($result && $row = $result->fetch_assoc()) {
    $is_admin = $row['is_admin'];

    // If the user is not an admin, log them out and redirect to home
    if ($is_admin != 1) {
        session_destroy();
        header("Location: home.php");  // Redirect to home if not an admin
        exit();
    }
} else {
    // Handle error if unable to retrieve admin status
    echo "Error: Unable to retrieve admin status.";
    exit();
}

if (isset($_SESSION["p"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Items | Cake Hub</title>
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
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <div class="input-group-text custom-search-icon">
                                        <i class='bx bx-search-alt'></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- dropdown -->
                        <li class="nav-item dropdown">
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
                            <a class="nav-link" href="#">Galary</a>
                        </li>
                        <!-- <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="feedbacks.php">Feedbacks</a>
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

                $cart_rs = Database::search("SELECT * FROM `cart` WHERE `users_email`='" . $_SESSION["u"]["email"] . "'");
                $cart_num = $cart_rs->num_rows;

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
                            <a class="dropdown-item" href="adminlogin.php"><i class="bx bxs-user-detail"></i>&nbsp; Admin Panel</a>
                            <a class="dropdown-item" href="listitems.php"><i class="bx bx-plus-circle"></i>&nbsp; List Item</a>
                            <a class="dropdown-item" href="#" onclick="logout()"><i class="bx bx-log-out-circle"></i>&nbsp; Log Out</a>
                        </div>
                        <img src="styles/heart.png" alt="" width="20px" onclick="watchlis();">
                        <span class="num">' . $watchlist_num . '</span>
                        <img src="styles/add.png" alt="" width="24px" onclick="addcart();">
                        <span class="nub">' . $cart_num . '</span>
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
                        <img src="styles/heart.png" alt="" width="20px" onclick="watchlis();"><span class="num">' . $watchlist_num . '</span>
                        <img src="styles/add.png" alt="" width="24px" onclick="addcart();"><span class="nub">' . $cart_num . '</span>
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
            <!-- navbar end -->

            <div class="container-contact100">
                <div class="wrap-contact100">
                    <div class="contact100-form validate-form">
                        <span class="contact100-form-title">
                            Update Product
                        </span>
                        <?php
                        $product = $_SESSION["p"];
                        $img = array();
                        $img[0] = "styles/add-product_7245827.png";
                        $img[1] = "styles/add-product_7245827.png";
                        $img[2] = "styles/add-product_7245827.png";
                        $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product["id"] . "'");
                        $img_num = $img_rs->num_rows;
                        for ($x = 0; $x < $img_num; $x++) {
                            $img_data = $img_rs->fetch_assoc();
                            $img[$x] = $img_data["img_path"];
                        }
                        ?>
                        <div class="wrap-input100 validate-input" data-validate="Name is required">
                            <img src="<?php echo $img[0]; ?>" style="margin-right: 50px;" alt="" width="90px" id="i0">
                            <img src="<?php echo $img[1]; ?>" style="margin-right: 50px;" alt="" width="90px" id="i1">
                            <img src="<?php echo $img[2]; ?>" alt="" width="90px" id="i2">
                            <div class="container-contact100-form-btn">
                                <div class="wrap-contact100-form-btn">
                                    <div class="contact100-form-bgbtn"></div>
                                    <button class="contact100-form-btn" onclick="changeProductimage()">
                                        <span>
                                            Upload Product Pictures
                                            <i class="fa fa-long-arrow-up m-l-7" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="imageuploader" style="display: none" multiple>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Name is required">
                            <span class="label-input100">Product Title</span>
                            <?php
                            $product = $_SESSION["p"];
                            ?>
                            <input class="input100" type="text" name="product title" value="<?php echo $product["title"]; ?>" id="t">

                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Message is required">
                            <span class="label-input100">Short Desciption</span>
                            <textarea class="input100" name="message" id="srd" rows="6" cols="10"><?php echo htmlspecialchars($product["srt_descri"]); ?></textarea>
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Message is required">
                            <span class="label-input100">Long Desciption</span>
                            <textarea class="input100" name="message" id="ld" rows="13" cols="10"><?php echo htmlspecialchars($product["description"]); ?></textarea>
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <span class="label-input100">Cost Per Item</span>
                            <input class="input100" type="text" name="email" id="cost" value="<?php echo $product["price"]; ?>" disabled>
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <span class="label-input100">Delivery Cost</span> </br>
                            <span class="label-input100"><b>Delivery Cost In Colombo</b></span>
                            <input class="input100" type="text" name="email" id="dtc" value="<?php echo $product["delivery_fee_colombo"]; ?>">
                            <span class="focus-input100"></span>
                            <span class="label-input100"><b>Delivery Cost outside Colombo</b></span>
                            <input class="input100" type="text" name="email" id="dto" value="<?php echo $product["delivery_fee_other"]; ?>">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <span class="label-input100">Product Quantity</span>
                            <input class="input100" type="number" name="email" id="pq" value="<?php echo $product["qty"]; ?>">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 input100-select">
                            <span class="label-input100">Product Category</span>
                            <div class="custom-dropdown">
                                <select class="selection-2" name="service" disabled>
                                    <?php

                                    $product = $_SESSION["p"];
                                    $catagory_rs = Database::search("SELECT * FROM `category` WHERE `cat_id` = '" . $product["category_cat_id"] . "'");
                                    $catagory_data = $catagory_rs->fetch_assoc();

                                    ?>
                                    <option><?php echo $catagory_data["cat_name"]; ?></option>

                                </select>
                            </div>
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="">
                            <span class="label-input100">We Accept</span> </br>
                            <i class='bx bxl-visa bx-lg bx-flashing'></i>
                            <i class='bx bxl-mastercard bx-lg bx-flashing'></i>
                            <i class='bx bxl-paypal bx-lg bx-flashing'></i>
                            <i class='bx bxs-credit-card-alt bx-lg bx-flashing'></i>
                            <i class='bx bxs-credit-card bx-lg bx-flashing'></i>
                            <span class="focus-input100"></span>
                        </div>
                        <div class="container-contact100-form-btn">
                            <div class="wrap-contact100-form-btn">
                                <div class="contact100-form-bgbtn"></div>
                                <button class="contact100-form-btn" onclick="updateProduct();">
                                    <span>
                                        Update Product
                                        <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    echo "Please add product First";
    header("Location: myprofile.php");
}
?>