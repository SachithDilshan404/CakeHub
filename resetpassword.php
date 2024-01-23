<?php

require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if(isset($_GET["e"])){

    $email = $_GET["e"];

    $rs = Database::search("SELECT * FROM `users` WHERE `email`='".$email."'");
    $n = $rs->num_rows;

    if($n == 1){
        
        $code = uniqid();

        Database::iud("UPDATE `users` SET `verfication_code`='".$code."' WHERE `email`='".$email."'");

        $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USERNAME'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = 'ssl';
            $mail->Port = $_ENV['SMTP_PORT'];
            $mail->setFrom('sachithdilshan34@gmail.com', 'CakeHub.inc');
            $mail->addReplyTo('sachithdilshan34@gmail.com', 'Reset Password');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'CakeHub Forget Password Verification Code';
            $bodyContent = '<h1 style="color:green">Your Verification code belongs to '.$code.'</h1>';
            $mail->Body    = $bodyContent;

            if(!$mail->send()){
                echo ("Verification code send failed");
            }else{
                echo ("Verification code sent");
            }

    }else{
        echo ("Invalid Email address");
    }
    
}else{
    echo ("Please Enter your Email First");
}
?>