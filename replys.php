<?php 

session_start();

require "connection.php";
require "sendreply.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $text = $_POST['t'];
    $cid = $_POST['c'];
    $mail = $_POST['u'];
    $umail = $_POST['r'];
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if (isset($_SESSION["u"])) {
        $session_data = $_SESSION["u"];
    }

    $reply_rs = Database::search("SELECT name, date, message FROM contact WHERE cid = '$cid'");
    $reply_data = $reply_rs->fetch_assoc();

    Database::iud("INSERT INTO rep_contact (reply, date, contact_cid, users_email)
                   VALUES ('$text', '$date', '$cid', '$mail')");

    // Send Replay To customer's Email
    $subject = "CakeHub Support Ticket: #" . $cid." ";
    $body =  "Hello " .$reply_data['name']. "\n\n";
    $body .= "Thank you for getting back to us!\n";
    $body .= "".$text." \n\n";
    $body .= "Best regards,\n"; 
    $body .= "Admin ".$session_data['fname']." ".$session_data['lname']."\n";  
    $body .= "CakeHub Support Team \n\n";
    $body .= "You wrote: \n";
    $body .= "".$reply_data['message']."";

    $replySent = sendreply($umail, $subject, $body);
}else {
    echo "Something went wrong!";
}


?>