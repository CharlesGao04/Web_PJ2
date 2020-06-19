<?php

session_start();
require_once('config.php');

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if ( mysqli_connect_errno() ) {
    die(mysqli_connect_error());
}

if(isset($_POST['ImageID'])){
    $ImageID=$_POST['ImageID'];
}else{
    $sql="select count(*) as mid from travelimage";
    $result = mysqli_query($connection, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $mid=$row['mid'];
    }
    $ImageID=$mid+2;
}

//echo $ImageID;

$UID=$_SESSION['UID'];
$PATH=$_POST['PATH'];

$Title=$_POST['Title'];
$Description=$_POST['Description'];

$Country=$_POST['country'];
$City=$_POST['city'];
$Content=$_POST['content'];

$sql = "select ISO From geocountries where CountryName='".$Country."'";

//根据countryName读取countryCodeISO
$result = mysqli_query($connection, $sql);
while($row = mysqli_fetch_assoc($result)){
    $CountryCode=$row['ISO'];
}

//根据cityName读取cityCode
$sql = "select GeoNameID From geocities where AsciiName='".$City."'";
$result = mysqli_query($connection, $sql);
while($row = mysqli_fetch_assoc($result)){
    $CityCode=$row['GeoNameID'];
}

if(isset($_POST['ImageID'])){
    $sql="UPDATE travelimage SET Title='".$Title."',Description='".$Description."',CityCode='".$CityCode."',
          CountryCodeISO='".$CountryCode."',UID='".$UID."',PATH='".$PATH."',Content='".$Content."'
          WHERE travelimage.ImageID='".$ImageID."'";
}else{
    $sql="INSERT INTO travelimage (ImageID, Title, Description, CityCode, CountryCodeISO, UID, PATH, Content) 
    VALUES ('$ImageID', '$Title', '$Description', '$CityCode', '$CountryCode', '$UID', '$PATH', '$Content')";
}

mysqli_query($connection, $sql);
mysqli_close($connection);

header("location:upload.php?hint=1");
?>