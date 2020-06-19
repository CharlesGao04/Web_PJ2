<?php
session_start();
if (empty($_SESSION['user'])){
     header('location:php/login.php');
}else{
    echo 'test';
}
?>
