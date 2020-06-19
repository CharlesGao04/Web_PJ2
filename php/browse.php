<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" user-scalable=no" />
    <title>Browse</title>
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/browse.css">

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
<section>
    <div class="leftColumn">
        <div class="sideSearch">
            <p class="searchTitle">Search By Title</p>
            <form method="post" action="browseSearch.php"  name="searchTitle" >
                <input type="text" name="searchContent">
                <input type="submit" id="btn"  onmousedown="initAreaData()" value="Search">
            </form>
        </div>

        <div class="hotCountry">
            <p>Hot Country</p>
            <table>
                <tr><th><a href="browseHot.php?hot=CA&hottype=1">Canada</a></th></tr>
                <tr><th><a href="browseHot.php?hot=DE&hottype=1">Germany</a></th></tr>
                <tr><th><a href="browseHot.php?hot=BS&hottype=1">Bahamas</a></th></tr>
                <tr><th><a href="browseHot.php?hot=ES&hottype=1">Spain</a></th></tr>
            </table>
        </div>
        <div class="hotCity">
            <p> Hot City</p>
            <table  style="margin-left: 90px">
                <tr><th><a href="browseHot.php?hot=3176959&hottype=2"> Firenze</a></th></tr>
                <tr><th><a href="browseHot.php?hot=3169070&hottype=2">Roma</a></th></tr>
                <tr><th><a href="browseHot.php?hot=2643743&hottype=2">London</a></th></tr>
                <tr><th><a href="browseHot.php?hot=5913490&hottype=2">Calgary</a></th></tr>
            </table>
        </div>
        <div class="hotContent">
            <p> Hot Content</p>
            <table>
                <tr><th><a href="browseHot.php?hot=scenery&hottype=3">Scenery</a></th></tr>
                <tr><th><a href="browseHot.php?hot=building&hottype=3">Building</a></th></tr>
                <tr><th><a href="browseHot.php?hot=sea&hottype=3">Sea</a></th></tr>
                <tr><th><a href="browseHot.php?hot=people&hottype=3">People</a></th></tr>
            </table>
        </div>

    </div>

