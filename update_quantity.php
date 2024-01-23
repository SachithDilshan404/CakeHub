<?php
session_start();
require "connection.php";

if (isset($_SESSION["u"])) {
    if (isset($_POST["cartItemId"]) && isset($_POST["newQuantity"])) {
        $cartItemId = $_POST["cartItemId"];
        $newQuantity = $_POST["newQuantity"];

        // Update the quantity in the database
        $query = "UPDATE cart SET qty = $newQuantity WHERE cart_id = $cartItemId";
        $result = Database::iud($query);

        if ($result) {
            echo "Quantity updated successfully.";
        } else {
            echo "Failed to update quantity.";
        }
    } else {
        echo "Invalid request parameters.";
    }
} else {
    echo "User not logged in.";
}
?>
