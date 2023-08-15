<?php
    include "php/config.php";
    @session_start();

    $delete_id = isset($_GET['type']) ? ($_GET['type'] == "delete" ? (isset($_GET['id']) ? $_GET['id'] : "") : "") : "";
    if ($delete_id != "") {
        if (!isset($_SESSION['user']) || $_SESSION['user']["type"] != "admin") {
            echo json_encode(array("code" => 300, "msg" => "No authority！"));
            exit;
        }

        $sql = "delete from Item where ItemID=" . $delete_id;
        $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database) or die('Please in the PHP folder config.php Check database configuration in!');
        mysqli_query($link, "SET NAMES UTF8");
        if (mysqli_query($link, $sql)) {
            // delete picture
            $dir = "image/item/";
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        $a = explode('.', $file);
                        $filename = reset($a);
                        if ($filename == $delete_id)
                            @unlink($dir . $file);
                    }
                    closedir($dh);
                }
            }
            echo json_encode(array("code" => 200, "msg" => "success"));
            exit;
        } else
            echo json_encode(array("code" => 500, "msg" => "fail"));
        exit;
    }

?>

<?php

// get Category id and search text
$category= isset($_REQUEST['category'])?$_REQUEST['category']:"";
$searchText = isset($_REQUEST['searchText'])?$_REQUEST['searchText']:"";

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/flow.css" />
    <script src="js/iconfont.js"></script>
    <style>
        .icon {
            width: 1.5em;
            height: 1.5em;
            vertical-align: -0.15em;
            fill: currentColor;
            overflow: hidden;
        }
        table{
            border-spacing: 0px;
        }
        ul {
            display: block;
            list-style-type: disc;
            margin-block-start: 0em;
            margin-block-end: 0em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            padding-inline-start: 40px;
        }
    </style>
</head>
<body>
<!--head-->
<div class="container" id="top">
    <div class="head main">
        <div class="logo fl">
            <img src="image/logo.png"/>
        </div>
        <ul class="userinfo">
            <?php
            if (!isset($_SESSION['user'])) {
                ?>
                <li><a href="login.php">Login</a></li>
                <li class="divide"></li>
                <li><a href="register.php">Register</a></li>
                <?php
            } else {
                ?>
                <li><a href="changePassword.php"><?= $_SESSION['user']["name"] ?></a></li>
                <li class="divide"></li>
                <li><a href="php/logout.php">Exit</a></li>
                <?php
            }
            ?>
        </ul>
        <div class="search fr">
            <input type="text" class="searchTxt" name="key" value="<?php echo $searchText ?>" style="width: 170px"/>
            <input type="button" class="searchBtn" value="search" style="width: 55px"/>
            <a href="index.php"><input type="button" class="searchBtn" value="reset" style="width: 55px"/></a>
        </div>
    </div>
</div>

<!-- menu -->
<div class="container">
    <div class="menu">
        <ul class="navbar main">
            <li class="nav active"><a href="index.php">Home</a></li>
            <?php
            if(isset($_SESSION['user']) && $_SESSION['user']["type"]=="admin"){ ?>
                <li class="nav"><a href="category.php">Category</a></li>
                <li class="nav"><a href="user.php">User</a></li>
            <?php } ?>
            <?php
            if(isset($_SESSION['user'])){ ?>
                <li class="nav"><a href="order.php">Order</a></li>
            <?php } ?>
            <?php
            if(isset($_SESSION['user']) && $_SESSION['user']["type"]=="admin"){
                ?>
                <li class="nav"><a href="backup.php">Backup</a></li>
            <?php } ?>
            <li><img src="image/sale.jpg" style="height: 50px; float: right"/></li>
        </ul>
    </div>
</div>

