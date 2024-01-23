<?php

session_start();

require "connection.php";
error_reporting(0);

if (!isset($_SESSION["u"])) {
	header("Location: index.php"); // Redirect non-logged-in users to index page
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CakeHub | Update Your Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image" href="styles/logo.png">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- animation links -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation links -->

</head>

<body>

    <div class="all-content">
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

        <div class="container-contact100">
            <div class="wrap-contact100">
                <div class="contact100-form validate-form">
                    <span class="contact100-form-title">
                        Update Your Profile
                    </span>
                    <?php

                    if (isset($_SESSION["u"])) {

                        $email = $_SESSION["u"]["email"];

                        $details_rs = Database::search("SELECT * FROM `users` WHERE `email` = '" . $email . "'");

                        $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email`='" . $email . "'");

                        $address_rs = Database::search("SELECT * FROM `users_has_address` INNER JOIN `city` ON users_has_address.city_city_id=city.city_id INNER JOIN `distric` ON city.distric_distric_id=distric.distric_id INNER JOIN `province` ON distric.province_province_id=province.province_id WHERE `users_email`='" . $email . "'");

                        $details_data = $details_rs->fetch_assoc();
                        $image_data = $image_rs->fetch_assoc();
                        $address_data = $address_rs->fetch_assoc();
                    ?>
                        <div class="wrap-input100 validate-input" data-validate="Name is required">
                            <?php

                            if (empty($image_data["path"])) {
                            ?>
                                <img src="styles/placeholder.png" alt="" width="90px">
                            <?php
                            } else {
                            ?>
                                <img src="<?php echo $image_data["path"]; ?>" alt="" width="90px" class="topp" style="border-radius: 50px;">
                            <?php
                            }

                            ?>
                            <span class="mail1"><?php echo $details_data["fname"] . " " . $details_data["lname"]; ?></span>
                            <span class="mail"><?php echo $email; ?></span>
                            <div class="container-contact100-form-btn">
                                <div class="wrap-contact100-form-btn">
                                    <div class="contact100-form-bgbtn"></div>
                                    <button class="contact100-form-btn" onclick="openFileExplorer()">
                                        <span>
                                            Upload Profile Picture
                                            <i class="fa fa-long-arrow-up m-l-7" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <input type="file" id="profileImage" style="display: none">
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Name is required">
                            <span class="label-input100">First Name</span>
                            <input class="input100" type="text" name="fname" id="fname" value="<?php echo $details_data["fname"] ?>">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Name is required">
                            <span class="label-input100">Last Name</span>
                            <input class="input100" type="text" name="lname" id="lname" value="<?php echo $details_data["lname"] ?>">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Address Is required">
                            <span class="label-input100">Registered Date</span>
                            <input class="input100" type="text" name="registered date" readonly value="<?php echo $details_data["joined_date"] ?>">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <span class="label-input100">Email</span>
                            <input class="input100" type="text" name="email" id="email" value="<?php echo $details_data["email"] ?>">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Mobile Number Is required">
                            <span class="label-input100">Mobile Number</span>
                            <input class="input100" type="text" name="mobile" id="mobile" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" value="<?php echo $details_data["mobile"] ?>">
                            <span class="focus-input100"></span>
                        </div>
                        <?php

                        if (empty($address_data["line1"])) {
                        ?>
                            <div class="wrap-input100 validate-input" data-validate="Address Is required">
                                <span class="label-input100">Address</span>
                                <input class="input100" type="text" id="line1" name="line1" placeholder="Enter your Addess">
                                <span class="focus-input100"></span>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="wrap-input100 validate-input" data-validate="Address Is required">
                                <span class="label-input100">Address</span>
                                <input class="input100" type="text" id="line1" name="line1" value="<?php echo $address_data["line1"]; ?>">
                                <span class="focus-input100"></span>
                            </div>
                        <?php
                        }

                        $province_rs = Database::search("SELECT * FROM `province`");
                        $distric_rs = Database::search("SELECT * FROM `distric`");
                        $city_rs = Database::search("SELECT * FROM `city`");

                        $province_num = $province_rs->num_rows;
                        $distric_num = $distric_rs->num_rows;
                        $city_num = $city_rs->num_rows;

                        ?>
                        <div class="wrap-input100 input100-select">
                            <span class="label-input100 imput1">Province</span></br>
                            <div class="custom-dropdown">
                                <select class="selection-2" id="province" name="province">
                                    <option value="0">Select Province</option>
                                    <?php
                                    for ($x = 0; $x < $province_num; $x++) {
                                        $province_data = $province_rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $province_data["province_id"]; ?>" <?php
                                                                                                        if (!empty($address_data["province_province_id"])) {
                                                                                                            if ($province_data["province_id"] == $address_data["province_province_id"]) {
                                                                                                        ?> selected <?php
                                                                                                            }
                                                                                                        }
                                                                                                            ?>>
                                            <?php echo $province_data["province_name"]; ?>
                                        </option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 input100-select">
                            <span class="label-input100">District</span>
                            <div class="custom-dropdown">
                                <select class="selection-2" id="distric" name="district">
                                    <option value="0">Select District</option>
                                    <?php

                                    for ($x = 0; $x < $distric_num; $x++) {
                                        $distric_data = $distric_rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $distric_data["distric_id"]; ?>" <?php
                                                                                                    if (!empty($address_data["distric_distric_id"])) {
                                                                                                        if ($distric_data["distric_id"] == $address_data["distric_distric_id"]) {
                                                                                                    ?>selected<?php
                                                                                                        }
                                                                                                    }
                                                                                ?>><?php echo $distric_data["distric_name"] ?></option>
                                    <?php
                                    }

                                    ?>

                                </select>
                            </div>
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 input100-select">
                            <span class="label-input100">City</span>
                            <div class="custom-dropdown">
                                <select class="selection-2" id="city" name="city">
                                    <option value="0">Select City</option>
                                    <?php
                                    for ($x = 0; $x < $city_num; $x++) {
                                        $city_data = $city_rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $city_data["city_id"]; ?>" <?php
                                                                                            if (!empty($address_data["city_city_id"])) {
                                                                                                if ($city_data["city_id"] == $address_data["city_city_id"]) {
                                                                                            ?>selected<?php
                                                                                                }
                                                                                            }
                                                        ?>>
                                            <?php echo $city_data["city_name"]; ?></option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <span class="focus-input100"></span>
                        </div>

                        <?php

                        if (empty($address_data["postal_code"])) {
                        ?>
                            <div class="wrap-input100 validate-input" data-validate="Address Is required">
                                <span class="label-input100">Postal Code</span>
                                <input class="input100" type="text" id="pc" name="email" placeholder="Enter your Postalcode">
                                <span class="focus-input100"></span>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="wrap-input100 validate-input" data-validate="Address Is required">
                                <span class="label-input100">Postal Code</span>
                                <input class="input100" type="text" id="pc" name="email" value="<?php echo $address_data["postal_code"]; ?>">
                                <span class="focus-input100"></span>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="container-contact100-form-btn">
                            <div class="wrap-contact100-form-btn">
                                <div class="contact100-form-bgbtn"></div>
                                <button class="contact100-form-btn" onclick="updateProfile();">
                                    <span>
                                        Submit
                                        <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    <?php
                    } else {
                    }
                    ?>

                </div>

            </div>


        </div>

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
    </div>
    <!-- footer -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="script.js"></script>
    <script>
        AOS.init();
    </script>



</body>

</html>