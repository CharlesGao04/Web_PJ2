<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" user-scalable=no" />
    <title>Login</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<?php
if($_GET['login']==1){
    echo "<script>alert(\"Incorrect Username or Password, please try again\");</script>";
}
?>

<body>
    <main>
        <div class="indexLogin">
            <form class="loginForm" action="loginHelp.php" method="post">
            <div class="title">
                <img src="../images/background/logo.jpg" class="logo">
                <div id="logTitle">Log in Billions to find a Bigger world</div><br>
                <div role="alert">
                    <span id="tips">Welcome to Login！</span>
                    </br>
                </div>
            </div>
                <div class="content">Username:</div>
                <input type="text" name="Name">
                <div class="content">Password:</div>
                <input type="password" name="Password"><br>
                <input type='submit' value='Sign in' class='form-control' />
            </form>
            <div>
                New to Billions?<a href="register.php" class="loginLink">Create a new account</a>
            </div>
        </div>
    </main>
    <footer class="footerBottom">
        <p class="copyright">Copyright © 2019-2021 Gaoxiangxing. All Rights Reserved. 备案号：17300290033</p>
    </footer>
</body>
</html>