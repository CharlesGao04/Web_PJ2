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

$json_string = file_get_contents(‘country.json’);
$data = json_decode($json_string, true);


$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if ( mysqli_connect_errno() ) {
    die( mysqli_connect_error() );
}

$sql = "SELECT AsciiName,GeoNameID,CountryCodeISO FROM geocities Order by CountryCodeISO";
$query=mysqli_query($connection,$sql);
$result = $connection->query($sql);

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
    file_put_contents('city.json', $json);
    echo 'city.json generate success!';
    //echo "{".'"country"'.":".$json."}";
}else{
    echo "查询失败";
}
?>
