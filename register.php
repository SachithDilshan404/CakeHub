<?php

require "connection.php";
require "sendreply.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];

if(empty($fname)){
    echo ("Fist Name Requred!");
}else if(strlen($fname) > 45){
    echo ("Too long your First Name");
}else if(empty($lname)){
    echo ("Last Name Requred!");
}else if(strlen($lname) > 45) {
    echo ("Too long your Last Name");
}else if(empty($email)){
    echo ("Email Requred!");
}else if(strlen($email) > 95) {
    echo ("Too long your Email");
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address");
}else if(empty($password)){
    echo ("Password Requred!");
}else if(strlen($password)<5 || strlen($password)>20){
    echo ("Password length must be between 5 - 20 characters!");
}else {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $rs = Database::search("SELECT * FROM `users` WHERE `email`='".$email."'");
    $n = $rs->num_rows;

    if($n > 0){
        echo ("Alredy Registered user! Please log in or Forget your password");
    }else{
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format('Y-m-d H:i:s');

        Database::iud("INSERT INTO `users`(`fname`,`lname`,`email`,`password`,`joined_date`,`status`,`is_admin`)
        VALUES ('".$fname."','".$lname."','".$email."','".$hashedPassword."','".$date."','1','0')");

        $subject = "Welcome to CakeHub Community!";
        $message = "Hello " . $email . ",\n\n";
        $message .= "Thank you for joining CakeHub - your sweet destination for all things delicious! 🍰 We're thrilled to have you as part of our community. Get ready to explore a world of tempting treats and delightful surprises.\n\n";
        $message .= "Feel free to browse our mouthwatering selection, save your favorite recipes, and connect with fellow dessert enthusiasts. If you ever have any questions or need assistance, our support team is here to help.\n\n";
        $message .= "Thank you for choosing CakeHub. We can't wait to sweeten your culinary journey!\n\n";
        $message .= "Best regards,\n";
        $message .= "Admin Cake Hub Community\n";
        $message .= "CakeHub Support Team";

        $replySent = sendreply($email, $subject, $message);
        echo ("Success");
    }
}
?>