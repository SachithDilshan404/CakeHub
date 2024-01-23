<?php 
session_start();
require "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    $body = $_POST['body'];
    $fid = $_POST['fid'];
    $userEmail = $_POST['mail'];

    // Prepare the SQL query to insert the reply into the database
    Database::iud("INSERT INTO feedback_reply (body, feedback_fid, users_email)
             VALUES ('$body', '$fid', '$userEmail')");


    echo "Success";
    exit(); // Echo "Success" upon successful insertion
} else {
    echo "Invalid request method. Please use POST.";
}
?>

