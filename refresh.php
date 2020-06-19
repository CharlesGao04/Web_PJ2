<?php

session_start();
$_SESSION['fresh']=1;
header('location:index.php');

?>