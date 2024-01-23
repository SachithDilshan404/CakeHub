<?php
 session_start();

require "connection.php";

$email = $_SESSION["u"]["email"];

$category = $_POST["ca"];
$title = $_POST["ti"];
$s_description = $_POST["sd"];
$l_description = $_POST["ld"];
$cost = $_POST["cst"];
$delico = $_POST["dwc"];
$delito = $_POST["doc"];
$Quantity = $_POST["qty"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

$status = 1;

Database::iud("INSERT INTO `product`(`price`,`qty`,`srt_descri`,`description`,`title`,`datetime_added`,`delivery_fee_colombo`,`delivery_fee_other`,`category_cat_id`,`status_status_id`,`users_email`) 
VALUES ('".$cost."','".$Quantity."','".$s_description."','".$l_description."','".$title."','".$date."','".$delico."','".$delito."','".$category."','".$status."','".$email."')");

$product_id = Database::$connection->insert_id;
$length = sizeof($_FILES);

if($length <= 3 && $length > 0){

    $allowed_img_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

    for($x = 0;$x < $length; $x++){
        if(isset($_FILES["img".$x])){
            $img_file = $_FILES["img".$x];
            $file_extention = $img_file["type"];

            if(in_array($file_extention,$allowed_img_extentions)){

                $new_img_extention;

                if($file_extention == "image/jpg"){
                    $new_img_extention = ".jpg";
                }else if($new_img_extention = "image/jpeg"){
                    $new_img_extention = ".jpeg";
                }elseif($file_extention == "image/png"){
                    $new_img_extention = ".png";
                }elseif($file_extention == "image/svg+xml"){
                    $new_img_extention = ".svg";
                }

                $file_name = "resourses//products//".$title."_".$x."_".uniqid().$new_img_extention;
                move_uploaded_file($img_file["tmp_name"],$file_name);

                Database::iud("INSERT INTO `product_img`(`img_path`, `product_id`) VALUES ('".$file_name."','".$product_id."')");

                echo ("Success");

            }else{
                echo ("Not an allowed image file extension");
            }
        }
    }

}else{
    echo ("Invalid Image Count");
}


?>