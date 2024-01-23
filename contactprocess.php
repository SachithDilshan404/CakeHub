<?php 

session_start();

require "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    $name = $_POST['name'];
    $msg = $_POST['msg'];
    $phone = $_POST['phone'];
    $email = $_POST['mail'];
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    // Prepare the SQL query to insert the feedback into the database
    Database::iud("INSERT INTO contact (name, phone, message, email, date)
             VALUES ('$name', '$phone', '$msg', '$email', '$date')");

    echo "OK";
} else {
    echo "Invalid request method. Please use POST.";
}
?>