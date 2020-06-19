<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" user-scalable=no"/>
    <title>Upload</title>
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/upload.css">
</head>
<body>
<?php
header("content-type:text/html;charset=utf8");
require_once('config.php');

session_start();

if (isset($_GET['hint'])) {
    echo '<script>alert("Upload Success!");</script>';
}

if (isset($_GET['ImageID'])) {

    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if (mysqli_connect_errno()) {
        die(mysqli_connect_error());
    }
    $ImageID = $_GET['ImageID'];


    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if (mysqli_connect_errno()) {
        die(mysqli_connect_error());
    }

    $sql = "select PATH,ImageID,Title,Description,Content,CountryCodeISO,CityCode 
               from travelimage 
               where ImageID='" . $ImageID . "'";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $PATH = $row['PATH'];
        $Description = $row['Description'];
        $CountryISO = $row['CountryCodeISO'];
        $CityCode = $row['CityCode'];
        $Content = $row['Content'];
        $Title = $row['Title'];
    }

    $sql = "select CountryName From geocountries where ISO='" . $CountryISO . "'";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $Country = $row['CountryName'];
    }
    $sql = "select AsciiName From geocities where GeoNameID='" . $CityCode . "'";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $City = $row['AsciiName'];
    }

    $_SESSION['Country']=$Country;
    $_SESSION['CityName']=$City;
    //Upload改为Modify
    //测试用：echo "<script>alert(\"success\")</script>";
}


?>

<div class="top">
    <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="browse.php">Browse</a></li>
        <li><a href="search.php">Search</a></li>
        <li id="myAccount"><a>My Account</a>
            <ul class="dropDown">
                <li id="upload"><a href="upload.php"><i class="fa fa-cloud-upload" aria-hidden="true"></i>Upload</a>
                </li>
                <li id="photos"><a href="myphoto.php"><i class="fa fa-star" aria-hidden="true"></i></i>My Photos</a>
                </li>
                <li id="favor"><a href="myfavor.php"><i class="fa fa-heart" aria-hidden="true"></i>My Favor</a></li>
                <li id="logIn"><a href="../logOut.php"><i class="fa fa-sign-in" aria-hidden="true"></i>Log out</a></li>
            </ul>
        </li>
    </ul>
</div>
<div class="uploadItem">
    <p class="uploadTitle">Upload</p>
    <table>
        <tr>
            <td class="uploadContent">
                <form action="" enctype="multipart/form-data">
                    <p id="uploadWord">Picture not uploaded</p>
                    <input type="file" id="uploadImg">
                    <?php
                    if (isset($_GET['ImageID'])) {
                        echo '<img alt="" id="selectImg" onblur="judge()"';
                        echo 'src="../images/normal/medium/' . $PATH . '"';
                        echo '>';
                        echo '<script>document.getElementById("uploadWord").style.display="none";</script>';
                    } else {
                        echo '<img alt="" id="selectImg" onblur="judge()"';
                        echo 'src=""';
                        echo '>';
                    }
                    ?>
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form action="uploadHelp.php" method="post">
                    <p class="radioStyle">Title:
                    <p>
                        <?php
                        if (isset($_GET['ImageID'])) {

                            echo '<input type="text" name="Title" id="Title" value="' . $Title . '" onblur="judge()" class="uploadLine"><br>';
                        } else {
                            echo '<input type="text" name="Title" id="Title" value="" onblur="judge()" class="uploadLine"><br>';
                        }
                        ?>
                    <p class="radioStyle">Description:</p>
                    <?php
                    if (isset($_GET['ImageID'])) {
                        echo '<textarea type="text" name="Description" id="Description" onblur="judge()" class="uploadParag">' . $Description . '</textarea><br>';
                    } else {
                        echo '<textarea type="text" name="Description" id="Description" onblur="judge()" class="uploadParag"></textarea><br>';
                    }
                    ?>

                    <input type="hidden" name="UID" value="<?php echo $UID; ?>"/>
                    <?php
                    //传ImageID
                    if (isset($_GET['ImageID'])) {
                        echo '<input type="hidden" name="ImageID" value="' . $ImageID . '"/>';
                    }
                    //读取PATH
                    ?>

                    <input type="hidden" id="path" name="PATH" value="<?php echo $PATH; ?>"/>
                    <?php
                    echo '<script type="text/javascript">
                    
                    var fileD = document.getElementById("uploadImg");
                    var pathD = document.getElementById("path");
                    
                    fileD.addEventListener("change", judSrc,false);
                    
                    function judSrc() {
                         var file2=fileD.files[0];
                         pathD.value=file2.name;
                    }
                   
                    </script>';
                    ?>


                    <div class="formSelect">

                        <select id="content" name="content" onclick="linkHelp()" onblur="judge()">
                            <option value="scenery">Scenery</option>
                            <option value="city">City</option>
                            <option value="people">People</option>
                            <option value="animal">Animal</option>
                            <option value="building">Building</option>
                            <option value="wonder">Wonder</option>
                            <option value="other">Other</option>
                        </select>
                        <select id="country" name="country" onclick="linkage()" onblur="judge()">
                            <option selected hidden value="">Country</option>
                            <option value="China">China</option>
                            <option value="Canada">Canada</option>
                            <option value="Italy">Italy</option>
                            <option value="United Kingdom">United Kingdom</option>
                        </select>
                        <select id="city" name="city" onblur="judge()">
                            <option selected hidden value="">City</option>
                        </select>
                        <?php
                        if (isset($_GET['ImageID'])) {
                            echo '<script>
                                set_select_checked("content","' . $Content . '");
                                set_select_checked("country","' . $Country . '");
                               
                                linkage();
                                set_select_checked("city","' . $City . '");

                                function set_select_checked(selectId, checkValue) {
                                var select = document.getElementById(selectId);
                                for (var i = 0; i < select.options.length; i++) {
                                    if (select.options[i].value == checkValue) {
                                        select.options[i].selected = true;
                                        break;
                                    }
                                  }
                                }
                            </script>';
                        }
                        ?>
                        <div onmousedown="judge();MakeupHint();">
                            <?php
                            if (isset($_GET['ImageID'])) {
                                echo '<button class="uploadButton" id="submit" >Modify</button>';
                            } else {
                                echo '<button class="uploadButton" id="submit" >Upload</button>';
                            }
                            ?>
                            <Span id="help"></Span>
                        </div>

                    </div>
                </form>
            </td>
        </tr>
    </table>
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
                <img id="wechat" src="../images/background/WechatID.jpg"/>
            </p>
        </div>
    </div>
