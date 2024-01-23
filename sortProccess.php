<?php

session_start();
require "connection.php";

$email = $_SESSION["u"]["email"];

$search = $_POST["s"];
$time = $_POST["t"];
$price = $_POST["p"];
$cata = $_POST["c"];

$query = "SELECT * FROM `product` WHERE `users_email`='" . $email . "' ";

if (!empty($search)) {
    $query .= " AND `title` LIKE '%" . $search . "%' ";
}

if ($cata != "0") {
    $query .= " AND `category_cat_id`='" . $cata . "'";
}

if ($time != "0") {
    if ($time == "1") {
        $query .= " ORDER BY `datetime_added` DESC";
    } else if ($time == "2") {
        $query .= " ORDER BY `datetime_added` ASC";
    }
}

if ($price != "0") {
    if ($price == "1") {
        $query .= " ORDER BY `price` DESC";
    } else if ($price == "2") {
        $query .= " ORDER BY `price` ASC";
    }
}

if ($time != "0" && $price != "0") {
    if ($price == "1") {
        $query .= " , `price` DESC";
    } else if ($price == "2") {
        $query .= " , `price` ASC";
    }
}
?>

<section id="product-cards">
    <div class="container">
        <?php

        if ("0" != $_POST["page"]) {
            $pageno = $_POST["page"];
        } else {
            $pageno = 1;
        }

        $product_rs = Database::search($query);
        $product_num = $product_rs->num_rows;

        $results_per_page = 6;
        $number_of_pages = ceil($product_num / $results_per_page);

        $page_results = ($pageno - 1) * $results_per_page;
        $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

        $selected_num = $selected_rs->num_rows;

        for ($x = 0; $x < $selected_num; $x++) {
            $selected_data = $selected_rs->fetch_assoc();

        ?>

            <div class="row" style="margin-top:50px;">
                <div class="col-md-3 py-3 py-md-0">
                    <div class="card" style="width: 257px; height:570px;">
                        <?php

                        $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $selected_data["id"] . "'");
                        $product_img_data = $product_img_rs->fetch_assoc();


                        ?>
                        <img src="<?php echo $product_img_data["img_path"]; ?>" alt="" class="imghh">
                        <div class="card-body">
                            <h3><?php echo $selected_data["title"]; ?></h3>
                            <div class="star">
                                <i class="bx bxs-star checked"></i>
                                <i class="bx bxs-star checked"></i>
                                <i class="bx bxs-star checked"></i>
                                <i class="bx bxs-star "></i>
                                <i class="bx bxs-star "></i>
                            </div>
                            <p><?php echo $selected_data["srt_descri"]; ?></p> <br />
                            <h6>Rs.<?php echo $selected_data["price"]; ?>.00 <span><button onclick="sendId(<?php echo $selected_data['id']; ?>);">Update</button></span></h6>
                        </div>

                    </div>
                </div>
            </div>

        <?php
        }

        ?>
    </div>
</section>
    <br />
    <div class="pagination" id="pagination_section2">
        <ul>
            <li><a <?php if ($pageno <= 1) {
                                echo ("#");
                            } else {
                                ?>
                                onclick="sort(<?php echo ($pageno - 1) ?>);"
                                <?php
                            } ?> class="prev">&lt; Prev</a></li>
            <?php
            for ($y = 1; $y <= $number_of_pages; $y++) {
                if ($y == $pageno) {
                    echo "<li class='pageNumber active'><a onclick='sort($y);'>$y</a></li>";
                } else {
                    echo "<li class='pageNumber'><a onclick='sort($y);'>$y</a></li>";
                }
            }
            ?>
            <li><a <?php if ($pageno >= $number_of_pages) {
                                echo ("#");
                            } else {
                                ?>
                                onclick="sort(<?php echo ($pageno + 1) ?>);"
                                <?php
                            } ?> class="next">Next &gt;</a></li>
        </ul>
    </div>