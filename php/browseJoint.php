<?php
require_once('config.php');
session_start();
header("content-type:text/html;charset=utf8");
$json = '';
$data = array();
class City
{
    public $AsciiName;
    public $GeoNameID;
    public $CountryCodeISO;
}

$Country=$_POST['Country'];

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if ( mysqli_connect_errno() ) {
    die( mysqli_connect_error() );
}



$sql = "select ISO From geocountries where CountryName='".$Country."'";
$result = mysqli_query($connection, $sql);
while($row = mysqli_fetch_assoc($result)){
    $CountryCode=$row['ISO'];
}

$sql = "SELECT AsciiName,GeoNameID,CountryCodeISO FROM geocities where CountryCodeISO='".$CountryCode."'order by Population DESC limit 0,20";
$query=mysqli_query($connection,$sql);
$result = $connection->query($sql);

/*test
$Country=$_POST['Country'];
$city = new City();
$city->AsciiName = "hao";
$city->GeoNameID = "43ds";
$city->CountryCodeISO = "12323";
$data[]=$city;
$json = json_encode($data);
echo $json;
*/
if($result){
//echo "查询成功";
    while ($row = mysqli_fetch_array($result))
    {
        $city = new City();
        $city->AsciiName = $row['AsciiName'];
        $city->GeoNameID = $row['GeoNameID'];
        $city->CountryCodeISO = $row['CountryCodeISO'];
        $data[]=$city;
    }
    $json = json_encode($data);//把数据转换为JSON数据.
    echo $json;
    //echo "{".'"country"'.":".$json."}";
}else{
    echo "查询失败";
}

?>
