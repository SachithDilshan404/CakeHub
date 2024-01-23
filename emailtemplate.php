<?php

session_start();

require "connection.php";

if (isset($_SESSION["u"])) {
    $umail = $_SESSION["u"]["email"];
    $pid = isset($_GET["id"]) ? $_GET["id"] : null;

    if (!$pid) {
        // Redirect to home.php if $pid is not set or empty
        header("Location: home.php");
        exit();
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php

        $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $pid . "'");
        $invoice_data = $invoice_rs->fetch_assoc();

        ?>
        <title>Receipt No: #<?php echo $invoice_data["id"]; ?> | Cake Hub</title>
        <link rel="shortcut icon" type="image" href="styles/logo.png">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
        </style>
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <style>
            .btn-grad {
                background-image: linear-gradient(to right, #fc00ff 0%, #00dbde 51%, #fc00ff 100%);
                margin: 10px;
                padding: 15px 45px;
                text-align: center;
                text-transform: uppercase;
                transition: 0.5s;
                background-size: 200% auto;
                color: white;
                box-shadow: 0 0 20px #eee;
                border-radius: 10px;
                display: block;
                cursor: pointer;
                border-color: transparent;
                font-weight: bold;
            }

            .btn-grad:hover {
                background-position: right center;
                /* change the direction of the change here */
                color: #fff;
                text-decoration: none;
            }
        </style>
        <style>
            .btn-grad1 {
                background-image: linear-gradient(to right, #00c6ff 0%, #0072ff 51%, #00c6ff 100%);
                margin: 10px;
                padding: 15px 45px;
                text-align: center;
                text-transform: uppercase;
                transition: 0.5s;
                background-size: 200% auto;
                color: white;
                box-shadow: 0 0 20px #eee;
                border-radius: 10px;
                display: block;
                border-color: transparent;
                font-weight: bold;
                cursor: pointer;
            }

            .btn-grad1:hover {
                background-position: right center;
                /* change the direction of the change here */
                color: #fff;
                text-decoration: none;
            }
        </style>
        
    </head>

    <body id="page1">
        <div style="display: flex;margin-left:35%">
            <button class="btn-grad" onclick="saveinvoice();">Download <i class='bx bxs-cloud-download'></i></button>
            <button class="btn-grad1" onclick="printInvoice();">Print Invoice <i class='bx bxs-printer'></i></button>
        </div>
        <div style='background-color:#EEEEEE; width: 950px;height:1500px;margin-left:15%;font-family:Montserrat' id="page">
            <img src='styles/logo.png' width='90px' ; height='90px' style='padding-top: 30px;margin-left:45%'>
            <h1 style='text-align:center;'>Thank You.</h1>
            <div style='background-color:white; width:60%; height:82%; margin-left:20%'>
                <h4 style='padding-top: 25px;margin-left:39%'>Hi, <?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]; ?></h4>
                <h5 style='padding-top: 5px;margin-left:30%'>Thanks for your purchase from CakeHub.inc</h5>
                <h1 style='padding-top: 10px;margin-left:35%'>INVOICE ID:</h1>
                <?php

                $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $pid . "'");
                $invoice_data = $invoice_rs->fetch_assoc();

                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $invoice_data["product_id"] . "'");
                $product_data = $product_rs->fetch_assoc();

                $city_rs = Database::search("SELECT distric.distric_id AS `did` FROM `users_has_address` INNER JOIN `city` ON users_has_address.city_city_id=city_city_id INNER JOIN `distric` ON  city.distric_distric_id=distric_distric_id WHERE `users_email`='" . $umail . "'");
                $city_data = $city_rs->fetch_assoc();

                $delivery = 0;
                if ($city_data["did"] == 7) {
                    $delivery = $product_data["delivery_fee_colombo"];
                } else {
                    $delivery = $product_data["delivery_fee_other"];
                }

                $t = $invoice_data["total"];
                $g = $t - $delivery;

                ?>
                <h2 style='padding-top: 0.2px;margin-left:48%'>#<?php echo $invoice_data["id"]; ?></h2>
                <h5 style='margin-left:5%; color:darkgray;'>YOUR ORDER INFORMATION:</h5>
                <hr style='margin-left:5%; margin-right:5%; border-radius:10%'>
                <div style='display:grid; margin-left:20%'>
                    <h5>Order Id: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;#<?php echo $invoice_data["order_id"]; ?></h5>
                    <h5>Bill To: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $umail; ?></h5>
                </div>
                <div style='display:grid; margin-left:20%'>
                    <h5>Date: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $invoice_data["date"]; ?></h5>
                    <h5>QTY: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;x<?php echo $invoice_data["qty"]; ?></h5>
                </div>
                <div style='display:grid; margin-left:20%'>
                    <h5>Item: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $product_data["title"]; ?></h5>
                    <h5>Item's Cost: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Rs.<?php echo $g; ?>.00</h5>
                </div>
                <div style='display:grid; margin-left:20%'>
                    <h5>Delivery Cost: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Rs.<?php echo $delivery; ?>.00</h5>
                    <h5>Payment Method: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; Debit Card</h5>
                </div>
                <hr style='margin-left:5%; margin-right:5%; border-radius:10%'>
                <span style='display:flex'>
                    <h5 style='padding-left:5%'>Total Cost: </h5>
                    <h5 style='padding-left:42%'>Rs.<?php echo $invoice_data["total"] ?>.00</h5>
                </span>
                <hr style='margin-left:5%; margin-right:5%; border-radius:10%'>
                <span style='display:flex'>
                    <h5 style='margin-left:20%'>Please keep a copy of this receipt for your records. </h5>
                </span>
                <hr style='margin-left:5%; margin-right:5%; border-radius:10%'>
                <span style='display:flex'>
                    <p style="margin-left:5%; margin-right:5%">
                        Please note that unless otherwise stated, Items purchased on the CakeHub.inc are eligible for a refund within 14 days of purchase (or 14 days after release for pre-purchases) If less than 24 hours. See our refund policy for more information.
                    </p>
                </span>
                <hr style='margin-left:5%; margin-right:5%; border-radius:10%'>
                <h5 style='margin-left:40%;'>Cakehub.inc</h5>
                <h5 style='margin-left:25%'>351-1, 1ST FLOOR, R. A. DE MEL MAWATHA</h5>
                <h5 style='margin-left:40%'>Colombo 03</h5>
                <h5 style='margin-left:42%'>Sri Lanka</h5>
            </div>
            <h6 style='margin-left:40%; color:blue'>Need help? help@cakehub.inc</h6>
        </div>
        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: home.php");
    exit();
}

?>