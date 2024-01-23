<?php

require "connection.php";

$text = $_POST["t"];
$select = $_POST["s"];


$query = "SELECT * FROM `product` ";

if (!empty($text) && $select == 0) {

    $query .= " WHERE `title` LIKE '%" . $text . "%'";
} else if (empty($text) && $select != 0) {

    $query .= " WHERE `category_cat_id`='" . $select . "'";
} else if (!empty($text) && $select != 0) {

    $query .= " WHERE `title` LIKE '%" . $text . "%' AND `category_cat_id`='" . $select . "'";
}

?>

<section id="product-cards">
    <div class="container">
        <div class="row" style="margin-top: 50px;">
            <?php

            if ("0" != $_POST["page"]) {
                $pageno = $_POST["page"];
            } else {
                $pageno = 1;
            }

            $product_rs = Database::search($query);
            $product_num = $product_rs->num_rows;

            $results_per_page = 4;
            $number_of_pages = ceil($product_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " 
                                            OFFSET " . $page_results . " ");

            $selected_num = $selected_rs->num_rows;

            for ($x = 0; $x < $selected_num; $x++) {
                $selected_data = $selected_rs->fetch_assoc();

                $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE 
                                            `product_id`='" . $selected_data["id"] . "'");
                $product_img_data = $product_img_rs->fetch_assoc();

            ?>

                <div class="col-md-3 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <button type="button" class="btn btn-secondary" title="Quick View"><i><img src="styles/views.png" alt="" width="30px"></i></button>
                            <button type="button" class="btn btn-secondary" title="Add to Wishlist"><i><img src="styles/heart.png" alt="" width="30px"></i></button>
                            <button type="button" class="btn btn-secondary" title="Add to Cart"><i><img src="styles/add.png" alt="" width="30px"></i></button>
                        </div>
                        <img src="<?php echo $product_img_data["img_path"]; ?>" alt="">
                        <div class="card-body">
                            <h3><?php echo $selected_data["title"]; ?></h3>
                            <div class="star">
                                <i class="bx bxs-star checked"></i>
                                <i class="bx bxs-star checked"></i>
                                <i class="bx bxs-star checked"></i>
                                <i class="bx bxs-star checked"></i>
                                <i class="bx bxs-star checked"></i>
                            </div>
                            <p><?php echo $selected_data["srt_descri"]; ?></p>
                            <h6>Rs.<?php echo $selected_data["price"]; ?>.00<span><button>Add Cart</button></span></h6>
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

<div class="pagination" id="pagination_section2" style="justify-content: center;">
    <ul>
        <li><a <?php if ($pageno <= 1) {
                    echo ("#");
                } else {
                ?> onclick="basicSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                    } ?> class="prev" style="cursor: pointer;">&lt; Prev</a></li>
        <?php
        for ($y = 1; $y <= $number_of_pages; $y++) {
            if ($y == $pageno) {
                echo "<li class='pageNumber active'><a onclick='basicSearch($y);'>$y</a></li>";
            } else {
                echo "<li class='pageNumber'><a onclick='basicSearch($y);'>$y</a></li>";
            }
        }
        ?>
        <li><a <?php if ($pageno >= $number_of_pages) {
                    echo ("#");
                } else {
                ?> onclick="basicSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                    } ?> class="next" style="cursor: pointer;">Next &gt;</a></li>
    </ul>
</div>