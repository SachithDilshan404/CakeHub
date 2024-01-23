<?php 
session_start();
require "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['m'];
    $fid = $_POST['f'];

    Database::iud("INSERT INTO `like` (islike, feedback_fid, users_email) VALUES ('1', '$fid', '$mail')");
    
    echo "Success";
} else {
    echo "Invalid request method. Please use POST.";
}
?>