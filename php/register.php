<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" user-scalable=no" />
    <title>Register</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>

<?php
if($_GET['login']==1){
    echo "<script>alert(\"The UserName already exists, please try another name\");</script>";
}
?>

<main>
    <div class="registerLogin">
        <form class="loginForm" action="registerHelp.php" method="post">
            <div class="title">
                <img src="../images/background/logo.jpg" class="logo">
                <div id="logTitle">Log in Billions to find a Bigger world</div><br>
                <div role="alert">
                <span id="tips">Welcome to Register！</span>
                </div>
            </div>

                <div class="content">Username:</div>
                <input type="text" id="UserName" name="Name" onblur="testName()" placeholder="Only letters and numbers and length in 4-16">


                <div class="content">E-mail:</div>
                <input type="text" id="Email" name="Email" onblur="testEmail()" placeholder="jsmith@example.com">

                <div class="content">Password:</div>
                <input type="password" id="Password" name="Password" onblur="testPass()" placeholder="At least numbers and letters and length>=8">

                <div class="content">Confirm Your Password:</div>
                <input type="password" id="confirm" name="confirm" onblur="testConfirm()" placeholder="Enter the password again"><br>

                <input type='submit' id="submit" value='Sign up' class='form-control' />
        </form>
    </div>
</main>
<footer class="footerBottom">
    <p class="copyright">Copyright © 2019-2021 Gaoxiangxing. All Rights Reserved. 备案号：17300290033</p>
</footer>
</body>
<script>

    //密码
    var password;
    //提交验证需要全部为true
    var name=false;
    var email=false;
    var pass=false;
    var conf=false;
    //初始化提交
    document.getElementById("submit").disabled=true;


    function testName() {
        var userName = document.getElementById("UserName").value;
        var regName = /\w{4,16}/;
        if(userName==""||userName.trim()==""){
            document.getElementById("tips").innerHTML="Please enter UserName"
            document.getElementById("tips").style.color='red';
        }else if(!regName.test(userName)){
            document.getElementById("tips").innerHTML="UserName is illegal !"
            document.getElementById("tips").style.color='red';
        }else{
            document.getElementById("tips").innerHTML="UserName is valid"
            document.getElementById("tips").style.color='blue';
            name=true;
        }
        if(name&&email&&pass&&conf){
            document.getElementById("submit").disabled=false;
        }else{
            document.getElementById("submit").disabled=true;
        }
    }

    function testEmail() {
        var emailAdddress = document.getElementById("Email").value;
        var regEmail=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
        if(emailAdddress==""||emailAdddress.trim()==""){
            document.getElementById("tips").innerHTML="Please enter Email"
            document.getElementById("tips").style.color='red';
        }else if(!regEmail.test(emailAdddress)){
            document.getElementById("tips").innerHTML="Email is illegal !"
            document.getElementById("tips").style.color='red';
        }else{
            document.getElementById("tips").innerHTML="Email is valid"
            document.getElementById("tips").style.color='blue';
            email=true;
        }
        if(name&&email&&pass&&conf){
            document.getElementById("submit").disabled=false;
        }else{
            document.getElementById("submit").disabled=true;
        }
    }

    function testPass() {
        password=document.getElementById("Password").value;
        if(password==""||password.trim()==""){
            document.getElementById("tips").innerHTML="Please enter Password"
            document.getElementById("tips").style.color='red';
        }else if(password.length<8){
            document.getElementById("tips").innerHTML="Password is too weak !"
            document.getElementById("tips").style.color='red';
        }else{
            document.getElementById("tips").innerHTML="Password is valid"
            document.getElementById("tips").style.color='blue';
            pass=true;
        }
        if(name&&email&&pass&&conf){
            document.getElementById("submit").disabled=false;
        }else{
            document.getElementById("submit").disabled=true;
        }
    }

    function testConfirm() {
        var confirm=document.getElementById("confirm").value;
        if(confirm==""||confirm.trim()==""){
            document.getElementById("tips").innerHTML="Please confirm Password"
            document.getElementById("tips").style.color='red';
        }else if(confirm!=password){
            document.getElementById("tips").innerHTML="Two passwords are different !"
            document.getElementById("tips").style.color='red';
        }else{
            document.getElementById("tips").innerHTML="Two passwords are the same"
            document.getElementById("tips").style.color='blue';
            conf=true;
        }
        if(name&&email&&pass&&conf){
            document.getElementById("submit").disabled=false;
        }else{
            document.getElementById("submit").disabled=true;
        }
    }


</script>
</html>