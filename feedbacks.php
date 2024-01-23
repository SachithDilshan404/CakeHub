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
    <title>Feedbacks | Cake Hub</title>
    <link rel="shortcut icon" type="image" href="styles/logo.png">
    <link rel="stylesheet" href="style1.css">
    <!-- bootstrap links -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
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
                        <a class="nav-link" href="#">Feedbacks</a>
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
                            <a class="dropdown-item" href="#"><i class="bx bxs-user-detail"></i>&nbsp; Admin Panel</a>
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
        <div class="all-cont">
            <?php
            $positive_weight = 1;  // Weight for positive feedback
            $negative_weight = 0.2; // Weight for negative feedback

            // Fetch feedback data from the database
            $fs_rs = Database::search("SELECT * FROM `feedback`");
            $fs_num = $fs_rs->num_rows;

            // Initialize counts
            $positive_count = 0;
            $negative_count = 0;

            // Iterate through the feedbacks to calculate positive and negative counts
            while ($row = $fs_rs->fetch_assoc()) {
                $feedback_status = $row['f_staus_idf_staus'];
                if ($feedback_status == 1) {
                    // Positive feedback
                    $positive_count++;
                } elseif ($feedback_status == 2) {
                    // Negative feedback
                    $negative_count++;
                }
            }

            // Calculate the score based on the counts and weights
            $score = ($positive_count * $positive_weight) + ($negative_count * $negative_weight);

            // Display the score
            echo '<div class="numberss">';
            echo '<h1 class="review">' . $score . '</h1>';
            echo '</div>';
            ?>

            <div class="starts">
                <i class='bx bxs-star'></i>
                <i class='bx bxs-star'></i>
                <i class='bx bxs-star'></i>
                <i class='bx bxs-star'></i>
                <i class='bx bxs-star-half'></i>

            </div>

        </div>
        <?php
        $positive_count = 0; // Initialize the count for positive feedbacks
        $negative_count = 0; // Initialize the count for negative feedbacks

        // Fetch feedback data from the database
        $fs_rs = Database::search("SELECT * FROM `feedback`");
        $fs_num = $fs_rs->num_rows;

        // Iterate through the feedbacks to calculate positive and negative counts
        while ($row = $fs_rs->fetch_assoc()) {
            $feedback_status = $row['f_staus_idf_staus'];
            if ($feedback_status == 1) {
                // Positive feedback
                $positive_count++;
            } elseif ($feedback_status == 2) {
                // Negative feedback
                $negative_count++;
            }
        }

        // Determine the overall status based on the counts
        if ($positive_count > $negative_count) {
            $overall_status = 'Excellent';
        } elseif ($positive_count < $negative_count) {
            $overall_status = 'Bad';
        } else {
            $overall_status = 'Average';
        }
        ?>
        <div style="margin-top: 200px;color:white; text-align:center">
            <h6 style="font-weight: bolder;">Reviews <?php echo $fs_num ?> • <?php echo $overall_status ?></h6>
        </div>
        <div class="reviewq">
            <?php
            $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email` = '" . $email . "'");
            $image_data = $image_rs->fetch_assoc();

            // Check if image_data is empty or null, and set a default image path
            if (empty($image_data) || empty($image_data['path'])) {
                $default_image_path = "styles/placeholder.png";  // Replace with your default image path
                $image_path = $default_image_path;
            } else {
                $image_path = $image_data['path'];
            }
            ?>
            <img src="<?php echo $image_path; ?>" width="50px" height="50px" style="border-radius: 50px; margin-left: 360px; margin-top: 15px">
            <a type="button" class="re" data-toggle="modal" data-target="#exampleModal" onclick="checkLoginStatus()">Write a Review</a>
            <div class="star-container">
                <i class="bx bxs-star" onmouseover="hoverStar(1)" onmouseout="resetStarsColor()"></i>
                <i class="bx bxs-star" onmouseover="hoverStar(2)" onmouseout="resetStarsColor()"></i>
                <i class="bx bxs-star" onmouseover="hoverStar(3)" onmouseout="resetStarsColor()"></i>
                <i class="bx bxs-star" onmouseover="hoverStar(4)" onmouseout="resetStarsColor()"></i>
                <i class="bx bxs-star" onmouseover="hoverStar(5)" onmouseout="resetStarsColor()"></i>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#231709; color:white">
                        <h5 class="modal-title" id="exampleModalLabel">Tell us more about your experience</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background-color: #573818; color:white;">
                        <form>
                            <div class="form-group">
                                <label for="experience-select" class="col-form-label">How is your Cake Hub experience?</label>
                                <select class="form-control" id="experience-select" style="background-color: #231709;">
                                    <option value="0">Choose Your Experience</option>
                                    <?php

                                    $fstaus_rs = Database::search("SELECT * FROM `f_staus`");
                                    $fstaus_num = $fstaus_rs->num_rows;

                                    for ($x = 0; $x < $fstaus_num; $x++) {
                                        $fstaus_data = $fstaus_rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $fstaus_data['idf_staus']; ?>"><?php echo $fstaus_data['idf_name']; ?></option>
                                    <?php

                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="title" placeholder="What's important for people to know?" style="background-color: #231709;">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Review:</label>
                                <textarea class="form-control" id="body" style="background-color: #231709;" placeholder="What made your experience great? What is this company doing well? Remember to be honest, helpful, and constructive!"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer" style="background-color: #231709;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="review('<?php echo $_SESSION['u']['email']; ?>');">Post Review</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $users_result = Database::search("
            SELECT DISTINCT users.email, users.fname, users.lname, profile_img.path AS image_path
            FROM users
            JOIN feedback ON users.email = feedback.users_email
            JOIN profile_img ON users.email = profile_img.users_email
        ");


        if ($users_result->num_rows > 0) {
            while ($user_data = $users_result->fetch_assoc()) {
                $email = $user_data['email'];
                $image_path = $user_data['image_path'];

                // Fetch the feedback count for this user
                $feedback_result = Database::search("SELECT * FROM `feedback` WHERE `users_email`='$email'");
                $feedback_count = $feedback_result->num_rows;

                // Display user information and feedback
        ?>
                <div class="comments" style="display: flex;">

                    <div class="user-feedback" style="display: flex;">
                        <?php if ($image_path) { ?>
                            <img src="<?php echo $image_path; ?>" alt="User Image" width="50px" height="50px" style="border-radius: 50px; margin-left: 40px; margin-top: 15px;">
                        <?php } else { ?>
                            <img src="styles/placeholder.png" alt="Default User Image" width="50px" height="50px" style="border-radius: 50px; margin-left: 40px; margin-top: 15px;">
                        <?php } ?>
                        <h6 style="margin-left: 20px; margin-top: 20px; color: white; font-weight: bold;">
                            <?php echo $user_data['fname'] . ' ' . $user_data['lname']; ?> <br />
                            <?php echo $feedback_count; ?> Reviews
                        </h6>
                    </div>
                    <?php
                    // Display user's feedback
                    while ($feedback_data = $feedback_result->fetch_assoc()) {
                        $feedback_status_id = $feedback_data['f_staus_idf_staus'];
                        $feedback_status_label = ($feedback_status_id == 1) ? 'Positive' : (($feedback_status_id == 2) ? 'Negative' : 'Unknown Status');
                        $feedback_status_class = ($feedback_status_id == 2) ? 'negative' : '';
                        $feedback_status_id = $feedback_data['f_staus_idf_staus'];
                        $indicator_class = ($feedback_status_id == 2) ? 'negative' : '';

                    ?>
                        <div class="costar">
                            <i class='bx bxs-star <?php echo $indicator_class; ?>'></i>
                            <i class='bx bxs-star <?php echo $indicator_class; ?>'></i>
                            <i class='bx bxs-star <?php echo $indicator_class; ?>'></i>
                            <i class='bx bxs-star <?php echo $indicator_class; ?>'></i>
                            <i class='bx bxs-star <?php echo $indicator_class; ?>'></i>
                        </div>
                        <h6 class="posi <?php echo $feedback_status_class; ?>"><?php echo $feedback_status_label; ?></h6>
                        <div class="wolker"></div>
                        <div class="feedback">
                            <h4 class="had"><?php echo $feedback_data['title']; ?></h4>
                            <p class="had1"><?php echo $feedback_data['body']; ?></p>
                            <h6 class="had2"><b>Date of experience:</b>&nbsp; <?php echo $feedback_data['f_date'] ?></h6>
                        </div>
                        <div class="wolker1"></div>
                        <div class="had4">
                            <?php
                            $feedbackId = $feedback_data['fid'];
                            $userEmail = htmlspecialchars($_SESSION['u']['email'], ENT_QUOTES, 'UTF-8');

                            // Check if the feedback is liked
                            $like_rs = Database::search("SELECT islike FROM `like` WHERE users_email='" . $userEmail . "' AND feedback_fid='" . $feedbackId . "'");
                            $is_like = ($like_rs && $row = $like_rs->fetch_assoc()) ? $row['islike'] : 0;

                            // Define the CSS classes based on whether it's liked or not
                            $heartClass = $is_like ? 'bxs-heart liked' : 'bx-heart';

                            // Output the heart icon
                            echo "<i class='bx $heartClass' onclick='toggleLike($feedbackId, \"$userEmail\", this)'></i>";
                            ?>
                            <h6 class="boby" onclick="checkLoginStatus()">Usefull</h6>
                        </div>
                        <?php
                        $user_email = $_SESSION["u"]["email"];
                        $result = Database::search("SELECT is_admin FROM users WHERE email='" . $user_email . "'");
                        if ($result && $row = $result->fetch_assoc()) {
                            $is_admin = $row['is_admin'];
                            if ($is_admin == 1) {

                                // Display the HTML for admin user
                                echo '
                                <div class="had5">
                                <i class="bx bxs-message-rounded-dots"></i>
                                <h6 class="bobyy" onclick="setFeedbackId(' . $feedbackId . ')" data-toggle="modal" data-target="#exampleModal1">Comment</h6>
                                </div>
                                ';
                            } else {
                                // Display the HTML for non-admin user
                                echo '
                                ';
                            }
                        }
                        ?>
                        <?php
                        $reply_rs = Database::search("SELECT * FROM `feedback_reply` WHERE feedback_fid='" . $feedbackId . "'");
                        $reply_data = $reply_rs->fetch_assoc();

                        if ($reply_data) {
                            // Display the reply only if there are results
                            echo '<div class="reply">';
                            echo '<div class="clid" style="display: flex;">';
                            echo '<i class="bx bxs-share bx-rotate-180"></i>';
                            echo '<h6 class="relp">Reply from CakeHub.inc</h6>';
                            echo '<p class="replys">' . $reply_data['body'] . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:#231709; color:white">
                                        <h5 class="modal-title" id="exampleModalLabel">Replay Comments</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: white;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="background-color: #573818; color:white;">
                                        <form>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label"> Reply Message:</label>
                                                <textarea class="form-control" style="background-color: #231709;" id="text" placeholder="Give Admin's Feedback for Customer's Current Situation"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer" style="background-color: #231709;">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary reply-button" onclick="reply('<?php echo $_SESSION['u']['email']; ?>')">Reply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

    <?php
                    }
                }
            }
    ?>




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
    <script>
        function checkLoginStatus() {
            <?php
            // Check if the user is not logged in based on the session data
            if (!isset($_SESSION['u']['email'])) {
                // Redirect non-logged-in users to index.php
                echo 'window.location.href = "index.php";';
            }
            ?>
        }
    </script>
</body>

</html>