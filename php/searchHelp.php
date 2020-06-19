<?php
session_start();
$_SESSION['searchChoose']=1;
$_SESSION['searchWay']=$_POST['searchWay1'];
$_SESSION['searchTitle']=$_POST['searchTitle'];
$_SESSION['searchDescription']=$_POST['searchDescription'];
header("location:search.php");
?>