</footer>
<script type="text/javascript">

    window.onload = function () {
        var url = "country.json"
        var request = new XMLHttpRequest();
        request.open("get", url);
        request.send(null);
        request.onload = function () {
            var jsonHelp = JSON.parse(request.responseText);
            var countryHelp = [];
            for (var i = 0; i < 252; i++) {
                countryHelp[i] = jsonHelp[i].CountryName;
            }
            var selectCountry = document.getElementById("country");
            selectCountry.length = 1;
            for (var i = 0; i < countryHelp.length; i++) {
                selectCountry[i + 1] = new Option(countryHelp[i], countryHelp[i]);
            }
        }

    }

    //二级联动

    function linkage() {
        var xhr = new XMLHttpRequest();
        //xhr.onreadystatechange = callback;
        //get
        xhr.open("post", "uploadJoint.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //send
        var midCountry = document.getElementById("country");
        var countryName = midCountry.value;

        xhr.send("Country=" + countryName);
        xhr.onload = function () {
            var res = JSON.parse(xhr.responseText);
            var cityHelp = [];
            for (var i = 0; i < 20; i++) {
                cityHelp[i] = res[i].AsciiName;
            }
            var selectCity = document.getElementById("city");
            selectCity.length = 1;
            for (var i = 0; i < 20; i++) {
                selectCity[i + 1] = new Option(cityHelp[i], cityHelp[i]);
            }
        }
    }

    function set_select_checked(selectId, checkValue) {
        var select = document.getElementById(selectId);
        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].value == checkValue) {
                select.options[i].selected = true;
                break;
            }
        }
    }
    //提交验证需要全部为true
    var title = false;
    var description = false;
    var content = false;
    var country = false;
    var city = false;
    var pic = false;

    //初始化提交
    document.getElementById("submit").disabled = true;

    function testTitle() {
        var titleName = document.getElementById("Title").value;
        if (titleName != "" && titleName.trim() != "") {
            title = true;
        }
    }

    function testDescription() {
        var desName = document.getElementById("Description").value;
        if (desName != "" && desName.trim() != "") {
            description = true;
        }
    }

    function testContent() {
        var contentName = document.getElementById("content").value;
        if (contentName != "" && contentName.trim() != "") {
            content = true;
        }
    }

    function testCountry() {
        var countryName = document.getElementById("country").value;
        if (countryName != "" && countryName.trim() != "") {
            country = true;
        }
    }

    function testCity() {
        var cityName = document.getElementById("city").value;
        if (cityName != "" && cityName.trim() != "") {
            city = true;
        }
    }

    function testPic() {
        var picName = document.getElementById("selectImg").src;
        if (picName != "" && picName.trim() != "") {
            pic = true;
        }
    }

    function judge() {
        testTitle();
        testDescription();
        testContent();
        testCountry();
        testCity();
        testPic();
        if (title && description && content && country && city && pic) {
            document.getElementById("submit").disabled = false;
        } else {
            document.getElementById("submit").disabled = true;
        }
    }

    function MakeupHint() {
        if (document.getElementById("submit").disabled) {
            alert("Information is incomplete, please make up !");
        }
    }

    //读取图片
    var fileDom = document.getElementById("uploadImg");
    var previewDom = document.getElementById("selectImg");

    fileDom.addEventListener("change", e => {
        document.getElementById("uploadWord").style.display = "none";
        var file = fileDom.files[0];
        // check if input contains a valid image file
        if (!file || file.type.indexOf("image/") < 0) {
            fileDom.value = "";
            previewDom.src = "";
            return;
        }

        // use FileReader to load image and show preview of the image
        var fileReader = new FileReader();
        fileReader.onload = e => {
            previewDom.src = e.target.result;
        };
        fileReader.readAsDataURL(file);
    });

    //Src


    /*
    function xmTanUploadImg(obj) {
        document.getElementById("uploadWord").style.display="none";
        var file = obj.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var img = document.getElementById("selectImg");
            img.src="";
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
        pic=true;
        judge();
    }
    */


    //动态select
    function set_select_checked(selectId, checkValue) {
        var select = document.getElementById(selectId);

        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].value == checkValue) {
                select.options[i].selected = true;
                break;
            }
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../js/upload.js"></script>
</html>