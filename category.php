<?php
    include "php/config.php";
    @session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']["type"] != "admin") {
        echo '<script>location.href = "login.php"</script>';
        exit;
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Category</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
</head>
<body>
    <!-- head -->
    <?php include "publicFile/head.php"; ?>
    
	<!-- menu -->
    <div class="container">
        <div class="menu">
            <ul class="navbar main">
                <li class="nav"><a href="index.php">Home</a></li>
                <li class="nav active"><a href="category.php">Category</a></li>
                <li class="nav"><a href="user.php">User</a></li>
                <li class="nav"><a href="order.php">Order</a></li>
                <li class="nav"><a href="backup.php">Backup</a></li>
            </ul>
        </div>
    </div>

    <div class="container content">
		<div class="main" style="width:600px;margin-top: 20px;text-align: right;">
			<input type="button" value="Add" class="submit" onclick="location.href='addCategory.php'"/>
		</div>
		<table class="table_big" width="600" border="1px" bordercolor="#000000" cellspacing="0px" style="border-collapse:collapse"> 
			<tr>
				<th>Category ID</th>
				<th>Category Name</th>
				<th colspan="2">Operations</th>
			</tr>
		<?php
            $link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database);
			$sql = "select * from category order by id";
			mysqli_query($link,"SET NAMES UTF8");
			$query = mysqli_query($link,$sql);
			$i = 0;

        while ($row = mysqli_fetch_array($query)) {
            if ($i % 2 == 1)
                echo '<tr bgcolor="#eff3ff">';
            else
                echo '<tr bgcolor="#ffffff">';
            ?>
            <td><?= $row["id"] ?></td>
            <td><?= $row["name"] ?></td>
            <td>
                <a href="editCategory.php?id=<?= $row["id"] ?>">edit</a>
            </td>
            <td>
                <a href="php/delete_item.php?id=<?= $row["id"] ?>&table=category"
                   onclick='return confirm("Do you really want to delete it?")'>delete</a>
            </td>
            </tr>
		<?php
				$i ++;
			}
		?>
		</table>
    </div>

    <!-- foot -->
    <?php include "publicFile/footer.php"; ?>

</body>
</html>