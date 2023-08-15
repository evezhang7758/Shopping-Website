<?php
    include "php/config.php";
    @session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']["type"] != "admin") {
        echo '<script>location.href = "login.php"</script>';
        exit;
    }

    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
    // 设置全局变量
    $name = "";
    $categoryID = "";
    $price = "";
    $stock = "";
    $img = "";
    if ($id != "") {
        $sql = "select * from item where id = '$id'";
        $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
        mysqli_query($link, "SET NAMES UTF8");
        $query = mysqli_query($link, $sql);
        if ($query && $row = mysqli_fetch_array($query)) {
            $name = $row["name"];
            $categoryID = $row["categoryID"];
            $price = $row["price"];
            $stock = $row["stock"];
            $img = "image/item/".$row["img"];  // 完整路径
        }
    }

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Edit Item</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
</head>
<body>
<!-- head -->
<?php include "publicFile/head.php"; ?>

<!-- menu -->
<?php include "publicFile/menu.php"; ?>

<div class="container content">
    <form action="php/edit_item.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>" />
        <table class="container main editArea">
            <tr>
                <td class="label">Category</td>
                <td>
                    <select name="categoryID">
                        <?php
                        $sql = "select * from category";    // query all
                        $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
                        mysqli_query($link, "SET NAMES UTF8");
                        $query = mysqli_query($link, $sql);

                        while ($row = mysqli_fetch_array($query)) {
                            $selected = $categoryID == $row["id"] ? " selected" : "";  // 如果为空，默认选择第一个
                            echo "<option value='" . $row["id"] . "'" . $selected . ">" . $row["name"] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">Item Name</td>
                <td><input type="text" name="name" value="<?= $name ?>" /></td>
            </tr>
            <tr>
                <td class="label">Image</td>
                <td>
                    <img id="Picture" class="cover" src="<?= $img ?>" /><br>
                    <input type="file" name="img" value="<?= $img ?>"/>
                </td>
            </tr>
            <tr>
                <td class="label">Price</td>
                <td><input type="text" name="price" value="<?= $price ?>" id="price"/></td>
            </tr>
            <tr>
                <td class="label">Stock</td>
                <td><input type="text" name="stock" value="<?= $stock ?>" id="stock"/></td>
            </tr>
            <tr>
                <td></td>
                <td><span id="msg" style="color: red"></span></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 130px">
                    <input type="submit" value="submit" id="btn_submit"/> &nbsp;
                    <a href="index.php"><input type="button" value="cancel" /></a>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>

<script>
    window.onload = function() {
        var price = document.getElementById("price");
        var stock = document.getElementById("stock");
        var msg = document.getElementById("msg");
        var btn_submit = document.getElementById("btn_submit");

        btn_submit.onclick = function (){
            if (price.value < 0 || stock.value < 0) {
                msg.innerHTML = "price and stock can not be negative";
                return false;
            }
        }
    }
</script>
</html>