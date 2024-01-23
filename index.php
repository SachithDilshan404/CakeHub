<?php 

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin (for development)
header("Access-Control-Allow-Methods: POST"); // Allow POST requests
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Cake Hub
    </title>
    <link rel="shortcut icon" type="image" href="styles/logo.png">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div>
        <div class="d-none" id="registerbox">

            <div class="wrapper">
                <div>
                    <h1>
                        Register
                    </h1>
                    <div class="input-box">
                        <input type="text" placeholder="First Name" required id="fname" />
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Last Name" required id="lname" />
                        <i class='bx bxs-user'></i>
                    </div>

                    <div class="input-box">
                        <input type="text" placeholder="Email" required id="email" />
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Password" required id="password" />
                        <i class='bx bxs-lock-alt'></i>
                    </div>

                    <button type="submit" class="btn btn-white" onclick="register();">Register</button>

                    <div class="register-link">
                        <p>
                            Already Have an Account?
                            <a onclick="changeView();" class="point">Log In</a>
                        </p>
                    </div>

                </div>

            </div>

        </div>

        <div class="">

            <div class="wrapper" id="loginbox">
                <div>
                    <h1>
                        Login
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
                        <input type="text" placeholder="Email" required id="email1" value="<?php echo $email; ?>">
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Password" required id="password1" value="<?php echo $password; ?>">
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <div class="remember-forgot">
                        <label for="remember"><input type="checkbox" id="remember">Remember Me</label>
                        <a onclick="showLogin();" class="pointt">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-white" onclick="login();">Login</button>

                    <div class="register-link">
                        <p>
                            Don't Have an Account?
                            <a onclick="changeView();" class="point">Register</a>
                        </p>
                    </div>
                </div>



            </div>

        </div>
    </div>
    <!-- success Message -->
    <div class="ballon" id="pass" role="alert">
        <div class="ballon-content">
            <i class='bx bxs-check-circle check'></i>
            <div class="message">
                <span class="textt textt-1">Success</span>

            </div>
        </div>
        <i class='bx bx-x closer'></i>
        <div class="progress"></div>
    </div>
    <!-- sucess message -->

    <!-- Error message -->
    <div class="ballom" id="fail" role="alert">
        <div class="ballom-content">
            <i class='bx bxs-x-circle check'></i>
            <div class="message">
                <span class="textt textt-1">Failed</span>

            </div>
        </div>
        <i class='bx bx-x closer'></i>
        <div class="progress"></div>
    </div>
    <!-- Error message -->
    <!-- Forget Password -->
    <div class="wrapper d-none" id="reset">
        <div>
            <h1>
                Reset Password
            </h1>

            <div class="input-box">
                <input type="password" placeholder="New Password" required id="newpass" />
                <i class='bx bx-show eye' onclick="showPass();" id="npb"></i>

            </div>
            <div class="input-box">
                <input type="password" placeholder="Re type New Password" required id="newpass1" />
                <i class='bx bx-show eye' onclick="showPass1();" id="npb1"></i>

            </div>
            <div class="input-box">
                <input type="text" placeholder="Verification Code" required id="vc" />
                <i class='bx bxs-shield-alt-2'></i>

            </div>

            <button type="submit" class="btn btn-white" onclick="reset();">Change Password</button>

            <div class="register-link">
                <p>
                    Need to log your Account?
                    <a onclick="showLogin();" class="point">Log In</a>
                </p>
            </div>


        </div>
    </div>
    <!-- forget Password -->
    <div class="bd">
        <div class="col-12 d-none d-lg-block fixed-bottom">
            <p class="deco">&copy;2023 CakeHub.inc || ALL Rights Reserved</p>
        </div>
    </div>


    <script src="script.js"></script>
</body>

</html>