<?php
    include "php/config.php";
    @session_start();
    //Only admin have permission to view and use additem buttion
    if (!isset($_SESSION['user']) || $_SESSION['user']["type"] != "admin") {
        echo '<script>location.href = "login.php"</script>';
        exit;
    }

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Add item</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
</head>
<body>
<!-- head -->
<?php include "publicFile/head.php"; ?>

<!-- menu -->
<?php include "publicFile/menu.php"; ?>

<div class="container content">
    <form action="php/add_item.php" method="post" enctype="multipart/form-data">
        <table class="container main editArea">
            <tr>
                <td class="label">Category</td>
                <td>
                    <select name="categoryID">
                        //save the changing to the page
                        <?php
                        $sql = "select * from category";
                        $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
                        mysqli_query($link, "SET NAMES UTF8");
                        $query = mysqli_query($link, $sql);

                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">Item Name</td>
                <td><input type="text" name="name" /></td>
            </tr>
            <tr>
                <td class="label">Image</td>
                <td>
                    <img id="Picture" class="cover" /><br>
                    <input type="file" name="img" />
                </td>
            </tr>
            <tr>
                <td class="label">Price</td>
                <td><input type="text" name="price" id="price"/></td>
            </tr>
            <tr>
                <td class="label">Stock</td>
                <td><input type="text" name="stock" id="stock"/></td>
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