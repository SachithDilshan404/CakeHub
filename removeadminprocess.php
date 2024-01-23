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
            // User found, update the 'is_admin' field to 0 (shopper)
            $updateQuery = Database::iud("UPDATE users SET is_admin = 0 WHERE email = '$umail'");

            $subject = "CakeHub Leave from Moderator Team Alert!";
            $message = "Hello " . $userdata['fname'] . " " . $userdata['lname'] . ",\n\n";
            $message .= "We wanted to inform you that your request for a leave of absence from the moderator team at CakeHub has been approved. Your leave will be effective from ". date("Y-m-d", strtotime($userdata['joined_date'])) ." to " . date("Y-m-d") . ". During this period, you are not expected to fulfill your moderator responsibilities, and your access to the moderator tools will be temporarily revoked.\n\n";
            $message .= "If you have any questions or need assistance during your leave, please don't hesitate to reach out to " . $userdata['fname'] . " " . $userdata['lname'] . " at ".$userdata['email'].".\n\n";
            $message .= "We appreciate the hard work and commitment you've shown as a moderator, and we look forward to having you back on the team after your leave. We hope you have a restful and enjoyable leave, and we'll be in touch before your return to help you get back up to speed.\n\n";
            $message .= "Best regards,\n";
            $message .= "Admin " . $admin_data['fname'] . " " . $admin_data['lname'] . "\n";
            $message .= "CakeHub Support Team";

            
            $sendmail = sendadminmail($umail, $subject, $message);
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
