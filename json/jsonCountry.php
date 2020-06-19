<?php
require_once('config.php');
session_start();
header("content-type:text/html;charset=utf8");
$json = '';
$data = array();
class Country
{
    public $ISO;
    public $CountryName;
}
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if ( mysqli_connect_errno() ) {
    die( mysqli_connect_error() );
}

$sql = "SELECT CountryName,ISO FROM geocountries ORDER BY CountryName";
$query=mysqli_query($connection,$sql);
$result = $connection->query($sql);


if($result){
//echo "查询成功";
    while ($row = mysqli_fetch_array($result))
    {
        $country = new Country();
        $country->ISO = $row['ISO'];
        $country->CountryName=$row['CountryName'];
        $data[]=$country;
    }
    $json = json_encode($data);//把数据转换为JSON数据.
    file_put_contents('country.json', $json);
    echo 'country.json generate success!';
    //echo "{".'"country"'.":".$json."}";
}else{
    echo "查询失败";
}
?>