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
$sql="SELECT UserName,Pass,UID From traveluser WHERE (UserName='$name')AND (Pass='$pass')";
$query=mysqli_query($connection,$sql);
$result = $connection->query($sql);
if ($result->num_rows > 0){
    $expiryTime = time()+60*60*24;
    while($row = mysqli_fetch_assoc($result)){
        $_SESSION['UID']= $row['UID'];
    }
    $_SESSION['user'] = $name;
    $_SESSION['fresh'] ='';
    $_SESSION['choosetype']='';
    $_SESSION['Title']='';
    $_SESSION['collect']=1;

    header('location:../index.php');
}else{
    header('location:login.php?login=1');
}
?>