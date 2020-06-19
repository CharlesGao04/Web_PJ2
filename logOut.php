<?php
session_start();
unset($_SESSION['user']);
//setcookie("Username", "", -1);
header('location:php/login.php');
?>