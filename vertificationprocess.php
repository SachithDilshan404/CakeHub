<?php
session_start();
require "connection.php";

$email = $_POST["e"]; // Email from the form
$verificationCode = $_POST["r"]; // Verification code from the form

// Retrieve the stored verification code from the database for the given email
$rs = Database::search("SELECT `verfication_code` FROM `users` WHERE `email`='$email'");
if ($rs && $rs->num_rows === 1) {
    $row = $rs->fetch_assoc();
    $storedVerificationCode = $row['verfication_code'];

    // Compare the provided verification code with the stored verification code
    if ($verificationCode === $storedVerificationCode) {
        echo "Success"; // Verification successful
    } else {
        echo "Incorrect verification code";
    }
} else {
    echo "Invalid email"; // Email not found in the database
}
?>