<div id="Filter">
    <table>
        <tr>
            <th class="filterTitle">FILTER</th>
        </tr>
        <tr>
            <td>
                <div class="formSelect">
                    <form name="formClass" method="post" action="browseFilter.php">
                        <select name="contentSelected">
                            <option  selected hidden>Content</option>
                            <option value="scenery">Scenery</option>
                            <option value="city">City</option>
                            <option value="people">People</option>
                            <option value="animal">Animal</option>
                            <option value="building">Building</option>
                            <option value="wonder">Wonder</option>
                            <option value="other">Other</option>
                        </select>
                        <select id="country" name="countrySelected" onchange="linkage()">
                            <option value="" selected hidden>Country</option>
                            <option value="China">China</option>
                            <option value="Canada">Canada</option>
                            <option value="Italy">Italy</option>
                            <option value="United Kingdom">United Kingdom</option>
                        </select>
                        <select  id="city" name="citySelected">
                            <option value="" selected hidden>City</option>
                        </select>
                        <button class="filterButton">Filter</button>
                    </form>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="pictures">
                    <?php
                    session_start();
                    require_once('config.php');

                    if(isset($_SESSION['choosetype'])){
                        if($_SESSION['choosetype']==1){
                            $title=$_SESSION['Title'];
                            $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                            if ( mysqli_connect_errno() ) {
                                die( mysqli_connect_error() );
                            }
                            $sql = "select ImageID,PATH from travelimage WHERE Title LIKE '%".$title."%'";
                            $result = mysqli_query($connection, $sql);

                            if($result)
                                $totalCount = $result->num_rows;
                            else
                                $totalCount = 0;

                            if($totalCount>0){
                                $pageSize = 16;
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

                                $sql = "select ImageID,PATH from travelimage WHERE Title LIKE '%".$title."%' limit ".$mark.",".$pageSize;
                                $result = mysqli_query($connection, $sql);
                                $j=0;
                                while($j<$pageSize&&$row = mysqli_fetch_assoc($result)){
                                    outputPic($row);
                                    $j++;
                                }
                            }

                        }else if($_SESSION['choosetype']==2){
                            if($_SESSION['hottype']==1){
                                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                                if ( mysqli_connect_errno() ) {
                                    die( mysqli_connect_error() );
                                }
                                $country=$_SESSION['hot'];
                                $sql = "select ImageID,PATH from travelimage WHERE CountryCodeISO='".$country."'";
                                $result = mysqli_query($connection, $sql);

                                if($result)
                                    $totalCount = $result->num_rows;
                                else
                                    $totalCount = 0;

                                if($totalCount>0){
                                    $pageSize = 16;
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

                                    $sql = "select ImageID,PATH from travelimage WHERE CountryCodeISO='".$country."' limit ".$mark.",".$pageSize;
                                    $result = mysqli_query($connection, $sql);
                                    $j=0;
                                    while($j<$pageSize&&$row = mysqli_fetch_assoc($result)){
                                        outputPic($row);
                                        $j++;
                                    }
                                }
                            }else if($_SESSION['hottype']==2){
                                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                                if ( mysqli_connect_errno() ) {
                                    die( mysqli_connect_error() );
                                }
                                $city=$_SESSION['hot'];
                                $sql = "select ImageID,PATH from travelimage WHERE CityCode='".$city."'";
                                $result = mysqli_query($connection, $sql);

                                if($result)
                                    $totalCount = $result->num_rows;
                                else
                                    $totalCount = 0;

                                if($totalCount>0){
                                    $pageSize = 16;
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

                                    $sql = "select ImageID,PATH from travelimage WHERE CityCode='".$city."' limit ".$mark.",".$pageSize;
                                    $result = mysqli_query($connection, $sql);
                                    $j=0;
                                    while($j<$pageSize&&$row = mysqli_fetch_assoc($result)){
                                        outputPic($row);
                                        $j++;
                                    }
                                }
                            }else if($_SESSION['hottype']==3){
                                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                                if ( mysqli_connect_errno() ) {
                                    die( mysqli_connect_error() );
                                }
                                $content=$_SESSION['hot'];
                                $sql = "select ImageID,PATH from travelimage WHERE Content='".$content."'";
                                $result = mysqli_query($connection, $sql);

                                if($result)
                                    $totalCount = $result->num_rows;
                                else
                                    $totalCount = 0;

                                if($totalCount>0){
                                    $pageSize = 16;
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

                                    $sql = "select ImageID,PATH from travelimage WHERE Content='".$content."' limit ".$mark.",".$pageSize;
                                    $result = mysqli_query($connection, $sql);
                                    $j=0;
                                    while($j<$pageSize&&$row = mysqli_fetch_assoc($result)){
                                        outputPic($row);
                                        $j++;
                                    }
                                }
                            }
                        }else if($_SESSION['choosetype']==3){
                            $citycode=$_SESSION['citycode'];
                            $contentSec=$_SESSION['content'];
                            $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                            if ( mysqli_connect_errno() ) {
                                die( mysqli_connect_error() );
                            }

                            $sql = "select ImageID,PATH from travelimage WHERE CityCode='".$citycode."'AND Content='".$contentSec."'";
                            $result = mysqli_query($connection, $sql);

                            if($result)
                                $totalCount = $result->num_rows;
                            else
                                $totalCount = 0;

                            if($totalCount>0){
                                $pageSize = 16;
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

                                $sql = "select ImageID,PATH from travelimage WHERE CityCode='".$citycode."'AND Content='".$contentSec."'"."limit ".$mark.",".$pageSize;
                                $result = mysqli_query($connection, $sql);
                                $j=0;
                                while($j<$pageSize&&$row = mysqli_fetch_assoc($result)){
                                    outputPic($row);
                                    $j++;
                                }
                            }
                        }else{
                            echo 'wrong';
                        }
                    }

                    function outputPic($row){
                        echo constructPicLink($row['ImageID'],$row['PATH']);
                    }

                    function constructPicLink($id, $label) {
                        $link = '<a href="photodetails.php?imageID=' . $id . '">';
                        $link .='<img src="../images/normal/medium/';
                        $link .= $label;
                        $link .= '"';
                        $link .=' class="picture1"/></a>';
                        return $link;
                    }
                    ?>
                </div>
                <div class="bottom">
                    <a href="browse.php?page=<?php echo $prePage; ?>"> &#60&#60 </a>
                    <?php
                    if (!isset($_GET['page'])){
                        $_GET['page']=1;
                    }
                    if($_GET['page']==1){
                        echo '
                              <a href="browse.php?page=1" id="span"> 1 </a>
                              <a href="browse.php?page=2"> 2 </a>
                              <a href="browse.php?page=3"> 3 </a>
                              <a href="browse.php?page=4"> 4 </a>
                              <a href="browse.php?page=5"> 5 </a>
                              ';
                    }else if($_GET['page']==2){
                        echo '
                              <a href="browse.php?page=1"> 1 </a>
                              <a href="browse.php?page=2" id="span"> 2 </a>
                              <a href="browse.php?page=3"> 3 </a>
                              <a href="browse.php?page=4"> 4 </a>
                              <a href="browse.php?page=5"> 5 </a>
                              ';
                    }else if($_GET['page']==3){
                        echo '
                              <a href="browse.php?page=1"> 1 </a>
                              <a href="browse.php?page=2"> 2 </a>
                              <a href="browse.php?page=3" id="span"> 3 </a>
                              <a href="browse.php?page=4"> 4 </a>
                              <a href="browse.php?page=5"> 5 </a>
                              ';
                    }else if($_GET['page']==4){
                        echo '
                              <a href="browse.php?page=1"> 1 </a>
                              <a href="browse.php?page=2"> 2 </a>
                              <a href="browse.php?page=3"> 3 </a>
                              <a href="browse.php?page=4" id="span"> 4 </a>
                              <a href="browse.php?page=5"> 5 </a>
                              ';
                    }else if($_GET['page']==5){
                        echo '
                              <a href="browse.php?page=1"> 1 </a>
                              <a href="browse.php?page=2"> 2 </a>
                              <a href="browse.php?page=3"> 3 </a>
                              <a href="browse.php?page=4"> 4 </a>
                              <a href="browse.php?page=5" id="span"> 5 </a>
                              ';
                    }
                    ?>
                    <a href="browse.php?page=<?php echo $nextPage; ?>"> &#62&#62 </a>
                </div>
            </td>
        </tr>
    </table>

