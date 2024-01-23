<?php
session_start();
require "connection.php";
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$email = $_POST["e"];
$password = $_POST["p"];
$remember = $_POST["r"];

if (empty($email)) {
    echo ("Please enter your email address");
} elseif (strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Not a valid email address");
} elseif (empty($password) || strlen($password) < 5 || strlen($password) > 20) {
    echo ("Incorrect password");
} else {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $rs = Database::search("SELECT * FROM `users` WHERE `email`='$email' AND `is_admin`=1");
    $n = $rs->num_rows;

    if ($n == 1) {
        $d = $rs->fetch_assoc();
        $hashedPasswordInDB = $d['password'];

        if (password_verify($password, $hashedPasswordInDB)) {
            // Password is correct
            $_SESSION["u"] = $d;

            // Generate verification code
            $verification_code = uniqid();

            // Store the verification code in the database
            Database::iud("UPDATE `users` SET `verfication_code`='$verification_code' WHERE `email`='$email'");

            // Send verification code via email
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sachithdilshan34@gmail.com';
            $mail->Password = 'hxczivgdoqqzesol';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('sachithdilshan34@gmail.com', 'CakeHub.inc');
            $mail->addReplyTo('sachithdilshan34@gmail.com', 'Two Step Login Code');
            $mail->addAddress($email);
            $mail->isHTML(true);

            $mail->Subject = 'Verification Code for Login';
            $bodyContent = '<h1 style="color:green">Your Two Step verification code is ' . $verification_code . '</h1>';
            $mail->Body = $bodyContent;

            if (!$mail->send()) {
                echo ("Sending verification code failed");
            } else {
                echo ("Success");
            }

            if ($remember == "true") {
                setcookie("email", $email, time() + (60 * 60 * 24 * 365));
                setcookie("password", $password, time() + (60 * 60 * 24 * 365));
            } else {
                setcookie("email", "", -1);
                setcookie("password", "", -1);
            }
        } else {
            echo ("Incorrect password");
        }
    } else {
        echo ("Please Use Admin Panel Email And Password!");
    }
}
?>
