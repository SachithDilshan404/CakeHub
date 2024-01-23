<?php

session_start();

require "connection.php";

error_reporting(0);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Cake Hub</title>
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
                        <span class="nub">'.$cart_num.'</span>
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
                        <img src="styles/add.png" alt="" width="24px" onclick="addcart();"><span class="nub">'.$cart_num.'</span>
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



        <!-- home section -->
        <div class="home">
            <div class="content" data-aos="zoom-out-right">
                <h3>Delicious
                    <br>Cakes Bakery
                </h3>
                <h2>Category <span class="changecontent"></span></h2>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Error,
                    <br>Lorem ipsum dolor sit amet consectetur.
                </p>
                <a href="#" class="btn">Order Now</a>
            </div>
            <div class="img" data-aos="zoom-out-left">
                <img src="styles/background.png" alt="">
            </div>
        </div>
        <!-- home section end -->

        <!-- top cards -->
        <div class="container" id="box" data-aos="fade-up" data-aos-duration="1500">
            <div class="row">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <img src="styles/box1.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <img src="styles/box2.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <img src="styles/box3.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <!-- top cards end -->

        <!-- banner -->
        <div class="banner" data-aos="fade-up" data-aos-duration="1500">
            <div class="content">
                <h3>Delicious Cake</h3>
                <h2>UPTO 50% OFF</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, quod.</p>
                <div id="btnorder"><button>Order Now</button></div>
            </div>
            <div class="img">
                <img src="styles/banner-background.png" alt="">
            </div>
        </div>
        <!-- banner end -->

        <!-- product cards -->
        <div id="sortt">
            <section id="product-cards" data-aos="fade-up" data-aos-duration="1500">
                <div class="container">
                    <?php
                    $c_rs = Database::search("SELECT * FROM `category` LIMIT 2");
                    $c_num = $c_rs->num_rows;
                    for ($y = 0; $y < $c_num; $y++) {
                        $c_data = $c_rs->fetch_assoc();
                    ?>
                        <h1><?php echo $c_data["cat_name"]; ?></h1>
                        <div class="row" style="margin-top: 50px;">
                            <?php

                            $product_rs = Database::search("SELECT * FROM `product` WHERE `category_cat_id`='" . $c_data['cat_id'] . "' AND `status_status_id`='1' ORDER BY 
                            `datetime_added` DESC LIMIT 4 OFFSET 0");

                            $product_num = $product_rs->num_rows;

                            for ($x = 0; $x < $product_num; $x++) {

                                $product_data = $product_rs->fetch_assoc();

                            ?>

                                <?php

                                $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data['id'] . "'");

                                $img_data = $img_rs->fetch_assoc();

                                ?>

                                <div class="col-md-3 py-3 py-md-0">
                                    <div class="card">
                                        <div class="overlay">
                                            <a type="button" class="btn btn-secondary" title="Quick View" href="<?php echo "singleproduct.php?id=" . ($product_data["id"]); ?>"><i><img src="styles/views.png" alt="" width="30px"></i></a>
                                            <button type="button" class="btn btn-secondary" title="Add to Wishlist" onclick="addToWatchlist(<?php echo $product_data['id']; ?>)"><i><img src="styles/heart.png" alt="" width="30px"></i></button>
                                            <button type="button" class="btn btn-secondary" title="Add to Cart" onclick="addToCart(<?php echo $product_data['id']; ?>);" href="#"><i><img src="styles/add.png" alt="" width="30px"></i></button>
                                        </div>
                                        <img src="<?php echo $img_data["img_path"]; ?>" alt="">
                                        <div class="card-body">
                                            <h3><?php echo $product_data["title"]; ?></h3>
                                            <div class="star">
                                                <i class="bx bxs-star checked"></i>
                                                <i class="bx bxs-star checked"></i>
                                                <i class="bx bxs-star checked"></i>
                                                <i class="bx bxs-star checked"></i>
                                                <i class="bx bxs-star checked"></i>
                                            </div>
                                            <p><?php echo $product_data["srt_descri"]; ?></p>
                                            <h6>Rs.<?php echo $product_data["price"]; ?>.00<span><button>Add Cart</button></span></h6>
                                        </div>
                                    </div>
                                </div>
                            <?php

                            }

                            ?>




                        </div>
                    <?php
                    }
                    ?>
                </div>
            </section>

        </div>
        <!-- product cards end-->


        <!-- gallary -->
        <section id="gallary" data-aos="fade-up" data-aos-duration="1500">
            <div class="container">
                <h1>OUR GALLARY</h1>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-4 py-3 py-md-0">
                        <div class="card">
                            <div class="overlay">
                                <h3 class="text-center">Donuts</h3>
                            </div>
                            <img src="styles/o1.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-4 py-3 py-md-0">
                        <div class="card">
                            <div class="overlay">
                                <h3 class="text-center">Ice Cream</h3>
                            </div>
                            <img src="styles/o2.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-4 py-3 py-md-0">
                        <div class="card">
                            <div class="overlay">
                                <h3 class="text-center">Cup Cake</h3>
                            </div>
                            <img src="styles/o3.png" alt="">
                        </div>
                    </div>
                </div>


                <div class="row" style="margin-top: 30px;" data-aos="fade-up" data-aos-duration="1500">
                    <div class="col-md-4 py-3 py-md-0">
                        <div class="card">
                            <div class="overlay">
                                <h3 class="text-center">Delicious Cake</h3>
                            </div>
                            <img src="styles/o4.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-4 py-3 py-md-0">
                        <div class="card">
                            <div class="overlay">
                                <h3 class="text-center">Chocolate Cake</h3>
                            </div>
                            <img src="styles/o5.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-4 py-3 py-md-0">
                        <div class="card">
                            <div class="overlay">
                                <h3 class="text-center">Slice Cake</h3>
                            </div>
                            <img src="styles/o6.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- gallary -->



        <!-- about -->
        <div class="container" id="about" data-aos="fade-up" data-aos-duration="1500">
            <h1>ABOUT US</h1>
            <div class="row">
                <div class="col-md-6 py-3 py-md-0">
                    <div class="card">
                        <img src="styles/about.png" alt="">
                    </div>
                </div>
                <div class="col-md-6 py-3 py-md-0">
                    <p>Welcome to CakeHub.inc, where passion meets perfection in every delectable creation. Our online cake shop is your sweet escape into a world of irresistible treats. With a team of dedicated bakers and confectionery artists, we craft cakes that are not just desserts but expressions of joy and celebration. From classic flavors like velvety chocolate and luscious vanilla to custom masterpieces adorned with intricate designs, we cater to every occasion, ensuring your special moments are adorned with delightful sweetness. We take pride in using the finest, freshest ingredients, ensuring each bite offers a taste that's as divine as the visual delight.Explore our website, indulge in a slice of happiness, and make life sweeter, one cake at a time. Whether it's a birthday, wedding, or any milestone event, trust CakeHub.inc to create the perfect centerpiece for your celebrations.</p>

                    <div id="bt"><button>Read More...</button></div>
                </div>
            </div>
        </div>
        <!-- about -->


        <!-- contact  -->
        <div class="container" id="contact" data-aos="fade-up" data-aos-duration="1500">
            <h1>CONTACT US</h1>
            <div class="row">
                <div class="col-md-4 py-1 py-md-0">
                    <div class="form-group">
                        <input type="text" class="form-control" id="usr" placeholder="Name">
                    </div>
                </div>
                <div class="col-md-4 py-1 py-md-0">
                    <div class="form-group">
                        <input type="email" class="form-control" id="eml" placeholder="Email">
                    </div>
                </div>
                <div class="col-md-4 py-1 py-md-0">
                    <div class="form-group">
                        <input type="number" class="form-control" id="phn" placeholder="Phone">
                    </div>
                </div>

            </div>
            <div class="form-group">
                <textarea class="form-control" rows="5" id="comment" placeholder="Message"></textarea>
            </div>
            <div id="messagebtn"><button onclick="contact();">Send Message</button></div>
        </div>
        <!-- contact end -->


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