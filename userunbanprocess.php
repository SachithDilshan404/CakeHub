<?php
// Start or resume the session
session_start();
require "userbanemail.php";

// Get the admin's email and password from the POST data
$adminEmail = $_POST['amail'];
$adminPassword = $_POST['Pass'];

// Include the database connection (assuming it's already included in "connection.php")
require "connection.php";

// Check if the provided admin email and password match a user in the database
$query = Database::search("SELECT * FROM users WHERE email = '$adminEmail'");

if ($query->num_rows == 1) {
    // Admin found, now proceed to check if the user specified by 'umail' exists in the database
    $umail = $_POST['umail'];

    // Verify the admin password
    $admin_data = $query->fetch_assoc();
    $hashedPasswordFromDatabase = $admin_data['password'];

    if (password_verify($adminPassword, $hashedPasswordFromDatabase)) {
        // Passwords match, proceed with the user banning operation

        $userQuery = Database::search("SELECT * FROM users WHERE email = '$umail'");
        $userdata = $userQuery->fetch_assoc();

        $admin_rs = Database::search("SELECT * FROM users WHERE email = '$adminEmail'");
        $admin_data = $admin_rs->fetch_assoc();

        if ($userQuery->num_rows == 1) {
            // User found, update the 'status' field to 0 (banned)
            $updateQuery = Database::iud("UPDATE users SET status = 1 WHERE email = '$umail'");

            $subject = "CakeHub User Unbanning Alert!";
            $body = "Hello " . $userdata['fname'] . " " . $userdata['lname'] . ",\n\n";
            $body .= "We're pleased to inform you that your account on CakeHub has been successfully unbanned. After a recent suspension due to Violation CakeHub community standards, we have reviewed your case and have decided to lift the suspension.\n\n";
            $body .= "We appreciate your understanding and cooperation during the suspension period. We believe in creating a positive and safe environment for all our users, and we look forward to your continued participation.\n\n";
            $body .= "If you have any questions or concerns regarding the unbanning process or any other matters, please do not hesitate to reach out to our support team. Your feedback and insights are valuable to us.\n\n";
            $body .= "Welcome back to CakeHub, and we hope you have a great experience on our platform.\n\n";
            $body .= "Best regards,\n";
            $body .= "Admin " . $admin_data['fname'] . " " . $admin_data['lname'] . "\n";
            $body .= "CakeHub Support Team";

            
            $sendmail = sendmail($umail, $subject, $body);
        } else {
            echo "User not found in the database";
        }
    } else {
        echo "Invalid admin password";
    }
} else {
    echo "Invalid admin email or password";
}
?>