<?php
session_start();
require "connection.php";

// Check if the user is logged in as an admin
$email = $_SESSION["u"]["email"];
$result = Database::search("SELECT is_admin FROM users WHERE email='" . $email . "'");

if ($result && $row = $result->fetch_assoc()) {
    $is_admin = $row['is_admin'];

    // If the user is not an admin, log them out and redirect to home
    if ($is_admin != 1) {
        session_destroy();
        header("Location: home.php");  // Redirect to home if not an admin
        exit();
    }
} else {
    // Handle error if unable to retrieve admin status
    echo "Error: Unable to retrieve admin status.";
    exit();
}
?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Admin Pannel | Cake Hub
    </title>
    <link rel="shortcut icon" type="image" href="styles/logo.png">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="ggg">

    <div class="wrapper" id="login">
        <div>
            <h1>
                Admin Login
            </h1>
            <?php
            $email = "";
            $password = "";

            if (isset($_COOKIE["email"])) {
                $email = $_COOKIE["email"];
            }
            if (isset($_COOKIE["password"])) {
                $password = $_COOKIE["password"];
            }
            ?>
            <div class="input-box">
                <input type="text" placeholder="Email" required id="mail" value="<?php echo $email; ?>">
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" required id="pass" value="<?php echo $password; ?>">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label for="remember"><input type="checkbox" id="remember">Remember Me</label>
                <a class="pointt" onclick="window.location='index.php'">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-white" onclick="admin();">Login</button>

        </div>
    </div>

    <div class="wrapper d-none" id="verify">
        <div>
            <h1>
               Two Step Verification
            </h1>
            <div class="input-box">
                <input type="text" placeholder="Verification Code" required id="vco" />
                <i class='bx bxs-shield-alt-2'></i>
            </div>
            <button type="submit" class="btn btn-white" onclick="verifyAndRedirect();">Verify</button>


        </div>
    </div>
        
    <div class="bd">
        <div class="col-12 d-none d-lg-block fixed-bottom">
            <p class="deco">&copy;2023 CakeHub.inc || ALL Rights Reserved</p>
        </div>
    </div>


    <script src="script.js"></script>
</body>

</html>