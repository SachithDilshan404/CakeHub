<?php

session_start();
require "connection.php";
require "sendEmail.php";

if(isset($_SESSION["u"])){

    $order_id = $_POST["o"];
    $pid = $_POST["r"];
    $mail = $_POST["u"];
    $amount = $_POST["a"];
    $qty = $_POST["q"];

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$pid."'");
    $product_data = $product_rs->fetch_assoc();

    $current_qty = $product_data["qty"];
    $new_qty = $current_qty - $qty;

    $city_rs = Database::search("SELECT distric.distric_id AS `did` FROM `users_has_address` INNER JOIN `city` ON users_has_address.city_city_id=city_city_id INNER JOIN `distric` ON  city.distric_distric_id=distric_distric_id WHERE `users_email`='" . $mail . "'");
    $city_data = $city_rs->fetch_assoc();

    $delivery = 0;
    if ($city_data["did"] == 7) {
        $delivery = $product_data["delivery_fee_colombo"];
    } else {
        $delivery = $product_data["delivery_fee_other"];
    }

    $t = $amount;
    $g = $t - $delivery;

    $user_rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $mail . "'");
    $user_data = $user_rs->fetch_assoc();

    $address_rs = Database::search("SELECT * FROM `users_has_address` WHERE `users_email`='" . $mail . "'");
    $address_data = $address_rs->fetch_assoc();

    Database::iud("UPDATE `product` SET `qty`='".$new_qty."' WHERE `id`='".$pid."'");

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `invoice`(`order_id`,`date`,`total`,`qty`,`status`,`product_id`,`users_email`) VALUES 
    ('".$order_id."','".$date."','".$amount."','".$qty."','0','".$pid."','".$mail."')");
    
    // Send email with invoice details to the customer
    $subject = "Your Cakehub Receipt #" . $order_id;
    $body = "Thank you for cakehub order!\n\n";
    $body .= "Order ID: #" . $order_id . "\n";
    $body .= "Item Name: " . $product_data["title"] . "\n";
    $body .= "Quantity: " . $qty . "\n";
    $body .= "Item per Cost: Rs." . number_format($g, 2) . "\n";
    $body .= "Delivery Cost: Rs." . number_format($delivery, 2) . "\n";
    $body .= "Total Amount: Rs." . number_format($amount, 2) . "\n\n";
    $body .= "Customer Name: " .$_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]. "\n";
    $body .= "Customer Email: " .$mail. "\n";
    $body .= "Customer Mobile: " .$user_data["mobile"]. "\n";
    $body .= "Billing Address: " .$address_data["line1"]. "\n\n";
    $body .= "Please keep a copy of this receipt for your records!";

    $emailSent = sendEmail($mail, $subject, $body);

}

?>