<div class="container content">
    <table class="main">
        <tr>
            <td width="15%">
                <div class="header">Category</div>
                <ul class="Category dataArea" id="CategoryList">
                    <?php
                    $sql = "select * from category order by id";	// query all
                    $link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database) or die('Please in the PHP folder config.php Check database configuration in！');

                    mysqli_query($link,"SET NAMES UTF8");
                    $query = mysqli_query($link,$sql);

                    echo "<li" . ($category=="" ? " class='active'" : "") . "><a href='Index.php'>All</a></li>";
                    while ($row = mysqli_fetch_array($query))
                    {
                        echo "<li" . ($row["id"] == $category ? " class='active'" : "") . "><a href='index.php?category=" . $row["id"] . "'>" . $row["name"] . "</a></li>";
                    }
                    ?>
                </ul>
            </td>
            <td width="65%">
                <ul class="flow dataArea" id="ItemList">
                    <?php
                    $sql = "select Item.*, Category.name categoryName from Item, Category where Item.categoryID = Category.id";	// query all
                    if($category!="")
                        $sql .= " and Item.categoryID=" . $category;
                    if($searchText!="")
                        $sql .= " and Item.name like '%" . $searchText . "%'";

                    $link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database);
                    //mysql_select_db($mysql_database);
                    mysqli_query($link,"SET NAMES UTF8");
                    $query = mysqli_query($link,$sql);

                    $i = 0;
                    while ($row = mysqli_fetch_array($query))
                    {
                        $i++;
                        $html = "<li data-id='" . $row["id"] . "'>" .
                            "	<div class='img' style='background-image:url(image/Item/" . $row["img"] . ");'></div>" .
                            "	<div class='desc'>" .
                            "		<div class='info'><div class='fl name'>" . $row["name"] . "</div><span class='fr'>$<div class='price'>" . $row["price"] . "</div></span></div>" .
                            "		<div class='descr'>" . $row["categoryName"] . "(stock:" . $row["stock"] . ")</div>" .
                            "		<table class='info' width='100%'><tr>";

                        if(isset($_SESSION['user']) && $_SESSION['user']["type"]=="admin")
                            $html .= "<td><input class='edit opbtn' type='button' value='edit' /></td><td><input class='delete opbtn' type='button' value='delete' /></td>";
                        else
                            $html .= "<svg class='icon cart opbtn' aria-hidden='true' style='float: right; padding-right: 8px;'><use xlink:href='#icon-gouwuche' id='cart'></use></svg>";

                        $html .= "" .
                            "		</tr></table>" .
                            "	</div>" .
                            "</li>";
                        echo $html;
                    }
                    if($i == 0)
                        echo "<h1 class='tc emptyTip'>Content is empty！</h1>";
                    ?>
                </ul>
            </td>
            <td width="20%">
                <?php
                if(!isset($_SESSION['user']) || $_SESSION['user']["type"]!="admin"){
                    ?>
                    <div class="header">Shopping Cart</div>
                    <div class="dataArea cartArea">
                        <table class="CartList" cellpadding="0" cellspacing="0" >
                            <?php
                            if(isset($_SESSION['cart']) && (isset($_SESSION['user']) && $_SESSION['user']["type"]!="admin")){
                                for($i=0; $i<count($_SESSION['cart']); $i++){
                                    ?>
                                    <tr data-id="<?=$_SESSION['cart'][$i]["id"]?>">
                                        <td class="name"><?=$_SESSION['cart'][$i]["name"]?></td>
                                        <td class="price"><?=$_SESSION['cart'][$i]["price"]?></td>
                                        <td class="sub">-</td>
                                        <td class="qty"><?=$_SESSION['cart'][$i]["qty"]?></td>
                                        <td class="add">+</td></tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                        <table class="Total">
                            <tr>
                                <td>total</td>
                                <td>$<span class="total">0</span></td>
                            </tr>
                            <tr style="height: 5px"></tr>
                        </table>
                        <table class="CartOp">
                            <tr>
                                <td><input class='fl clear opbtn' type='button' value='clear' /></td>
                                <td><input class='fl pay opbtn' type='button' value='pay' style="background-color: #228B22; color: white"/></span></td>
                            </tr>
                        </table>
                    </div>
                    <?php
                }
                ?>

                <?php
                if(isset($_SESSION['user']) && $_SESSION['user']["type"]=="admin"){
                    ?>
                    <img class='op add' title="Add new product" src="image/add.png" style="margin-top: 30px"/>
                    <?php
                }
                ?>
            </td>
        </tr>
    </table>
    <script type="text/javascript" src="js/Index.js"></script>
</div>

<script>
    $(document).ready(function () {
        // search
        $(".searchBtn").click(function (e) {
            location.href = "index.php?searchText=" + $(this).siblings(".searchTxt").val();
        });

        $("#ItemList").height(Math.ceil($("#ItemList li").size()/3)*316);

    });
</script>
</body>
</html>