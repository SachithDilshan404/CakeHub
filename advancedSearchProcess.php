<?php 

require "connection.php";

$search_txt = $_POST["t"];
$category = $_POST["cat"];
$from = $_POST["pf"];
$to = $_POST["pt"];
$sort = $_POST["s"];

$query = "SELECT * FROM `product`";
$status = 0;

if ($sort == 0) {
    if (!empty($search_txt)) {
        $query .= " WHERE `title` LIKE '%" . $search_txt . "%'";
        $status = 1;
    }

    if ($category != 0 && $status == 0) {
        $query .= " WHERE `category_cat_id`='" . $category . "'";
        $status = 1;
    } else if ($category != 0 && $status != 0) {
        $query .= " AND `category_cat_id`='" . $category . "'";
    }

    if (!empty($from) && empty($to)) {
        if ($status == 0) {
            $query .= " WHERE `price` >= '" . $from . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` >= '" . $from . "'";
        }
    } else if (empty($from) && !empty($to)) {
        if ($status == 0) {
            $query .= " WHERE `price` <= '" . $to . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` <= '" . $to . "'";
        }
    } else if (!empty($from) && !empty($to)) {
        if ($status == 0) {
            $query .= " WHERE `price` BETWEEN '" . $from . "' AND '" . $to . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` BETWEEN '" . $from . "' AND '" . $to . "'";
        }
    }

} else if ($sort == 1) {

    $query .= " WHERE 1";  // Start with a placeholder condition

    if (!empty($search_txt)) {
        $query .= " AND `title` LIKE '%" . $search_txt . "%'";
        $status = 1;
    }

    if ($category != 0) {
        $query .= " AND `category_cat_id`='" . $category . "'";
    }

    if (!empty($from)) {
        $query .= " AND `price` >= '" . $from . "'";
    }

    if (!empty($to)) {
        $query .= " AND `price` <= '" . $to . "'";
    }

    $query .= " ORDER BY `price` ASC";  // Move ORDER BY clause to the end

}else if ($sort == 2) {
    
    $query .= " WHERE 1";

    if (!empty($search_txt)) {
        $query .= " AND `title` LIKE '%" . $search_txt . "%'";
        $status = 1;
    }

    if ($category != 0) {
        $query .= " AND `category_cat_id`='" . $category . "'";
    }

    if (!empty($from)) {
        $query .= " AND `price` >= '" . $from . "'";
    }

    if (!empty($to)) {
        $query .= " AND `price` <= '" . $to . "'";
    }

    $query .= " ORDER BY `price` DESC";
    
} elseif ($sort == 3) {

    $query .= " WHERE 1";

    if (!empty($search_txt)) {
        $query .= " AND `title` LIKE '%" . $search_txt . "%'";
        $status = 1;
    }

    if ($category != 0) {
        $query .= " AND `category_cat_id`='" . $category . "'";
    }

    if (!empty($from)) {
        $query .= " AND `price` >= '" . $from . "'";
    }

    if (!empty($to)) {
        $query .= " AND `price` <= '" . $to . "'";
    }

    $query .= " ORDER BY `qty` ASC";
   
} elseif ($sort == 4) {

    $query .= " WHERE 1";

    if (!empty($search_txt)) {
        $query .= " AND `title` LIKE '%" . $search_txt . "%'";
        $status = 1;
    }

    if ($category != 0) {
        $query .= " AND `category_cat_id`='" . $category . "'";
    }

    if (!empty($from)) {
        $query .= " AND `price` >= '" . $from . "'";
    }

    if (!empty($to)) {
        $query .= " AND `price` <= '" . $to . "'";
    }

    $query .= " ORDER BY `qty` DESC";
   
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
                ?> onclick="advancedSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                    } ?> class="prev" style="cursor: pointer;">&lt; Prev</a></li>
        <?php
        for ($y = 1; $y <= $number_of_pages; $y++) {
            if ($y == $pageno) {
                echo "<li class='pageNumber active'><a onclick='advancedSearch($y);'>$y</a></li>";
            } else {
                echo "<li class='pageNumber'><a onclick='advancedSearch($y);'>$y</a></li>";
            }
        }
        ?>
        <li><a <?php if ($pageno >= $number_of_pages) {
                    echo ("#");
                } else {
                ?> onclick="advancedSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                    } ?> class="next" style="cursor: pointer;">Next &gt;</a></li>
    </ul>
</div>
