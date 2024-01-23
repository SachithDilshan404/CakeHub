<?php
// Start or resume the session
session_start();
require "makeadminemail.php";

// Get the admin's email and password from the POST data
$adminEmail = $_POST['amail'];
$adminPassword = $_POST['Pass'];

// Include the database connection (assuming it's already included in "connection.php")
require "connection.php";

// Check if the provided admin email and password match a user in the database
$query = Database::search("SELECT * FROM users WHERE email = '$adminEmail'");

if ($query->num_rows == 1) {
    $admin_data = $query->fetch_assoc();
    $hashedPasswordFromDatabase = $admin_data['password'];

    if (password_verify($adminPassword, $hashedPasswordFromDatabase)) {
        // Passwords match, proceed with the admin process

        // Now you can continue with the rest of your code
        $umail = $_POST['umail'];

        $userQuery = Database::search("SELECT * FROM users WHERE email = '$umail'");
        $userdata = $userQuery->fetch_assoc();

        $admin_rs = Database::search("SELECT * FROM users WHERE email = '$adminEmail'");
        $admin_data = $admin_rs->fetch_assoc();

        if ($userQuery->num_rows == 1) {
            // User found, update the 'is_admin' field to 1 (admin)
            $updateQuery = Database::iud("UPDATE users SET is_admin = 1 WHERE email = '$umail'");

            $subject = "CakeHub New Moderator Team Alert!";
            $body = "Hello " . $userdata['fname'] . " " . $userdata['lname'] . ",\n\n";
            $body .= "We are excited to inform you that you have been selected as a new moderator for CakeHub. Your role as a moderator is crucial to maintaining a positive and welcoming environment for our community members.\n\n";
            $body .= "As a moderator, your responsibilities will include:\n";
            $body .= "1. Enforcing community guidelines and ensuring a respectful and supportive atmosphere.\n";
            $body .= "2. Monitoring discussions, comments, and user-generated content for inappropriate or harmful material.\n";
            $body .= "3. Assisting users with questions and concerns, providing guidance, and resolving disputes when necessary.\n";
            $body .= "4. Collaborating with other moderators and the admin team to make decisions that benefit the community.\n";
            $body .= "5. Reporting issues, trends, and user feedback to improve our platform.\n";
            $body .= "\n";
            $body .= "If you have any questions or need assistance, please don't hesitate to reach out to our support team or your fellow moderators.\n\n";
            $body .= "Best regards,\n";
            $body .= "Admin " . $admin_data['fname'] . " " . $admin_data['lname'] . "\n";
            $body .= "CakeHub Support Team";

            
            $sendmail = sendadminmail($umail, $subject, $body);
        } else {
            echo "User not found in the database";
        }
    }else {
        echo "Something went wrong";
    }
} else {
    echo "Invalid admin email or password";
}
?>
