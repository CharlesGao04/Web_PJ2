<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" user-scalable=no" />
    <title>Home</title>
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/home.css">
</head>
<body>

<div class="top">
    <ul>
        <li><a href="index.php" id="Now">Home</a></li>
        <li><a href="php/browse.php">Browse</a></li>
        <li><a href="php/search.php">Search</a></li>
        <?php
        session_start();
        if (empty($_SESSION['user'])){
            echo "<li id=\"myAccount\"><a href=\"localLogin.php\">Login</a>";
        }else{
            echo "<li id=\"myAccount\"><a>My Account</a>
            <ul class=\"dropDown\">
                <li id=\"upload\"><a href=\"php/upload.php\"><i class=\"fa fa-cloud-upload\" aria-hidden=\"true\"></i>Upload</a></li>
                <li id=\"photos\"><a href=\"php/myphoto.php\"><i class=\"fa fa-star\" aria-hidden=\"true\"></i></i>My Photos</a></li>
                <li id=\"favor\"><a href=\"php/myfavor.php\"><i class=\"fa fa-heart\" aria-hidden=\"true\"></i>My Favor</a></li>
                <li id=\"logIn\"><a href=\"logOut.php\"><i class=\"fa fa-sign-in\" aria-hidden=\"true\"></i>Log out</a></li>
            </ul>
        </li>";
        }
        ?>
    </ul>
</div>

<div>
    <a href="#">
        <img id="backtotop" width="50px" height="50px" src="images/icons/backtotop.png"/>
    </a>
    <form action="refresh.php" method="post">
        <input id="refresh" type="image" onClick="document.formName.submit()" src="images/icons/refresh.png" width="50px" height="50px">
    </form>
    <img id="topPic" src="images/background/top.jpg">
</div>

<div class="pictureBorder">
    <?php
    header("content-type:text/html;charset=utf8");
    require_once('php/config.php');

    session_start();
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if ( mysqli_connect_errno() ) {
        die( mysqli_connect_error() );
    }

    if(empty($_SESSION['fresh'])){
        $sql1="select * from (select Title,Description,PATH,ImageID from travelimage) table1 
        left join(SELECT imageID,COUNT(ImageID) as mid 
        FROM travelimagefavor group by ImageID ORDER BY mid DESC)table2 
        on table1.imageID = table2.imageID";
        $result=mysqli_query($connection,$sql1);
        $num=0;
        while($num<6&&$row = mysqli_fetch_assoc($result)){
            outputSinglePic($row);
            $num++;
        }
    }else{
        $sql2="select Title,Description,PATH,ImageID from travelimage ORDER BY RAND()";
        $result=mysqli_query($connection,$sql2);
        $number=0;
        while($number<6&&$row = mysqli_fetch_assoc($result)){
            outputSinglePic($row);
            $number++;
        }
    }

    function outputSinglePic($row) {
        $title=$row['Title'];
        $description=$row['Description'];
        echo '<div>';
        echo constructPicLink($row['ImageID'],$row['PATH']);
        echo '<p class="title">'."$title".'</p>';
        echo '<p class="word">'."$description".'</p>';
        echo '</div>';
    }

    function constructPicLink($id, $label) {
        $link = '<a href="php/photodetails.php?imageID=' . $id . '">';
        $link .='<img src="images/normal/medium/';
        $link .= $label;
        $link .= '"';
        $link .='class="picture1"></a>';
        return $link;
    }
    ?>
</div>

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
                <img id="wechat" src="images/background/WechatID.jpg" />
            </p>
        </div>
    </div>
</footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</html>