</div>
</section>
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
<script>

    window.onload = function(){
        var url = "country.json"
        var request = new XMLHttpRequest();
        request.open("get", url);
        request.send(null);
        request.onload = function (){
            var jsonHelp = JSON.parse(request.responseText);
            var countryHelp=[];
            for(var i=0; i<252; i++){
                countryHelp[i]=jsonHelp[i].CountryName;
            }
            var selectCountry = document.formClass.country;
            selectCountry.length=1;
            for(var i=0; i < countryHelp.length; i++){
                selectCountry[i+1]=new Option(countryHelp[i],countryHelp[i]);
            }
        }
    }


    function linkage() {

        var xhr = new XMLHttpRequest();
        //xhr.onreadystatechange = callback;
        //get
         xhr.open("post", "browseJoint.php", true);
         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //send
         var midCountry = document.formClass.country;
         var countryName=midCountry.value;

        xhr.send("Country="+countryName);
        xhr.onload = function () {
            var res = JSON.parse(xhr.responseText);
            var cityHelp=[];
            for(var i=0; i<20; i++){
                cityHelp[i]=res[i].AsciiName;
            }
            var selectCity = document.formClass.city;
            selectCity.length = 1;
            for(var i=0; i < 20; i++){
                selectCity[i+1] = new Option(cityHelp[i],cityHelp[i]);
            }
        }
    }

</script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</html>
