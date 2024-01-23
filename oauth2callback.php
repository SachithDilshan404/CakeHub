<?php
require 'vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('client_secret_104713819177-4onpda21nkd5augd55bcibkl8s9p922a.apps.googleusercontent.com.json');
$client->setRedirectUri('http://localhost/CakeHub/adminpannnel.php');
$client->addScope(Google_Service_Drive::DRIVE);

if (! isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authorize($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>
