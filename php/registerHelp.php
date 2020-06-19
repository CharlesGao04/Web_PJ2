<?php
require_once('config.php');
session_start();
header("content-type:text/html;charset=utf8");
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if ( mysqli_connect_errno() ) {
    die( mysqli_connect_error() );
}
$name=$_POST['Name'];
$originPass=$_POST['Password'];
$pass=md5($originPass,"gaoxiangxing");
$email=$_POST['Email'];
$sql1="SELECT UserName From traveluser WHERE (UserName='$name')";
$query=mysqli_query($connection,$sql1);
$result = $connection->query($sql1);
if($result->num_rows > 0){
    header("location:register.php?login=1");
}else{
    $sql2="INSERT INTO traveluser(UserName,Pass,Email) VALUES('$name','$pass','$email')";
    if(mysqli_query($connection,$sql2)){
        header("location:login.php");
    }else{
        echo mysqli_error(),'<br />';
        echo "<script>alert(\"Sorry, mysqli wrong, please try again\");</script>";
        header("location:register.php");
    }
}
?>