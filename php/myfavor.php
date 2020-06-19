<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" user-scalable=no" />
    <title>MyFavor</title>
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/myfavor.css">
</head>
<body>
<div class="top">
    <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="browse.php">Browse</a></li>
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

<div class="favor">
    <div class="favorTitle">My Favorite</div>
    <?php
    header("content-type:text/html;charset=utf8");
    require_once('config.php');

    session_start();

    if(isset($_SESSION['UID'])){
        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if ( mysqli_connect_errno() ) {
            die(mysqli_connect_error());
        }

        $UID=$_SESSION['UID'];

        $sql ="select * from (SELECT imageID,UID FROM travelimagefavor where UID='".$UID."')table1 
        left join(select PATH,ImageID,Title,Description from travelimage) table2  
        on table1.imageID = table2.imageID";
        $result = mysqli_query($connection, $sql);


        if($result)
            $totalCount = $result->num_rows;
        else
            $totalCount = 0;

        if($totalCount>0){
            $pageSize = 4;
            $totalPage = 5;
            if(!isset($_GET['page']))
                $currentPage = 1;
            else
                $currentPage = $_GET['page'];

            $mark = ($currentPage-1)*$pageSize;
            $firstPage = 1;
            $lastPage = $totalPage;
            $prePage = ($currentPage>1)?$currentPage-1:1;
            $nextPage = ($totalPage-$currentPage>0)?$currentPage+1:$totalPage;

            $sql = "select * from (SELECT ImageID,UID FROM travelimagefavor where UID='".$UID."')table1 
                    left join(select PATH,ImageID,Title,Description from travelimage) table2  
                    on table1.ImageID = table2.ImageID limit ".$mark.",".$pageSize;
            $result = mysqli_query($connection, $sql);
            $j=0;

            while($j<$pageSize&&$row = mysqli_fetch_assoc($result)){
                outputSinglePic($row);
                $j++;
            }

            //Bottom
            echo '<div class="bottom">';
            echo '<a href="myfavor.php?page='.$prePage.'"> &#60&#60 </a>';
            if (!isset($_GET['page'])){
                $_GET['page']=1;
            }
            if($_GET['page']==1){
                echo '
                              <a href="myfavor.php?page=1" id="on"> 1 </a>
                              <a href="myfavor.php?page=2"> 2 </a>
                              <a href="myfavor.php?page=3"> 3 </a>
                              <a href="myfavor.php?page=4"> 4 </a>
                              <a href="myfavor.php?page=5"> 5 </a>
                              ';
            }else if($_GET['page']==2){
                echo '
                              <a href="myfavor.php?page=1"> 1 </a>
                              <a href="myfavor.php?page=2" id="on"> 2 </a>
                              <a href="myfavor.php?page=3"> 3 </a>
                              <a href="myfavor.php?page=4"> 4 </a>
                              <a href="myfavor.php?page=5"> 5 </a>
                              ';
            }else if($_GET['page']==3){
                echo '
                              <a href="myfavor.php?page=1"> 1 </a>
                              <a href="myfavor.php?page=2"> 2 </a>
                              <a href="myfavor.php?page=3" id="on"> 3 </a>
                              <a href="myfavor.php?page=4"> 4 </a>
                              <a href="myfavor.php?page=5"> 5 </a>
                              ';
            }else if($_GET['page']==4){
                echo '
                              <a href="myfavor.php?page=1"> 1 </a>
                              <a href="myfavor.php?page=2"> 2 </a>
                              <a href="myfavor.php?page=3"> 3 </a>
                              <a href="myfavor.php?page=4" id="on"> 4 </a>
                              <a href="myfavor.php?page=5"> 5 </a>
                              ';
            }else if($_GET['page']==5){
                echo '
                              <a href="myfavor.php?page=1"> 1 </a>
                              <a href="myfavor.php?page=2"> 2 </a>
                              <a href="myfavor.php?page=3"> 3 </a>
                              <a href="myfavor.php?page=4"> 4 </a>
                              <a href="myfavor.php?page=5" id="on"> 5 </a>
                              ';
            }
            echo '<a href="myfavor.php?page='.$nextPage.'"> &#62&#62 </a>';
            echo '</div>';
        }else{
            echo '<div class="hint">';
            echo 'No favorite photos, Go to add one!';
            echo '</div>';
        }
    }

    function outputSinglePic($row) {
        $title=$row['Title'];
        $description=$row['Description'];
        $ImageID=$row['ImageID'];
        echo '<div class="favorDetail">';
        echo constructPicLink($row['ImageID'],$row['PATH']);
        echo '<div class="content">';
        echo '<h2 class="littleTitle">'."$title".'</h2>';
        echo '<p class="word1">'."$description".'</p>';
        echo '<form method="post" action="myfavorHelp.php?ImageID='.$ImageID.'">';
        echo '<button class="deleteButton" onclick="alert(\'Delete Successfully!\')">Delete</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }

    function constructPicLink($id, $label) {
        $link = '<a href="photodetails.php?imageID=' . $id . '">';
        $link .='<img src="../images/normal/medium/';
        $link .= $label;
        $link .= '"';
        $link .='class="pic"></a>';
        return $link;
    }
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