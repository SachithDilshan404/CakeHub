<?php

require "connection.php";

$email = $_POST["e"];
$new_pw = $_POST["np"];
$retyped_pw = $_POST["rnp"];
$v_code = $_POST["vc"];

if(empty($email)){
    echo ("Please enter your email address");
}elseif(empty($new_pw)){
    echo ("Please enter your new password");
}elseif(strlen($new_pw)<5 && strlen($new_pw)>20){
    echo ("Invalid new password");
}elseif(empty($retyped_pw)){
    echo ("Please retype new password");
}elseif($new_pw != $retyped_pw){
    echo ("Password does not match");
}elseif(empty($v_code)){
    echo ("Please enter your verification code");
}else{

    $rs = Database::search("SELECT * FROM `users` WHERE `email`='".$email."' AND `verfication_code`='".$v_code."'");

    $n = $rs->num_rows;

    if($n == 1){

        $hashed_pw = password_hash($new_pw, PASSWORD_DEFAULT);

        Database::iud("UPDATE `users` SET `password`='" . $hashed_pw . "' WHERE `email`='" . $email . "' AND `verfication_code`='" . $v_code . "'");

        echo ("Success");

    }else {
        echo ("Inavlid user datails");
    }

}
?>