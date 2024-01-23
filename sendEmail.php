<?php
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendEmail($recipient, $subject, $body) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    // Configure SMTP settings
    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];  // Update with your SMTP server details
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];;  // Update with your SMTP username
    $mail->Password = $_ENV['SMTP_PASSWORD'];;  // Update with your SMTP password
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
        echo "Success";
    } else {
        echo "Error: " . $mail->ErrorInfo;
    }
}
?>
