<?php
    include "php/config.php";

    @session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']["type"] != "admin") {
        echo '<script>location.href = "login.php"</script>';
        exit;
    }
?>

<?php
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
    $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";

	if ($id && $status)
	{
		if($status=="enabled")
			$status="disabled";
		else
			$status="enabled";
        $link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database);
        mysqli_query($link,"SET NAMES UTF8");
		$sql = "update `user` set status = '$status' where id = '$id'";
		$res = mysqli_query($link,$sql);
		if(!$res)
			echo "<script language=javascript charset='UTF-8'>alert('Operation failed!');location.href='user.php';</script>";
		else
			echo "<script language=javascript charset='UTF-8'>location.href='user.php';</script>";
		exit;
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>User</title>
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
                <li class="nav"><a href="category.php">Category</a></li>
                <li class="nav active"><a href="user.php">User</a></li>
                <li class="nav"><a href="order.php">Order</a></li>
                <li class="nav"><a href="backup.php">Backup</a></li>
            </ul>
        </div>
    </div>


    <div class="container content">
		<table class="table_big" width="900" border="1px" bordercolor="#000000" cellspacing="0px" style="border-collapse:collapse"> 
			<tr>
				<th>Name</th>
                <th>Email</th>
				<th>Phone</th>
				<th>Address</th>
				<th>Status</th>
				<th colspan="3">Operations</th>
			</tr>

		<?php
            $link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database);
			$sql = "select * from `user` where `name` != 'admin' order by `id` asc";
			mysqli_query($link,"SET NAMES UTF8");
			$query = mysqli_query($link,$sql);
			$i = 0;

        while ($row = mysqli_fetch_array($query)) {
            if ($i % 2 == 1)
                echo '<tr bgcolor="#eff3ff">';
            else
                echo '<tr bgcolor="#ffffff">';
            ?>

            <td><?= $row["name"] ?></td>
            <td><?= $row["email"] ?></td>
            <td><?= $row["phone"] ?></td>
            <td><?= $row["address"] ?></td>
            <td><?= $row["status"] ?></td>
            <td><a href="userInfo.php?id=<?= $row["id"] ?>">edit</a></td>
            <td><a href="php/delete_item.php?id=<?= $row["id"] ?>&table=user"
                   onclick='return confirm("Do you really want to delete it?")'>delete</a></td>
            <td><a href="?id=<?= $row["id"] ?>&status=<?= $row["status"] ?>">update status</a></td>
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