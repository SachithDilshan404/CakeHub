<?php
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sentreply($recipient, $subject, $body) {
    $mail = new PHPMailer();

    // Configure SMTP settings
    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = 'ssl';
    $mail->Port = $_ENV['SMTP_PORT'];

    // Set the sender and recipient
    $mail->setFrom($_ENV['SMTP_USERNAME'], 'CakeHub.inc');
    $mail->addAddress($recipient);

    // Set email content
    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body = $body;

    // Send the email
    if ($mail->send()) {
        
    } else {
        echo "Error: " . $mail->ErrorInfo;
    }
}
?>