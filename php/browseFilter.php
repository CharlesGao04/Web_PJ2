<?php
session_start();
require_once('config.php');
$_SESSION['choosetype']=3;

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if ( mysqli_connect_errno() ) {
    die( mysqli_connect_error() );
}

$country=$_POST['countrySelected'];
$city=$_POST['citySelected'];



$sql = "select GeoNameID from (select GeoNameID,AsciiName,CountryCodeISO from geocities where AsciiName='".$city."') table1 left join(SELECT ISO,CountryName FROM geocountries where CountryName='".$country."')table2 on table1.CountryCodeISO = table2.ISO";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$_SESSION['content']=$_POST['contentSelected'];
$_SESSION['citycode']=$row['GeoNameID'];



header("location:browse.php");
?>