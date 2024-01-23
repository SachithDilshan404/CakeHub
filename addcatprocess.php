<?php
session_start();
require "connection.php";

$adminEmail = $_POST['Email'];
$adminPassword = $_POST['Pass'];

$query = Database::search("SELECT * FROM users WHERE email = '$adminEmail'");

if ($query->num_rows == 1) {
  $admin_data = $query->fetch_assoc();
  $hashedPasswordFromDatabase = $admin_data['password'];

  if (password_verify($adminPassword, $hashedPasswordFromDatabase)) {
    $cata = $_POST['text'];

    $insertQuery = "INSERT INTO `category`(`cat_name`) VALUES ('$cata')";
    if (Database::iud($insertQuery)) {
      echo "Somthing went goes wrong!";
    } else {
      echo "OK";
    }
  } else {
    echo "InvalidAdminPassword";
  }
} else {
  echo "NotAdmin";
}
?>