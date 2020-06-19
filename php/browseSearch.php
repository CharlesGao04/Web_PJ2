<?php
session_start();
$_SESSION['choosetype']=1;
$_SESSION['Title']=$_POST['searchContent'];
header("location:browse.php");
?>