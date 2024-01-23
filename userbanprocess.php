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
            $updateQuery = Database::iud("UPDATE users SET status = 0 WHERE email = '$umail'");

            $subject = "CakeHub User Banning Alert!";
            $body = "Hello " . $userdata['fname'] . " " . $userdata['lname'] . "\n\n";
            $body .= "We regret to inform you that your account on CakeHub has been suspended due to a violation of our terms of service. The specific reason(s) for your suspension are as follows:\n\n";
            $body .= "Violation CakeHub community standards\n\n";
            $body .= "If you believe this suspension is in error or if you would like to appeal this decision, please respond to this email with a detailed explanation. Our team will review your case and get back to you as soon as possible.\n\n";
            $body .= "Please note that if the suspension is upheld, you may not be able to access your account or use our platform until the suspension period is over, which is 1 Year.\n\n";
            $body .= "We encourage all of our users to review our terms of service to ensure compliance in the future. It is important that we maintain a safe and respectful environment for all members of our community.\n\n";
            $body .= "Best regards,\n";
            $body .= "Admin " . $admin_data['fname'] . " " . $admin_data['lname'] . "\n";
            $body .= "CakeHub Support Team";
            // ... (the rest of your code) ...

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