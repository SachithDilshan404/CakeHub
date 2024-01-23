<?php

session_start();
require "connection.php"; // Assuming that this file establishes the database connection

$email = $_POST["e"];
$password = $_POST["p"];
$remember = $_POST["r"];

if (empty($email)) {
    echo "Please enter your email address";
} elseif (strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Not a valid email address";
} elseif (empty($password)) {
    echo "Please enter your password";
} else {
    // Fetch the user data including status for the given email
    $result = Database::search("SELECT password, status FROM `users` WHERE `email` = '$email'");
    
    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        $userStatus = $row['status'];

        if ($userStatus == 1) {
            $userQuery = Database::search("SELECT fname, lname, mobile, joined_date FROM `users` WHERE `email` = '$email'");
            $userdata = $userQuery->fetch_assoc();
            // Verify the provided password against the hashed password
            if (password_verify($password, $hashedPassword)) {
                $userData = [
                    'email' => $email,
                    'fname' => $userdata['fname'],
                    'lname' => $userdata['lname'],
                    'mobile' => $userdata['mobile'],
                    'joined_date' => $userdata['joined_date'],
                ];
                // You can fetch additional user data from the database

                echo "Success";
                $_SESSION["u"] = $userData;

                if ($remember === "true") {
                    setcookie("email", $email, time() + (60 * 60 * 24 * 365));
                    setcookie("password", $password, time() + (60 * 60 * 24 * 365));
                } else {
                    setcookie("email", "", time() - 3600); // Expire the cookie
                    setcookie("password", "", time() - 3600);
                }
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "Banned user";
        }
    } else {
        echo "User not found";
    }
}
?>