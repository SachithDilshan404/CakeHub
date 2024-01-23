<?php
session_start();

require "connection.php";

// Check if the user is logged in as an admin
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
}
if (isset($_GET["cid"])) {
    $data = $_GET["cid"];
} else {
    header("Location: adminpannnel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="styless.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="shortcut icon" type="image" href="styles/logo.png">
    <title>Admin Pannel | Cakehub.inc</title>
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-server'></i>
            <span class="text">Admin Pannel</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="#" data-tab-id="section1" onclick="window.location='adminpannnel.php'">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="window.location='adminpannnel.php'" data-tab-id="section2">
                    <i class='bx bxs-shopping-bag-alt'></i>
                    <span class="text">My Store</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="window.location='adminpannnel.php'" data-tab-id="section3">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Analytics</span>
                </a>
            </li>
            <li class="active">
                <a href="#" onclick="window.location='adminpannnel.php'" data-tab-id="section4">
                    <i class='bx bxs-message-dots'></i>
                    <span class="text">Message</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="window.location='adminpannnel.php'" data-tab-id="section5">
                    <i class='bx bxs-group'></i>
                    <span class="text">Team</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#" onclick="window.location='adminpannnel.php'">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
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
                        echo '<img src="' . $image_data["path"] . '" alt="" >';
                    }
                }
                ?>
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div id="section1" class="tab-content">
                <div class="head-title">
                    <div class="left">
                        <h1>Reply Messages</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Admin Panel</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="adminpannnel.php">Messages</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Reply Messages</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-data" style="display:grid">
                    <div class="todo">
                        <?php
                        if (isset($_SESSION["u"])) {
                            $session_data = $_SESSION["u"];
                        }
                        if (isset($_GET["cid"])) {
                            $data = $_GET["cid"];
                        }
                        if (isset($_GET['email'])) {

                            $uemail = $_GET['email'];
                        }
                        ?>
                        <div class="head1">
                            <img src="styles/124599.jpg" width="20px" height="20px" style="border-radius: 50%;">
                            <input type="text" class="typo" placeholder="Write A Reply" id="reply" style="width:100%;height:30px;border-color:transparent;background-color:transparent">
                            <i class='bx bxs-send bx-border-circle' style='color:#0ea5e9;cursor:pointer' onclick="sendme(<?php echo $_GET['cid']; ?>,`<?php echo $session_data['email'] ?>`, `<?php echo $_GET['email']; ?>`);"></i>
                        </div>
                    </div>
                    <?php

                    if (isset($_GET['cid'])) {
                        $cid = $_GET['cid'];
                        $contact_rs = Database::search("SELECT name, date, message FROM contact WHERE cid = '$cid'");

                        if ($contact_rs->num_rows > 0) {
                            while ($roww = $contact_rs->fetch_assoc()) {
                                $name = $roww['name'];
                                $message = $roww['message'];
                                $date = strtotime($roww['date']);

                                $currentTime = time();
                                $timeDifference = $currentTime - $date;

                                if ($timeDifference < 60) {
                                    $timeAgo = $timeDifference . ' seconds ago';
                                } elseif ($timeDifference < 3600) {
                                    $timeAgo = floor($timeDifference / 60) . ' minutes ago';
                                } elseif ($timeDifference < 86400) {
                                    $timeAgo = floor($timeDifference / 3600) . ' hours ago';
                                } elseif ($timeDifference < 31536000) {
                                    $timeAgo = floor($timeDifference / 86400) . ' days ago';
                                } else {
                                    $timeAgo = floor($timeDifference / 31536000) . ' years ago';
                                }

                                echo '<div class="todo" style="width: max-content;">';
                                echo '<p style="margin-bottom: 10px;max-width:980px;width:max-content">' . $message . '</p>';
                                echo '<div class="head1">';
                                echo '<img src="styles/placeholder.png" width="20px" height="20px">';
                                echo '<h3>' . $name . '</h3>';
                                echo '<h6>' . $timeAgo . '</h6>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    } else {
                        echo 'No email parameter found.';
                    }
                    ?>

                    <?php

                    if (isset($_GET["cid"])) {
                        $cid = $_GET["cid"];

                        $reply_rs = Database::search("SELECT reply, date FROM rep_contact WHERE users_email = '$email' AND contact_cid = '$cid'");

                        if ($reply_rs->num_rows > 0) {
                            while ($da = $reply_rs->fetch_assoc()) {
                                $reply = $da['reply'];
                                $day = strtotime($da['date']);

                                $gettime = time();
                                $timestatus = $gettime - $day;
                                
                                if ($timestatus < 60) {
                                    $timeAgo = $timestatus . ' seconds ago';
                                } elseif ($timestatus < 3600) {
                                    $timeAgo = floor($timestatus / 60) . ' minutes ago';
                                } elseif ($timestatus < 86400) {
                                    $timeAgo = floor($timestatus / 3600) . ' hours ago';
                                } elseif ($timestatus < 31536000) {
                                    $timeAgo = floor($timestatus / 86400) . ' days ago';
                                } else {
                                    $timeAgo = floor($timestatus / 31536000) . ' years ago';
                                }

                                echo '<div class="todo" style="width: max-content;margin-left:50%">';
                                echo '<p style="margin-bottom: 10px;max-width:465px;width:max-content;"><i class= "bx bx-share bx-rotate-180" style="color:#000000"></i>' . $reply . '</p>';
                                echo '<div class="head1">';
                                echo '<img src="' . $image_data["path"] . '" width="20px" height="20px" style="border-radius:50%">';
                                echo '<h3> ' . $session_data["fname"] . '  ' . $session_data['lname'] . ' </h3>';
                                echo '<h6>' . $timeAgo . ' </h6>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    } else {
                        echo 'No data found.';
                    }

                    ?>
                </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->


    <script src="scriptt.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</body>

</html>