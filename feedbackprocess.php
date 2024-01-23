<?php
session_start();

require "connection.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    $title = $_POST['title'];
    $body = $_POST['body'];
    $status = $_POST['status'];
    $userEmail = $_POST['u'];
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s"); // Current date and time in MySQL format

    // Prepare the SQL query to insert the feedback into the database
    Database::iud("INSERT INTO feedback (title, body, f_date, users_email, f_staus_idf_staus)
             VALUES ('$title', '$body', '$date', '$userEmail', '$status')");

    echo "Success";
} else {
    echo "Invalid request method. Please use POST.";
}
?>
