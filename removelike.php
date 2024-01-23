<?php 
session_start();
require "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['m'];
    $fid = $_POST['f'];

    Database::iud("DELETE FROM `like` WHERE feedback_fid = '$fid' AND users_email = '$mail'");
    
    echo "Success";
} else {
    echo "Invalid request method. Please use POST.";
}
?>
