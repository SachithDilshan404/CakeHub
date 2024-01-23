<?php
session_start();

require "connection.php";
require "makeadminemail.php";

$adminEmail = $_POST['amail'];
$adminPassword = $_POST['pass'];

$process = Database::search("SELECT * FROM users WHERE email = '$adminEmail'");
$admin_data = $process->fetch_assoc();
$hashedPasswordFromDatabase = $admin_data['password'];

if ($process->num_rows == 1 && password_verify($adminPassword, $hashedPasswordFromDatabase)) {
    $umail = $_POST['umail'];

    $userQuery = Database::search("SELECT * FROM users WHERE email = '$umail'");

    if ($userQuery->num_rows == 1) {
        $newpass1 = $_POST['pass2'];
        $newpass2 = $_POST['pass3'];

        if ($newpass1 === $newpass2) {
            // Passwords match, so update the user's password in the database
            $hashedPassword = password_hash($newpass1, PASSWORD_DEFAULT); // Hash the new password
            $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE email = '$umail'";
            
            if (Database::iud($updateQuery)) {
                // Successfully updated password
            } else {

                $subject = "CakeHub User Password Change Alert!";
                $body = "Hello " . $userdata['fname'] . " " . $userdata['lname'] . ",\n\n";
                $body .= "We are writing to inform you that, as part of our commitment to enhance security, your password for your CakeHub account has been changed. This action was taken to safeguard your account and data from potential threats or vulnerabilities.\n\n";
                $body .= "To access your account, please use the following temporary password: 123456789. You will be prompted to create a new password upon login. We recommend that you choose a strong, unique password to ensure the continued security of your account.\n\n";
                $body .= "If you did not request this password change or have any concerns about the security of your account, please contact our support team immediately. We take your account security seriously, and we are here to assist you with any questions or issues you may have.\n\n";
                $body .= "We apologize for any inconvenience this may cause and appreciate your understanding as we prioritize your account's security.\n\n";
                $body .= "Best regards,\n";
                $body .= "Admin " . $admin_data['fname'] . " " . $admin_data['lname'] . "\n";
                $body .= "CakeHub Support Team";
                
                $sendmail = sendadminmail($umail, $subject, $body);
            }
        } else {
            echo "OK";
        }
    } else {
        echo "User not found in the database";
    }
} else {
    echo "Invalid admin email or password";
}
?>