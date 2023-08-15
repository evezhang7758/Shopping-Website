<?php
    include "php/config.php";
    @session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']["type"]!="admin"){
        echo '<script>location.href = "login.php"</script>';
        exit;
    }

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Add category</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
</head>
<body>
<!-- head -->
<?php include "publicFile/head.php"; ?>

<!-- menu -->
<?php include "publicFile/menu.php"; ?>

<div class="container content">
    <form action="php/add_category.php" method="post">
        <table class="container main editArea">
            <tr>
                <td class="label">Category Name</td>
                <td><input type="text" name="name"/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="submit" class="submit"/>
                    <a href="category.php"><input type="button" value="cancel" class="submit" style="margin-left: 100px"/></a>
                </td>
            </tr>
        </table>
    </form>
</div>

<!-- foot -->
<?php include "publicFile/footer.php"; ?>

</body>
</html>
