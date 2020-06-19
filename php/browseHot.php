<?php
session_start();
$_SESSION['hot']=$_GET['hot'];
$_SESSION['choosetype']=2;
$_SESSION['hottype']=$_GET['hottype'];
header("location:browse.php");
?>