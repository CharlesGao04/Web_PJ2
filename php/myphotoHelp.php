<?php
session_start();
require_once('config.php');

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if ( mysqli_connect_errno() ) {
    die(mysqli_connect_error());
}
$ImageID=$_GET['ImageID'];
$UID=$_SESSION['UID'];

$sql="DELETE FROM travelimage WHERE UID='".$UID."' AND ImageID='".$ImageID."'";
mysqli_query($connection, $sql);
mysqli_close($connection);
header("location:myphoto.php");
?>
