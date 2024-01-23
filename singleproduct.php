<?php

session_start();

require "connection.php";

if (isset($_GET["id"])) {
    $pid = $_GET["id"];

    $user = $_SESSION["u"];

    $product_rs = Database::search("SELECT product.id,product.price,product.description,product.title,product.datetime_added,product.delivery_fee_colombo,product.delivery_fee_other,product.category_cat_id,product.users_email FROM `product`  WHERE product.id = '" . $pid . "'");

    $product_num = $product_rs->num_rows;
    if ($product_num == 1) {
        $product_data = $product_rs->fetch_assoc();

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $product_data["title"]; ?> | Cake Hub</title>
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
                        <img src="styles/heart.png" alt="" width="20px">
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
                <!-- navbar end -->

                <!-- Single Product View -->
                <div class="main-wrapper" data-aos="fade-up" data-aos-duration="1500">
                    <br /> <br /> <br />
                    <div class="container1">
                        <div class="product-div" style="background-color:rgba(161, 109, 14, 1);">
                            <div class="product-div-left">
                                <div class="img-container">
                                    <?php
                                    $product_img_rss = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $pid  . "'");

                                    $product_img_dataa = $product_img_rss->fetch_assoc();
                                    ?>
                                    <img src="<?php echo $product_img_dataa["img_path"] ?>" alt="">
                                    
                                </div>
                                <div class="hover-container">
                                    <?php

                                    $image_rss = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $pid . "'");
                                    $image_num = $image_rss->num_rows;
                                    $image_list = array();

                                    if ($image_num != 0) {
                                        for ($b = 0; $b < $image_num; $b++) {
                                            $image_data = $image_rss->fetch_assoc();
                                            $image_list[$b] = $image_data["img_path"];
                                    ?>

                                            <div><img src="<?php echo $image_list[$b]; ?>"></div>

                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div><img src="styles/add-product_7245827.png"></div>
                                        <div><img src="styles/add-product_7245827.png"></div>
                                        <div><img src="styles/add-product_7245827.png"></div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="product-div-right">
                                <span class="product-name"><?php echo $product_data["title"]; ?> </span><br />
                                <span class="product-price">Rs.<?php echo $product_data["price"]; ?>.00</span>
                                <div class="product-rating">
                                    <span><i class='bx bxs-star'></i></span>
                                    <span><i class='bx bxs-star'></i></span>
                                    <span><i class='bx bxs-star'></i></span>
                                    <span><i class='bx bxs-star'></i></span>
                                    <span><i class='bx bxs-star-half'></i></span>
                                    <span>(350 ratings)</span>
                                </div>
                                <p class="product-description"><?php echo $product_data["description"]; ?></p>
                                <div class="btn-groups">
                                    <button type="button" class="add-cart-btn"><i class='bx bxs-cart-alt'></i> add to cart</button>
                                    <button type="button" class="add-watch-btn"><i class='bx bxs-heart'></i> WatchList</button>
                                    <button type="submit" class="buy-now-btn" id="payhere-payment" onclick="paynow(<?php echo $pid; ?>);"><i class='bx bxs-wallet-alt'></i> buy now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single Product View -->

                <!-- You may like -->
                <h1 style="text-align: center;font-weight: bold;margin-top: 50px; color: rgba(161, 109, 14, 1);text-shadow: 1px 1px 1px black;border-bottom: 2px solid rgba(161, 109, 14, 1);margin-left:7%;margin-right:7%;" data-aos="fade-up" data-aos-duration="1500">You Also May Like</h1>
                <div id="sortt">
                    <section id="product-cards" data-aos="fade-up" data-aos-duration="1500">
                        <div class="container">
                            <div class="row" style="margin-top: 50px;">
                                <?php

                                if (isset($_GET["paga"])) {
                                    $paga = $_GET["paga"];
                                } else {
                                    $paga = 1;
                                }

                                $product_rss = Database::search("SELECT * FROM `product` ORDER BY `datetime_added` ");
                                $product_numm = $product_rss->num_rows;

                                $result_per_page = 4;
                                $number_of_page = ceil($product_numm / $result_per_page);


                                $paga_results = ($paga - 1) * $result_per_page;
                                $selected_rss = Database::search("SELECT * FROM `product` ORDER BY `datetime_added` ASC LIMIT " . $result_per_page . " OFFSET " . $paga_results . " ");
                                $selected_numm = $selected_rss->num_rows;

                                for ($x = 0; $x < $selected_numm; $x++) {
                                    $selected_dataa = $selected_rss->fetch_assoc();

                                ?>

                                    <div class="col-md-3 py-3 py-md-0">
                                        <div class="card">
                                            <div class="overlay">
                                                <button type="button" class="btn btn-secondary" title="Quick View"><i><img src="styles/views.png" alt="" width="30px"></i></button>
                                                <button type="button" class="btn btn-secondary" title="Add to Wishlist"><i><img src="styles/heart.png" alt="" width="30px"></i></button>
                                                <button type="button" class="btn btn-secondary" title="Add to Cart"><i><img src="styles/add.png" alt="" width="30px"></i></button>
                                            </div>
                                            <?php

                                            $product_img_rss = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_dataa["id"] . "'");

                                            $product_img_dataa = $product_img_rss->fetch_assoc();

                                            ?>
                                            <img src="<?php echo $product_img_dataa["img_path"] ?>" alt="">
                                            <div class="card-body">
                                                <h3><?php echo $selected_dataa["title"] ?></h3>
                                                <div class="star">
                                                    <i class="bx bxs-star checked"></i>
                                                    <i class="bx bxs-star checked"></i>
                                                    <i class="bx bxs-star checked"></i>
                                                    <i class="bx bxs-star checked"></i>
                                                    <i class="bx bxs-star checked"></i>
                                                </div>
                                                <p><?php echo $selected_dataa["srt_descri"] ?></p>
                                                <h6>Rs.<?php echo $selected_dataa["price"] ?>.00<span><button>Add Cart</button></span></h6>
                                            </div>
                                        </div>
                                    </div>


                                <?php
                                }

                                ?>
                            </div>

                        </div>


                    </section>

                    <br />

                    <div class="pagination">
                        <ul>
                            <li><a href="<?php if ($paga <= 1) {
                                                echo ("#");
                                            } else {
                                                echo "?paga =" . ($paga - 1);
                                            } ?>" class="prev">&lt; Prev</a></li>

                            <?php

                            for ($y = 1; $y < $number_of_page; $y++) {
                                if ($y == $paga) {
                                    echo "<li class='pageNumber active'><a href='?paga=$y'>$y</a></li>";
                                } else {
                                    echo "<li class='pageNumber'><a href='?paga=$y'>$y</a></li>";
                                }
                            }
                            ?>

                            <li><a href="<?php if ($paga >= $number_of_page) {
                                                echo ("#");
                                            } else {
                                                echo "?paga=" . ($paga + 1);
                                            } ?>" class="next">Next &gt;</a></li>
                        </ul>
                    </div>
                </div>
                <!-- You may like -->

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




            <script src="script.js"></script>
            <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
            <script>
                AOS.init();
            </script>
            <script>
                const allHoverImages = document.querySelectorAll(".hover-container div img");
                const imgContainer = document.querySelector(".img-container");

                window.addEventListener("DOMContentLoaded", () => {
                    allHoverImages[0].parentElement.classList.add("active");
                });

                allHoverImages.forEach((image) => {
                    image.addEventListener("mouseover", () => {
                        imgContainer.querySelector("img").src = image.src;
                        resetActiveImg();
                        image.parentElement.classList.add("active");
                    });
                });

                function resetActiveImg() {
                    allHoverImages.forEach((img) => {
                        img.parentElement.classList.remove("active");
                    });
                }
            </script>
            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
        </body>

        </html>
    <?php
    } else {
    ?> <script>
            alert("Somthing went wrong")
        </script> <?php
                }
            }

            // error_reporting(0);
                    ?>