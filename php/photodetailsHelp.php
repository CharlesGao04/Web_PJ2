<?php
session_start();

if($_SESSION['collect']==1){
    $_SESSION['collect']=2;
    $_SESSION['likeNumber']+=1;
}else if($_SESSION['collect']==2){
    $_SESSION['collect']=1;
    $_SESSION['likeNumber']-=1;
}

header("location:photodetails.php");
?>