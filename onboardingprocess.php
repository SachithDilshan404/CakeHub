<?php 

session_start();

require "connection.php";
require "sentreply.php";

if(isset($_SESSION["u"])){

    $user_email = $_SESSION["u"]["email"];

    $fname = $_POST["fn"];
    $lname = $_POST["ln"];
    $mobile = $_POST["mn"];
    // $pw = $_POST["pw"];
    $email = $_POST["ea"];
    $line1 = $_POST["adl"];
    // $province = $_POST["p"];
    // $district = $_POST["d"];
    $city = $_POST["c"];
    $pc = $_POST["pc"];

    $address_rs = Database::search("SELECT * FROM `users_has_address` WHERE `users_email`='".$user_email."'");

    $address_num = $address_rs->num_rows;

    if($address_num == 1){
        Database::iud("UPDATE `users_has_address` SET `line1`='" . $line1 . "',
                        `postal_code`='" . $pc . "',`city_city_id`='" . $city . "' 
                        WHERE `users_email`='" . $user_email . "'");
    }else{
        Database::iud("INSERT INTO `users_has_address`(`line1`,`postal_code`,`users_email`,`city_city_id`) 
                        VALUES ('" . $line1 . "','" . $pc . "','" . $user_email . "','" . $city . "')");

    }

    $allowed_image_extensions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

    if(isset($_FILES["img"])){
        $img = $_FILES["img"];
        $file_type = $img["type"];

        if(in_array($file_type,$allowed_image_extensions)){

            $new_file_type;

            if($file_type == "image/jpg"){
                $new_file_type = ".jpg";
            }else if($file_type == "image/jpeg"){
                $new_file_type = ".jpeg";
            }else if($file_type == "image/png"){
                $new_file_type = ".png";
            }else if($file_type == "image/svg+xml"){
                $new_file_type = ".svg"; 
            } 
            
            $file_name = "resourses//profile_images//".$lname."_".$mobile."_".uniqid().$new_file_type;
            move_uploaded_file($img["tmp_name"],$file_name);

            $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email` = '".$user_email."'");

            $image_num = $image_rs->num_rows;

            if($image_num == 1){

                Database::iud("UPDATE `profile_img` SET `path` = '".$file_name."' WHERE `users_email` = '".$user_email."'");

            }else{

                Database::iud("INSERT INTO `profile_img`(`path`,`users_email`) VALUES 
                            ('".$file_name."','".$user_email."')");

            }
        }else{
            echo ("Unsupported image type!");
        }
    }else{
        // echo ("Image not Updated");
    }
    
    $user_rs = Database::search("SELECT * FROM `users` WHERE `email` = '".$user_email."'");
    $user_num = $user_rs->num_rows;

    if($user_num == 1){
        Database::iud("UPDATE `users` SET `fname`='".$fname."',`lname`='".$lname."',
                        `mobile`='".$mobile."' WHERE `email` = '".$user_email."'");
        
        $subject = "Security Alert: Recent Profile Update on CakeHub";
        $message = "Dear " . $fname . " " .$lname.",\n\n";
        $message .= "We hope this email finds you well. We wanted to inform you about a recent update made to your CakeHub profile. Our records indicate that the following changes were made:\n\n";
        $message .= "Updated Mobile Number\n";  
        $message .= "Updated Billing Address\n";
        $message .= "Updated Province \n";
        $message .= "Updated District \n";
        $message .= "Updated City \n";
        $message .= "Updated Postal Code \n"; 
        $message .= "Updated Profile Picture \n\n";
        $message .= "If you did not make these changes or if you believe your account security may have been compromised, please contact our support team immediately at admin@cakehub.lk.\n\n";
        $message .= "For your own safety, we recommend reviewing and updating your account password regularly. Make sure it's unique and not used for any other accounts.\n\n";
        $message .= "Thank you for your attention to this matter. We are committed to ensuring the security of your CakeHub account.\n\n";
        $message .= "Best regards,\n";
        $message .= "CakeHub Moderator Team";

        $replySent = sentreply($email, $subject, $message);
                                    
        echo ("Success");               
    }else {
        echo ("You are not valid user!");
    }
}





