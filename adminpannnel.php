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
} else {
    // Handle error if unable to retrieve admin status
    echo "Error: Unable to retrieve admin status.";
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="shortcut icon" type="image" href="styles/logo.png">
    <title>Admin Pannel | Cakehub.inc</title>

</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxl-redux'></i>
            <span class="text">Admin Pannel</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#" data-tab-id="section1">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" data-tab-id="section2">
                    <i class='bx bxs-shopping-bag-alt'></i>
                    <span class="text">My Store</span>
                </a>
            </li>
            <li>
                <a href="#" data-tab-id="section3">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Analytics</span>
                </a>
            </li>
            <li>
                <a href="#" data-tab-id="section4">
                    <i class='bx bxs-message-dots'></i>
                    <span class="text">Message</span>
                </a>
            </li>
            <li>
                <a href="#" data-tab-id="section5">
                    <i class='bx bxs-group'></i>
                    <span class="text">Users</span>
                </a>
            </li>
            <li>
                <a href="#" data-tab-id="section6">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#" class="logout" onclick="logout()">
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
            <a class="notification" id="openSection8" style="cursor: pointer;">
                <i class='bx bxs-bell'></i>
                <span class="num">5</span>
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
                        <h1>Dashboard</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Admin Pannel</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <ul class="box-info">
                    <li>
                        <i class='bx bxs-calendar-check'></i>
                        <span class="text">
                            <?php
                            $orders_rs = Database::search("SELECT COUNT(*) AS row_count FROM invoice");

                            if ($orders_rs) {
                                // Assuming the result set is correct, you can fetch the count
                                $row = $orders_rs->fetch_assoc(); // Adjust this based on your database library
                                $orders_num = $row['row_count'];

                                // Display the count
                                echo '<h3>' . $orders_num . '</h3>
                                            <p>Total Orders</p>';
                            } else {
                                echo 'Error in the database query';
                            }
                            ?>
                        </span>

                    </li>
                    <li>
                        <i class='bx bxs-group'></i>
                        <span class="text">
                            <?php

                            $user_rs = Database::search("SELECT COUNT(*) AS row_count FROM `users`");

                            if ($user_rs) {
                                // Assuming the result set is correct, you can fetch the count
                                $row = $user_rs->fetch_assoc(); // Adjust this based on your database library
                                $user_num = $row['row_count'];

                                // Display the count
                                echo '<h3>' . $user_num . '</h3>
                                            <p>Users</p>';
                            } else {
                                echo 'Error in the database query';
                            }
                            ?>
                        </span>
                    </li>
                    <li>
                        <i class='bx bxs-dollar-circle'></i>
                        <!-- Assuming you have the HTML structure -->
                        <span class="text">
                            <h3>
                                <?php
                                $total_rs = Database::search("SELECT SUM(total) AS total_sum FROM invoice");
                                if ($total_rs) {
                                    $row = $total_rs->fetch_assoc(); // Adjust this based on your database library
                                    $total_sum = $row['total_sum'];
                                    echo 'Rs.' . number_format($total_sum, 2); // Format the total as currency
                                } else {
                                    echo 'Error in the database query';
                                }
                                ?>
                            </h3>
                            <p>Total Sales</p>
                        </span>

                    </li>
                    <li>
                        <i class='bx bxs-cube'></i>
                        <span class="text">
                            <?php

                            $product_rs = Database::search("SELECT COUNT(*) AS row_count FROM `product`");

                            if ($product_rs) {
                                // Assuming the result set is correct, you can fetch the count
                                $row = $product_rs->fetch_assoc(); // Adjust this based on your database library
                                $product_num = $row['row_count'];

                                // Display the count
                                echo '<h3>' . $product_num . '</h3>
                                            <p>Products</p>';
                            } else {
                                echo 'Error in the database query';
                            }
                            ?>
                        </span>
                    </li>
                    <li>
                        <i class='bx bxs-message-dots'></i>
                        <span class="text">
                            <?php

                            $message_rs = Database::search("SELECT COUNT(*) AS row_count FROM `contact`");

                            if ($message_rs) {
                                // Assuming the result set is correct, you can fetch the count
                                $row = $message_rs->fetch_assoc(); // Adjust this based on your database library
                                $message_num = $row['row_count'];

                                // Display the count
                                echo '<h3>' . $message_num . '</h3>
                                            <p>Messages</p>';
                            } else {
                                echo 'Error in the database query';
                            }
                            ?>
                        </span>
                    </li>
                    <li>
                        <i class='bx bx-message-square-dots'></i>
                        <span class="text">
                            <?php

                            $feedback_rs = Database::search("SELECT COUNT(*) AS row_count FROM `feedback`");

                            if ($feedback_rs) {
                                // Assuming the result set is correct, you can fetch the count
                                $row = $feedback_rs->fetch_assoc(); // Adjust this based on your database library
                                $feedback_num = $row['row_count'];

                                // Display the count
                                echo '<h3>' . $feedback_num . '</h3>
                                            <p>User Feedbacks</p>';
                            } else {
                                echo 'Error in the database query';
                            }
                            ?>
                        </span>
                    </li>
                </ul>


                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Recent Orders</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>QTY</th>
                                    <th>Date Order</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = Database::search("SELECT i.date, i.total, i.qty, u.fname, u.lname, p.path
                                FROM invoice i
                                JOIN users u ON i.users_email = u.email
                                JOIN profile_img p ON u.email = p.users_email
                                ORDER BY i.date DESC
                                LIMIT 2
                                ");

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '<img src="' . $row['path'] . '">';
                                        echo '<p>' . $row['fname'] . ' ' . $row['lname'] . '</p>';
                                        echo '<td>Rs.' . number_format($row['total'], 2) . '</td>';
                                        echo '<td>X' . $row['qty'] . '</td>';
                                        echo '</td>';
                                        echo '<td>' . date('d-m-Y', strtotime($row['date'])) . '</td>';
                                        echo '  <td><span class="status completed">Completed</span></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="3">No records found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="todo">
                        <div class="head">
                            <h3>Active Users</h3>
                            <i class='bx bx-plus'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <ul class="todo-list">
                            <?php
                            $results = Database::search("SELECT u.fname, u.lname, u.is_admin, p.path
                            FROM users u
                            JOIN profile_img p ON u.email = p.users_email");

                            $admins = array();
                            $shoppers = array();

                            if ($results->num_rows > 0) {
                                while ($row = $results->fetch_assoc()) {
                                    $user = '<li class="' . ($row['is_admin'] == 1 ? 'completed' : 'not-completed') . '">';
                                    $user .= '<img src="' . $row['path'] . '" alt="" width="40px" height="40px" style="border-radius:50%">';
                                    $user .= '<h5>' . $row['fname'] . ' ' . $row['lname'] . '</h5>';
                                    $user .= '<p style="font-weight: bold;">' . ($row['is_admin'] == 1 ? 'Admin' : 'Shopper') . '</p>';
                                    $user .= '</li>';

                                    if ($row['is_admin'] == 1) {
                                        array_push($admins, $user);
                                    } else {
                                        array_push($shoppers, $user);
                                    }
                                }
                                foreach ($admins as $adminUser) {
                                    echo $adminUser;
                                }

                                foreach ($shoppers as $shopperUser) {
                                    echo $shopperUser;
                                }
                            } else {
                                echo '<li>No users found.</li>';
                            }
                            ?>
                        </ul>

                    </div>

                </div>
            </div>
            <div id="section2" class="tab-content">
                <div class="head-title">
                    <div class="left">
                        <h1>My Store</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Admin Pannel</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">My Store</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <section id="product-cards">
                    <div class="container">
                        <?php
                        $product_rs = Database::search("SELECT p.id, p.title, p.srt_descri, p.price, p.datetime_added, GROUP_CONCAT(i.img_path) AS img_paths
                        FROM product p
                        JOIN product_img i ON p.id = i.product_id
                        GROUP BY p.id
                        ORDER BY p.datetime_added DESC
                        ");

                        while ($product_data = $product_rs->fetch_assoc()) {
                            $img_paths = explode(',', $product_data['img_paths']);
                        ?>
                            <div class="row" style="margin-top:50px;">
                                <div class="col-md-3 py-3 py-md-0">
                                    <div class="card" style="width: 257px; height:570px;">
                                        <img src="<?php echo $img_paths[0]; ?>" alt="" class="imghh">
                                        <div class="card-body">
                                            <h3><?php echo $product_data["title"]; ?></h3>
                                            <div class="star">
                                                <i class="bx bxs-star checked"></i>
                                                <i class="bx bxs-star checked"></i>
                                                <i class="bx bxs-star checked"></i>
                                                <i class="bx bxs-star checked"></i>
                                                <i class="bx bxs-star checked"></i>
                                            </div>
                                            <p><?php echo $product_data["srt_descri"]; ?></p><br />
                                            <h6>Rs.<?php echo $product_data["price"]; ?>.00 <span><button onclick="sendId(<?php echo $product_data['id']; ?>);">Update</button></span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                </section>
            </div>
            <div id="section3" class="tab-content">
                <div class="head-title">
                    <div class="left">
                        <h1>Analytics</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Admin Pannel</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Analytics</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div style="display:flex">
                    <div class="table-data">
                        <div class="todo">
                            <div class="head">
                                <h3>Summery Of Stock</h3>
                                <i class='bx bx-plus'></i>
                                <i class='bx bx-filter'></i>
                            </div>
                            <ul class="todo-list">
                                <canvas id="stockChart" style="max-width: 400px;"></canvas>
                            </ul>
                        </div>
                    </div>
                    <?php
                    $result_rss = Database::search("SELECT title, qty FROM product");

                    if ($result_rss) {
                        // Initialize arrays to store the product names and quantities
                        $productNames = array();
                        $quantities = array();

                        // Fetch the data and populate the arrays
                        while ($row = mysqli_fetch_assoc($result_rss)) {
                            $productNames[] = $row['title'];
                            $quantities[] = $row['qty'];
                        }

                        // Calculate the total quantity
                        $totalQuantity = array_sum($quantities);

                        // Calculate percentages
                        $percentages = array_map(function ($qty) use ($totalQuantity) {
                            return ($qty / $totalQuantity) * 100;
                        }, $quantities);
                    }
                    $colors = [
                        "#FF5733", "#33FF57", "#337BFF", "#FFD700", "#FF34B3", "#9a3412", "#5eead4", "#fca5a5", "#86198f"
                    ];

                    $data = [
                        'labels' => $productNames,
                        'datasets' => [
                            [
                                'data' => $quantities,
                                'backgroundColor' => $colors,
                            ],
                        ],
                    ];

                    $options = [
                        'plugins' => [
                            'datalabels' => [
                                'formatter' => "function(ctx) {
                                    return ctx.chart.data.labels[ctx.dataIndex] + ': ' + ctx.chart.data.datasets[0].data[ctx.dataIndex] + ' (' + ctx.perc + '%)';
                                }",
                                'color' => '#fff', // Label text color
                            ],
                        ],
                    ];

                    echo "<script>
                        var ctx = document.getElementById('stockChart').getContext('2d');
                        var stockChart = new Chart(ctx, {
                            type: 'pie',
                            data: " . json_encode($data) . ",
                            options: " . json_encode($options) . "
                        });
                    </script>";
                    ?>
                    <div class="table-data" style="margin-left: 10px;">
                        <div class="todo">
                            <div class="head">
                                <h3>Mostly Sold Products</h3>
                                <i class='bx bx-plus'></i>
                                <i class='bx bx-filter'></i>
                            </div>
                            <ul class="todo-list">
                                <canvas id="productPieChart" style="max-width: 400px;"></canvas>
                            </ul>
                        </div>
                        <?php

                        $mostly_rs = Database::search("SELECT p.title AS product_name, COUNT(i.product_id) AS sales_count
                                    FROM invoice AS i
                                    JOIN product AS p ON i.product_id = p.id
                                    GROUP BY i.product_id, p.title
                                    ORDER BY sales_count DESC
                                    LIMIT 10");

                        if ($mostly_rs) {
                            $items = array();
                            $prodcutIds = array();

                            while ($row = mysqli_fetch_array($mostly_rs)) {
                                $items[] = $row['product_name'];
                                $prodcutIds[] = $row['sales_count'];
                            }

                            $totalCount = array_sum($prodcutIds);

                            $percentages_new = array_map(function ($pid) use ($totalCount) {
                                return ($pid / $totalCount) * 100;
                            }, $prodcutIds);
                        }
                        $colorsss = [
                            "#FF34B3", "#33FF57", "#FFD700", "#5eead4", "#fca5a5", "#86198f", "#337BFF"
                        ];

                        $dataa = [
                            'labels' => $items,
                            'datasets' => [
                                [
                                    'data' => $prodcutIds,
                                    'backgroundColor' => $colorsss,
                                ],
                            ],
                        ];

                        $optionsss = [
                            'plugins' => [
                                'datalabels' => [
                                    'formatter' => "function(ctx) {
                                        return ctx.chart.data.labels[ctx.dataIndex] + ': ' + ctx.chart.data.datasets[0].data[ctx.dataIndex] + ' (' + ctx.perc + '%)';
                                    }",
                                    'color' => '#fff',
                                ],
                            ],
                        ];

                        echo "<script>
                        var ctx = document.getElementById('productPieChart').getContext('2d');
                        var productPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: " . json_encode($dataa) . ",
                            options: " . json_encode($optionsss) . "
                        });
                        </script>";
                        ?>
                    </div>
                </div>
                <div style="display:flex">
                    <div class="table-data">
                        <div class="todo">
                            <div class="head">
                                <h3>Customer Feedbacks</h3>
                                <i class='bx bx-plus'></i>
                                <i class='bx bx-filter'></i>
                            </div>
                            <ul class="todo-list">
                                <canvas id="feedbackPieChart" style="max-width: 400px;"></canvas>
                            </ul>
                        </div>
                        <?php

                        $feedback = Database::search("SELECT f_staus_idf_staus, COUNT(*) AS count FROM feedback GROUP BY f_staus_idf_staus");

                        $positiveCount = 0;
                        $negativeCount = 0;

                        while ($row = $feedback->fetch_assoc()) {
                            if ($row['f_staus_idf_staus'] == 1) {
                                $positiveCount = $row['count'];
                            } elseif ($row['f_staus_idf_staus'] == 2) {
                                $negativeCount = $row['count'];
                            }
                        }
                        $totalFeedbacks = $positiveCount + $negativeCount;
                        $positivePercentage = ($positiveCount / $totalFeedbacks) * 100;
                        $negativePercentage = ($negativeCount / $totalFeedbacks) * 100;

                        $da = [
                            'labels' => ["Positive Feedback", "Negative Feedback"],
                            'datasets' => [
                                [
                                    'data' => [$positivePercentage, $negativePercentage],
                                    'backgroundColor' => ["#16a34a", "#dc2626"],
                                ],
                            ],
                        ];

                        $opt = [
                            'plugins' => [
                                'datalabels' => [
                                    'formatter' => "function(ctx) {
                                        return ctx.chart.data.labels[ctx.dataIndex] + ': ' + ctx.chart.data.datasets[0].data[ctx.dataIndex] + ' (' + ctx.perc + '%)';
                                    }",
                                    'color' => '#fff',
                                ],
                            ],
                        ];

                        echo "<script>
                        var ctx = document.getElementById('feedbackPieChart').getContext('2d');
                        var feedbackPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: " . json_encode($da) . ",
                            options: " . json_encode($opt) . "
                        });
                        </script>";
                        ?>
                    </div>
                    <div class="table-data" style="margin-left: 10px;">
                        <div class="todo">
                            <div class="head">
                                <h3>Users</h3>
                                <i class='bx bx-plus'></i>
                                <i class='bx bx-filter'></i>
                            </div>
                            <ul class="todo-list">
                                <canvas id="userPieChart" style="max-width: 400px;"></canvas>
                            </ul>
                        </div>
                        <?php

                        $user_ss = Database::search("SELECT is_admin, COUNT(*) AS count FROM users GROUP BY is_admin");

                        $Administrator = 0;
                        $Customer = 0;

                        while ($row = $user_ss->fetch_assoc()) {
                            if ($row['is_admin'] == 1) {
                                $Administrator = $row['count'];
                            } elseif ($row['is_admin'] == 0) {
                                $Customer = $row['count'];
                            }
                        }
                        $totalusers = $Administrator + $Customer;
                        $AdminPercentage = ($Administrator / $totalusers) * 100;
                        $customerPercentage = ($Customer / $totalusers) * 100;

                        $dau = [
                            'labels' => ["Admin Users", "Shoppers"],
                            'datasets' => [
                                [
                                    'data' => [$AdminPercentage, $customerPercentage],
                                    'backgroundColor' => ["#3C91E6", "#FD7238"],
                                ],
                            ],
                        ];

                        $optu = [
                            'plugins' => [
                                'datalabels' => [
                                    'formatter' => "function(ctx) {
                                        return ctx.chart.data.labels[ctx.dataIndex] + ': ' + ctx.chart.data.datasets[0].data[ctx.dataIndex] + ' (' + ctx.perc + '%)';
                                    }",
                                    'color' => '#fff',
                                ],
                            ],
                        ];

                        echo "<script>
                        var ctx = document.getElementById('userPieChart').getContext('2d');
                        var userPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: " . json_encode($dau) . ",
                            options: " . json_encode($optu) . "
                        });
                        </script>";
                        ?>
                    </div>
                </div>

                <div class="table-data">
                    <div class="todo">
                        <div class="head">
                            <h3>Top Income By Day</h3>
                            <i class='bx bx-plus'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <ul class="todo-list">
                            <canvas id="incomeChart" width="400" height="400"></canvas>
                        </ul>
                        <?php
                        $currentDate = date("Y-m-d");

                        // Query to get earnings by day
                        $income = Database::search("SELECT DATE(date) AS sales_date, SUM(total) AS total_earnings
                        FROM invoice
                        WHERE DATE(date) <= '$currentDate'
                        GROUP BY DATE(date)
                        ORDER BY sales_date");

                        $dates = array();
                        $earnings = array();

                        // Initialize a date range starting from a specific date
                        $startDate = '2023-10-15'; // Adjust the start date as needed
                        $currentDateObj = new DateTime($currentDate);
                        $startDateObj = new DateTime($startDate);

                        // Loop through the income data and populate the dates and earnings arrays
                        while ($row = mysqli_fetch_array($income)) {
                            $dates[] = $row['sales_date'];
                            $earnings[] = $row['total_earnings'];

                            // Move the current date in the date range
                            while ($startDateObj < $currentDateObj) {
                                $startDateObj->modify('+1 day');
                                $date = $startDateObj->format("Y-m-d");

                                // If the date is not in the income data, add it with earnings of 0
                                if (!in_array($date, $dates)) {
                                    $dates[] = $date;
                                    $earnings[] = 0;
                                }
                            }
                        }

                        $tot = array_sum($earnings);

                        $percent = array_map(function ($tol) use ($tot) {
                            return ($tol / $tot) * 100;
                        }, $earnings);

                        $bgcolor = ["#fcd34d"];
                        $bordercolor = ["#b45309"];

                        $dat = [
                            'labels' => $dates,
                            'datasets' => [
                                [
                                    'label' => "Total Earnings",
                                    'data' => $earnings,
                                    'backgroundColor' => $bgcolor,
                                    'borderColor' => $bordercolor,
                                    'borderWidth' => 1
                                ],
                            ],
                        ];

                        $opt = [
                            'options' => [
                                'scales' => [
                                    'y' => [
                                        'beginAtZero' => true
                                    ],
                                ],
                            ],
                        ];

                        echo "
                        <script>
                        var ctx = document.getElementById('incomeChart').getContext('2d');
                        var incomeChart = new Chart(ctx, {
                            type: 'bar',
                            data: " . json_encode($dat) . ",
                            options: " . json_encode($opt) . "
                        });
                        </script>
                        ";
                        ?>

                    </div>
                </div>
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Recent Orders</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>QTY</th>
                                    <th>Date Order</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = Database::search("SELECT i.date, i.total, i.qty, u.fname, u.lname, p.path
                                FROM invoice i
                                JOIN users u ON i.users_email = u.email
                                JOIN profile_img p ON u.email = p.users_email
                                ORDER BY i.date DESC
                               
                                ");

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '<img src="' . $row['path'] . '">';
                                        echo '<p>' . $row['fname'] . ' ' . $row['lname'] . '</p>';
                                        echo '<td>Rs.' . number_format($row['total'], 2) . '</td>';
                                        echo '<td>X' . $row['qty'] . '</td>';
                                        echo '</td>';
                                        echo '<td>' . date('d-m-Y', strtotime($row['date'])) . '</td>';
                                        echo '  <td><span class="status completed">Completed</span></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="3">No records found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="section4" class="tab-content">
                <div class="head-title">
                    <div class="left">
                        <h1>Messages</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Admin Pannel</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Messages</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Recent Messages</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Date Of Messaged</th>
                                    <th>Case Id</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $contact_rs = Database::search("SELECT cid,name,email,date FROM contact");

                                if ($contact_rs->num_rows > 0) {
                                    while ($roww = $contact_rs->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '<img src="styles/placeholder.png">';
                                        echo '<p>' . $roww['name'] . '</p>';
                                        echo '</td>';
                                        echo '<td>' . $roww['email'] . '</td>';
                                        echo '<td>' . date('d-m-Y', strtotime($roww['date'])) . '</td>';
                                        echo '<td>' . $roww['cid']   . '</td>';
                                        echo '<td><span class="status pending" data-email="' . $roww['email'] . '" data-cid="' . $roww['cid'] . '" onclick="respondToEmail(this);">Respond</span> &nbsp;<i class="bx bx-trash" style="color: red; font-size:20px;" onclick="deleterep(' . $roww['cid'] . ');"></i></td>';
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="section5" class="tab-content">
                <div class="head-title">
                    <div class="left">
                        <h1>Users</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Admin Pannel</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Users</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Moderator Team</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Member Since</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.status, u.joined_date, p.path
                                FROM users u
                                JOIN profile_img p ON u.email = p.users_email
                                WHERE u.is_admin = 1");

                                if ($results->num_rows > 0) {
                                    while ($row = $results->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '<img src="' . $row['path'] . '" alt="" width="40px" height="40px" style="border-radius:50%">';
                                        echo '<p>' . $row['fname'] . ' ' . $row['lname'] . '</p>';
                                        echo '</td>';
                                        echo '<td>' . $row['email'] . '</td>';
                                        echo '<td>' . date('d-m-Y', strtotime($row['joined_date'])) . '</td>';
                                        echo '<td>';
                                        echo '<select class="status completed" id="actionSelect">';
                                        echo '<option value="option0">Choose Action</option>';
                                        if ($row['status'] == 1) {
                                            echo '<option value="option1">Ban User</option>';
                                        } elseif ($row['status'] == 0) {
                                            echo '<option value="option4">Unban User</option>';
                                        }
                                        echo '<option value="option2">Change Password</option>';
                                        if ($row['is_admin'] == 1) {
                                            echo '<option value="option5">Remove as Admin</option>';
                                        } elseif ($row['is_admin'] == 0) {
                                            echo '<option value="option3">Make as Admin</option>';
                                        }
                                        echo '</select>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="order">
                        <div class="head">
                            <h3>Customers</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Member Since</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION["u"])) {
                                    $session_data = $_SESSION["u"];
                                }
                                $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.status, u.joined_date, p.path
                                FROM users u
                                JOIN profile_img p ON u.email = p.users_email
                                WHERE u.is_admin = 0");

                                if ($results->num_rows > 0) {
                                    while ($row = $results->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '<img src="' . $row['path'] . '" alt="" width="40px" height="40px" style="border-radius:50%">';
                                        echo '<p>' . $row['fname'] . ' ' . $row['lname'] . '</p>';
                                        echo '</td>';
                                        echo '<td>' . $row['email'] . '</td>';
                                        echo '<td>' . date('d-m-Y', strtotime($row['joined_date'])) . '</td>';
                                        echo '<td>';
                                        echo '<select class="status pending" id="actionSelect1">';
                                        echo '<option value="option0">Choose Action</option>';
                                        if ($row['status'] == 1) {
                                            echo '<option value="option1">Ban User</option>';
                                        } elseif ($row['status'] == 0) {
                                            echo '<option value="option4">Unban User</option>';
                                        }
                                        echo '<option value="option2">Change Password</option>';
                                        if ($row['is_admin'] == 1) {
                                            echo '<option value="option5">Remove as Admin</option>';
                                        } elseif ($row['is_admin'] == 0) {
                                            echo '<option value="option3">Make as Admin</option>';
                                        }
                                        echo '</select>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php
            $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.joined_date, p.path FROM users u JOIN profile_img p ON u.email = p.users_email WHERE u.is_admin = 1");

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {

                    echo '<div class="modal" id="myModal">';
                    echo '<div class="modal-content">';
                    echo '<span class="close" id="closeModal">&times;</span>';
                    echo '<h2>Ban User</h2>';
                    echo '<p>Enter your password to confirm the ban:</p>';
                    echo '<input class="text" type="password" id="passwordInput" placeholder="Your Password">';
                    echo '<div class="modal-buttons">';
                    echo '<button id="cancelBanButton">Cancel</button>';
                    echo '<button id="proceedBanButton" onclick="banUser(\'' . $row['email'] . '\',\'' . $session_data['email'] . '\')">Proceed</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>

            <?php

            $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.joined_date, p.path
                FROM users u
                JOIN profile_img p ON u.email = p.users_email
                WHERE u.is_admin = 1");

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {

                    echo '<div class="modal" id="psModal">';
                    echo '<div class="modal-content">';
                    echo '<span class="close" id="closeModal1">&times;</span>';
                    echo '<h2>Change User Password</h2>';
                    echo '<p style="margin-right: 60px;">Enter Admin Password:</p>';
                    echo '<input class="text" type="password" id="pas" placeholder="Your Password">';
                    echo '<p style="margin-right: 125px;">New Password:</p>';
                    echo '<input class="text" type="password" id="pas1" placeholder="New Password">';
                    echo '<p style="margin-right: 105px;">Retype Password:</p>';
                    echo '<input class="text" type="password" id="pas2" placeholder="Retype new Password">';
                    echo '<div class="modal-buttons">';
                    echo '<button id="cancelBanButton1">Cancel</button>';
                    echo '<button id="proceedBanButton1" onclick="changepass1(\'' . $row['email'] . '\',\'' . $session_data['email'] . '\')">Proceed</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

            ?>

            <?php

            $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.joined_date, p.path
                FROM users u
                JOIN profile_img p ON u.email = p.users_email
                WHERE u.is_admin = 1");

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {

                    echo '<div class="modal" id="remodal">';
                    echo '<div class="modal-content">';
                    echo '<span class="close" id="closeModal">&times;</span>';
                    echo '<h2>Remove as Admin User</h2>';
                    echo '<p>Enter your password to confirm the Admin:</p>';
                    echo '<input class="text" type="password" id="pass2" placeholder="Your Password">';
                    echo '<div class="modal-buttons">';
                    echo '<button id="cancelBanButton2">Cancel</button>';
                    echo '<button id="proceedBanButton2" onclick="remadmin(\'' . $row['email'] . '\',\'' . $session_data['email'] . '\')">Proceed</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

            ?>

            <?php

            $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.joined_date, p.path
                FROM users u
                JOIN profile_img p ON u.email = p.users_email
                WHERE u.is_admin = 1");

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {

                    echo '<div class="modal" id="unmodal">';
                    echo '<div class="modal-content">';
                    echo '<span class="close" id="closeModal">&times;</span>';
                    echo '<h2>UnBan User</h2>';
                    echo '<p>Enter your password to confirm the unban:</p>';
                    echo '<input class="text" type="password" id="passwordInput3" placeholder="Your Password">';
                    echo '<div class="modal-buttons">';
                    echo '<button id="cancelBanButton3">Cancel</button>';
                    echo '<button id="proceedBanButton3" onclick="unban1(\'' . $row['email'] . '\',\'' . $session_data['email'] . '\')">Proceed</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>

            <!-- section 2  -->
            <?php

            $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.joined_date, p.path
                FROM users u
                JOIN profile_img p ON u.email = p.users_email
                WHERE u.is_admin = 0");

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {

                    echo '<div class="modal" id="BanModal1">';
                    echo '<div class="modal-content">';
                    echo '<span class="closee" id="closeModal">&times;</span>';
                    echo '<h2>Ban User</h2>';
                    echo '<p>Enter your password to confirm the ban:</p>';
                    echo '<input class="text" type="password" id="passwordInput1" placeholder="Your Password">';
                    echo '<div class="modal-buttons">';
                    echo '<button id="cancelBanButton4">Cancel</button>';
                    echo '<button id="proceedBanButton4" onclick="ban(\'' . $row['email'] . '\',\'' . $session_data['email'] . '\')">Proceed</button>';
                    echo '</div>';
                    echo ' </div>';
                    echo '</div>';
                }
            }
            ?>

            <?php

            $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.joined_date, p.path
                FROM users u
                JOIN profile_img p ON u.email = p.users_email
                WHERE u.is_admin = 0");

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {

                    echo '<div class="modal" id="PasssModal1">';
                    echo '<div class="modal-content">';
                    echo '<span class="closee" id="closeModal1">&times;</span>';
                    echo '<h2>Change User Password</h2>';
                    echo '<p style="margin-right: 60px;">Enter Admin Password:</p>';
                    echo '<input class="text" type="password" id="pas3" placeholder="Your Password">';
                    echo '<p style="margin-right: 125px;">New Password:</p>';
                    echo '<input class="text" type="password" id="pas4" placeholder="New Password">';
                    echo '<p style="margin-right: 105px;">Retype Password:</p>';
                    echo '<input class="text" type="password" id="pas5" placeholder="Retype New Password">';
                    echo '<div class="modal-buttons">';
                    echo '<button id="cancelBanButton5">Cancel</button>';
                    echo '<button id="proceedBanButton5" onclick="changepass(\'' . $row['email'] . '\',\'' . $session_data['email'] . '\')">Proceed</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

            ?>

            <?php

            $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.joined_date, p.path
                FROM users u
                JOIN profile_img p ON u.email = p.users_email
                WHERE u.is_admin = 0");

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {

                    echo '<div class="modal" id="AdminModal1">';
                    echo '<div class="modal-content">';
                    echo '<span class="closee" id="closeModal">&times;</span>';
                    echo '<h2>Add a Admin User</h2>';
                    echo '<p>Enter your password to confirm the Admin:</p>';
                    echo '<input class="text" type="password" id="password1" placeholder="Your Password">';
                    echo '<div class="modal-buttons">';
                    echo '<button id="cancelBanButton6">Cancel</button>';
                    echo '<button id="proceedBanButton6" onclick="adadmin(\'' . $row['email'] . '\',\'' . $session_data['email'] . '\')">Proceed</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }

            ?>

            <?php

            $results = Database::search("SELECT u.fname, u.lname, u.is_admin, u.email, u.joined_date, p.path
                FROM users u
                JOIN profile_img p ON u.email = p.users_email
                WHERE u.is_admin = 0");

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {

                    echo '<div class="modal" id="unbanmodal1">';
                    echo '<div class="modal-content">';
                    echo '<span class="closee" id="closeModal">&times;</span>';
                    echo '<h2>UnBan User</h2>';
                    echo '<p>Enter your password to confirm the ban:</p>';
                    echo '<input class="text" type="password" id="passwordInput2" placeholder="Your Password">';
                    echo '<div class="modal-buttons">';
                    echo '<button id="cancelBanButton7">Cancel</button>';
                    echo '<button id="proceedBanButton7" onclick="unban(\'' . $row['email'] . '\',\'' . $session_data['email'] . '\')">Proceed</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
            <div id="section6" class="tab-content">
                <div class="head-title">
                    <div class="left">
                        <h1>Settings</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Admin Pannel</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Store Settings</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <table>
                            <thead>
                                <th>Action</th>
                                <th>Admin's Email</th>
                                <th>Proceed</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <i class='bx bxs-layer-plus bx-sm'></i>
                                        <p>List A Product</p>
                                    </td>
                                    <td><?php echo $session_data['email'] ?></td>
                                    <td><span class="status completed" onclick="window.location='listitems.php'">List A Product</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class='bx bx-layer-plus bx-sm'></i>
                                        <p>Add a New Categeory</p>
                                    </td>
                                    <td><?php echo $session_data['email'] ?></td>
                                    <td><span class="status process" id="openModalButton">Add a Categeory</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>System Settings</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <table>
                            <?php
                            $query = Database::search("SELECT SUM(data_length + index_length) AS size FROM information_schema.tables WHERE table_schema = 'cakehub'");
                            $result = $query->fetch_assoc();
                            $sizeInBytes = $result['size'];

                            function formatSize($sizeInBytes)
                            {
                                $units = array('B', 'KB', 'MB', 'GB');
                                $i = 0;

                                while ($sizeInBytes > 1024 && $i < 3) {
                                    $sizeInBytes /= 1024;
                                    $i++;
                                }

                                // Use number_format with the appropriate decimal precision
                                if ($i === 2) {
                                    return number_format($sizeInBytes, 1) . ' ' . $units[$i];
                                } elseif ($i === 3) {
                                    return number_format($sizeInBytes, 2) . ' ' . $units[$i];
                                } else {
                                    return number_format($sizeInBytes, 0) . ' ' . $units[$i];
                                }
                            }

                            $formattedSize = formatSize($sizeInBytes);
                            ?>
                            <tbody>
                                <tr>
                                    <td>
                                        <i class='bx bxs-cloud bx-sm'></i>
                                        <p>System Usage</p>
                                    </td>
                                    <td><?php echo $formattedSize ?> of 5GB used</td>
                                    <td><?php echo date("d/m/Y"); ?></td>
                                    <td><span class="status completed" id="openSection7">See Usage</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class='bx bxs-cloud-download bx-sm'></i>
                                        <p>Download System Data</p>
                                    </td>
                                    <td><?php echo $formattedSize ?> of 5GB used</td>
                                    <td><?php echo date("d/m/Y"); ?></td>
                                    <td><span class="status process" id="backupmodal1">Download Data</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class='bx bxs-cloud-upload bx-sm'></i>
                                        <p>BackUp System Data</p>
                                    </td>
                                    <td><?php echo $formattedSize ?> of 5GB used</td>
                                    <td><?php echo date("d/m/Y"); ?></td>
                                    <td><span class="status pending" id="cloudmodal1">Upload Data</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="section7" class="tab-content">
                <div class="head-title">
                    <div class="left">
                        <h1>Settings</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Admin Pannel</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a href="#">Settings</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Storage Usage</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
                // Your database query
                $query = Database::search("SELECT TABLE_NAME, SUM(data_length + index_length) AS size FROM information_schema.tables WHERE table_schema = 'cakehub' GROUP BY TABLE_NAME");

                if ($query) {
                    $tables = array();
                    $sizes = array();

                    while ($row = $query->fetch_assoc()) {
                        $tables[] = $row['TABLE_NAME']; // Use uppercase column name
                        $sizes[] = (float) $row['size'];  // Use uppercase column name
                    }

                    // Encode data into JSON for use in JavaScript
                    $tablesJSON = json_encode($tables);
                    $sizesJSON = json_encode($sizes);
                } else {
                    echo "Database query failed.";
                }
                ?>
                <div class="table-data">
                    <div class="todo">
                        <div class="head">
                            <h3>Summery Of Storage Usage</h3>
                            <i class='bx bx-plus'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <ul class="todo-list">
                            <canvas id="tableChart" width="800" height="400"></canvas>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="section8" class="tab-content">
                <div class="head-title">
                    <div class="left">
                        <h1>Notifications</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Admin Pannel</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Notifications</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-data">
                    <div class="todo">
                        <div class="head">
                            <h3>Recent Notifications</h3>
                            <i class='bx bx-plus'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <ul class="todo-list">
                            <?php 
                            $user_rss = Database::search("SELECT fname, lname FROM users ORDER BY joined_date DESC LIMIT 1");
                            if ($user_rss->num_rows > 0){
                                $rowww = $user_rss->fetch_assoc();
                                $fname = $rowww['fname'];
                                $lname = $rowww['lname'];
                            }
                            ?>
                            <li class="completed">
                                <p><b><?php echo$rowww['fname'];?> <?php echo$rowww['lname'];?></b> Registered as new user</p>
                                <i class='bx bxs-user-plus'></i> 
                            </li>
                            <?php 
                            $invoice = Database::search("SELECT users_email FROM invoice ORDER BY date DESC LIMIT 1");
                            if ($invoice->num_rows > 0){
                                $ro = $invoice->fetch_assoc();
                                $userEmail = $ro['users_email'];

                                $users = Database::search("SELECT fname,lname FROM users WHERE email = '$userEmail'");
                                if ($users->num_rows > 0) {
                                    $use = $users->fetch_assoc();
                                    $fnames = $use['fname'];
                                    $laname = $use['lname'];
                                }
                            }
                            ?>
                            <li class="completed">
                                <p><b><?php echo$fnames?> <?php echo$laname?></b> Placed new Order</p>
                                <i class='bx bx-checkbox-checked'></i> 
                            </li>
                            <?php 
                            $feed = Database::search("SELECT users_email FROM feedback ORDER BY f_date DESC LIMIT 1");
                            if ($feed->num_rows > 0){
                                $r = $feed->fetch_assoc();
                                $userEmail = $r['users_email'];

                                $us = Database::search("SELECT fname,lname FROM users WHERE email = '$userEmail'");
                                if ($us->num_rows > 0) {
                                    $userr = $us->fetch_assoc();
                                    $fanames = $userr['fname'];
                                    $lanames = $userr['lname'];
                                }
                            }
                            ?>
                            <li class="completed">
                                <p><b><?php echo$fanames?> <?php echo$lanames?></b> Given Feedback</p>
                                <i class='bx bx-heart-circle'></i>
                            </li>
                            <?php 
                            
                            $like = Database::search("SELECT users_email FROM `like` ORDER BY likeid DESC LIMIT 1");
                            if ($like->num_rows > 0) {
                                $likers = $like->fetch_assoc();
                                $Email = $likers["users_email"];

                                $usw = Database::search("SELECT fname, lname FROM users WHERE email = '$userEmail'");
                                if ($usw->num_rows > 0) {
                                    $usert = $usw->fetch_assoc();
                                    
                                }
                            }
                            ?>        
                            <li class="completed">
                                <p><b><?php echo$usert['fname']?> <?php echo$usert['lname']?></b> Liked Feedback</p>
                                <i class='bx bxs-heart'></i>
                            </li>
                            <?php 
                            $contact = Database::search("SELECT name FROM contact ORDER BY date DESC LIMIT 1");
                            if ($contact->num_rows > 0){
                                $out = $contact->fetch_assoc();    
                            }
                            ?>
                            <li class="completed">
                                <p><b><?php echo $out['name']?></b> Contacted You</p>
                                <i class='bx bxs-phone-incoming'></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Modals -->
            <div class="modal" id="ListModal">
                <div class="modal-content">
                    <span class="closee" id="closeModal">&times;</span>
                    <h2>Add a Categeory</h2>
                    <p>Enter your password to confirm the Admin:</p>
                    <input class="text" type="password" id="password34" placeholder="Your Password">
                    <p style="margin-right: 20px;">Enter your Categeory Name:</p>
                    <input class="text" type="text" id="cat" placeholder="Your Category Name">
                    <div class="modal-buttons">
                        <button id="cancel">Cancel</button>
                        <button id="process" onclick="addcat('<?php echo $session_data['email'] ?>');">Proceed</button>
                    </div>
                </div>
            </div>
            <div class="modal" id="backupmodal">
                <div class="modal-content">
                    <span class="closee" id="closeModal">&times;</span>
                    <h2>Download System Data</h2>
                    <p>Enter your password to confirm the Admin:</p>
                    <input class="text" type="password" id="password9" placeholder="Your Password">
                    <div class="modal-buttons">
                        <button id="cancel1">Cancel</button>
                        <button id="process45" onclick="downdata('<?php echo $session_data['email'] ?>');">Proceed</button>
                    </div>
                </div>
            </div>
            <div class="modal" id="cloudmodal">
                <div class="modal-content">
                    <span class="closee" id="closeModal">&times;</span>
                    <h2>Upload System Data</h2>
                    <p>Enter your password to confirm the Admin:</p>
                    <input class="text" type="password" id="password09" placeholder="Your Password">
                    <div class="modal-buttons">
                        <button id="cancel2">Cancel</button>
                        <button id="process55" onclick="updata('<?php echo $session_data['email'] ?>');">Proceed</button>
                    </div>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="scriptt.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
        // Your data
        var tableNames = <?php echo json_encode($tables); ?>;
        var tableSizesInBytes = <?php echo json_encode($sizes); ?>;

        // Calculate the total storage usage in bytes
        var totalStorageInBytes = tableSizesInBytes.reduce((total, size) => total + size, 0);

        // Define colors for each table (you can add more if needed)
        var tableColors = ['#FF5733', '#FFBF00', '#33FF57', '#3399FF', '#AA33FF', '#fcd34d', '#34d399', '#1e3a8a', '#a78bfa', '#f43f5e', '#14b8a6', '#9a3412', '#bbf7d0', '#22d3ee', '#93c5fd', '#6d28d9', '#f9a8d4', '#6ee7b7'];

        // Calculate free space (5GB - total storage usage)
        var freeSpaceInGB = (5 * 1024 * 1024 * 1024 - totalStorageInBytes) / (1024 * 1024); // Convert to GB

        // Function to format sizes
        function formatSize(sizeInBytes) {
            var sizes = ['B', 'KB', 'MB', 'GB'];
            var i = 0;

            while (sizeInBytes >= 1024 && i < sizes.length - 1) {
                sizeInBytes /= 1024;
                i++;
            }

            return sizeInBytes.toFixed(2) + ' ' + sizes[i];
        }

        // Create data for the pie chart
        var data = [];
        for (var i = 0; i < tableNames.length; i++) {
            data.push({
                label: tableNames[i],
                value: tableSizesInBytes[i] / 1024, // Convert to KB
                color: tableColors[i],
            });
        }

        // Add free space to the data in GB
        data.push({
            label: 'Free Space',
            value: freeSpaceInGB,
            color: '#00FF00', // Green color for free space
        });

        // Create the chart
        var ctx = document.getElementById('tableChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.map(item => item.label),
                datasets: [{
                    data: data.map(item => item.value),
                    backgroundColor: data.map(item => item.color),
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataIndex = tooltipItem.index;
                            var value = data.datasets[0].data[dataIndex];
                            return data.labels[dataIndex] + ': ' + (data.labels[dataIndex] === 'Free Space' ? value.toFixed(2) + ' GB' : formatSize(value) + ' KB');
                        }
                    }
                }
            }
        });
    </script>


</body>

</html>