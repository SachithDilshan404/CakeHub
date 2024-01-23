<?php 
session_start();
require "connection.php";

if (isset($_GET['id'])) {
    // Sanitize and retrieve the chat ID from the request
    $chatId = $_GET['id'];

    Database::iud("DELETE FROM contact WHERE cid = " . $chatId);

    echo "OK";
} 
?>
