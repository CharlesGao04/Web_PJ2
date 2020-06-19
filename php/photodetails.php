<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" user-scalable=no" />
    <title>PhotoDetails</title>
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/photodetails.css">
</head>
<body>
<div class="top">
    <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="browse.php" id="Now">Browse</a></li>
        <li><a href="search.php">Search</a></li>
        <?php
        session_start();
        if (empty($_SESSION['user'])){
            echo "<li id=\"myAccount\"><a href=\"../localLogin.php\">Login</a>";
        }else{
            echo "<li id=\"myAccount\"><a>My Account</a>
            <ul class=\"dropDown\">
                <li id=\"upload\"><a href=\"upload.php\"><i class=\"fa fa-cloud-upload\" aria-hidden=\"true\"></i>Upload</a></li>
                <li id=\"photos\"><a href=\"myphoto.php\"><i class=\"fa fa-star\" aria-hidden=\"true\"></i></i>My Photos</a></li>
                <li id=\"favor\"><a href=\"myfavor.php\"><i class=\"fa fa-heart\" aria-hidden=\"true\"></i>My Favor</a></li>
                <li id=\"logIn\"><a href=\"../logOut.php\"><i class=\"fa fa-sign-in\" aria-hidden=\"true\"></i>Log out</a></li>
            </ul>
        </li>";
        }
        ?>
    </ul>
</div>

<div class="detail">
    <div class="detailTitle">Details</div>
        <?php

        session_start();
        require_once('config.php');
        header("content-type:text/html;charset=utf8");

        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if ( mysqli_connect_errno() ) {
            die(mysqli_connect_error());
        }


        if($_GET['imageID']!=''){
            $_SESSION['imageID']=$_GET['imageID'];
            $fresh=true;
        }else{
            $fresh=false;
        }
        $id=$_SESSION['imageID'];

        $sql = "select ImageID,PATH,Description,CountryCodeISO,CityCode,Content,Title,UID 
                from travelimage 
                WHERE ImageID='".$id."'";
        $result = mysqli_query($connection, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $ImageID=$row['ImageID'];
            $PATH=$row['PATH'];
            $Description=$row['Description'];
            $CountryISO=$row['CountryCodeISO'];
            $CityCode=$row['CityCode'];
            $Content=$row['Content'];
            $Title=$row['Title'];
            $UID=$row['UID'];
        }
        $sql = "select CountryName From geocountries where ISO='".$CountryISO."'";
        $result = mysqli_query($connection, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $Country=$row['CountryName'];
        }
        $sql = "select AsciiName From geocities where GeoNameID='".$CityCode."'";
        $result = mysqli_query($connection, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $City=$row['AsciiName'];
        }
        $sql = "select UserName From traveluser where UID='".$UID."'";
        $result = mysqli_query($connection, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $UserName=$row['UserName'];
        }
        $sql = "SELECT imageID,COUNT(ImageID) as mid FROM travelimagefavor where imageID='".$ImageID."'";
        $result = mysqli_query($connection, $sql);
        if($_SESSION['likeNumber']==0||empty($_SESSION['likeNumber'])||$fresh){
            while($row = mysqli_fetch_assoc($result)){
                $likeNumber=$row['mid'];
            }
            $_SESSION['likeNumber']=$likeNumber;
        }else {
            $likeNumber=$_SESSION['likeNumber'];
        }

        echo '<div class="detailContent">';
        echo '<div class="littleTitle">'.$Title.'</div>';
        echo '<div class="by">By&nbsp   '.$UserName.'</div>';
        echo '<img src="../images/normal/medium/'.$PATH.'"class="pictureDetail">';
        echo '<div class="detailDescrip">';
        echo '<div>';
        echo '<table class="table1">';
        echo '<tr><th>Like Nmuber</th></tr>';
        echo '<tr><td>'.$likeNumber.'</a></td></tr>';
        echo '</table>';
        echo '</div>';
        echo '<div>';
        echo '<table class="table2">';
        echo '<tr><th>Image Details</th></tr>';
        echo '<tr><td>Content: '.$Content.'</a></td></tr>';
        echo '<tr><td>Country: '.$Country.'</td></tr>';
        echo '<tr><td>City: '.$City.'</td></tr>';
        echo '</table>';
        echo '</div>';
        if ($_SESSION['collect']==1){
            echo '<form method="post" action="photodetailsHelp.php">';
            echo '<button class="favorite">No Collect</button>';
            echo '</form>';
        }else if($_SESSION['collect']==2){
            echo '<form method="post" action="photodetailsHelp.php">';
            echo '<button class="favorite">Already Collected</button>';
            echo '</form>';
        }
        echo '</div>';
        echo '</div>';
        echo '<div class="contentBottom">';
        echo '<p id="desBottom">'.$Description.'</p>';
        echo '</div>';
        ?>

</div>

</body>

<footer>
    <div>
        <div>
            <p>使用条款</p><br>
            <p>隐私保护</p><br>
            <p>Cookie</p>
        </div>
        <div>
            <p>关于</p><br>
            <P>联系我们</P><br>
        </div>
        <div>
            <p>Copyright &copy 2019-2021 GaoXiangxing </p><br>
            <p>All rights reserved.</p><br>
            <p> 备案号：17300290033</p>
        </div>
        <div>
            <p>
                <img id="wechat" src="../images/background/WechatID.jpg" />
            </p>
        </div>
    </div>
</footer>
</html>