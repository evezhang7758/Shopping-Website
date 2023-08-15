<?php
	include "php/config.php";

    @session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']["type"]!="admin"){
        echo '<script>location.href = "login.php"</script>';
        exit;
    }
?>

<?php

$id = isset($_REQUEST['id']) ? $_REQUEST['id']:"";
// 设置全局变量，下面要用
$name = "";
$email = "";
$phone = "";
$address = "";
if($id != ""){
	$sql = "select * from `user` where id='$id'";
    $link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database);
	$query = mysqli_query($link,$sql);
	if($query && $row = mysqli_fetch_array($query)){
        $name = $row["name"];
        $email = $row["email"];
        $phone = $row["phone"];
        $address = $row["address"];
	}
}
else{
	echo '<script>location.href = "user.php"</script>';
	exit;
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Userinfo</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
</head>
<body>
    <!-- head -->
    <?php include "publicFile/head.php"; ?>
    
	<!-- menu -->
    <?php include "publicFile/menu.php"; ?>

    <div class="container content">
		<form action="php/edit_user.php" method="post">
			<input type="hidden" name="id" value="<?= $id ?>" />
			<table class="container main editArea">
				<tr>
					<td class="label">Name</td>
					<td><input type="text" name="name" value="<?= $name ?>" /></td>
				</tr>
                <tr>
                    <td class="label">Email</td>
                    <td><input type="text" name="email" value="<?= $email ?>" /></td>
                </tr>
				<tr>
					<td class="label">Telephone</td>
					<td><input type="text" name="phone" value="<?= $phone ?>" /></td>
				</tr>
				<tr>
					<td class="label">Address</td>
					<td><input type="text" name="address" value="<?= $address ?>" /></td>
				</tr>
				<tr>
                    <td></td>
					<td>
                        <input type="submit" value="submit" class="submit"/>
                        <a href="user.php"><input type="button" value="cancel" class="submit" style="margin-left: 100px"/></a>
                    </td>
				</tr>
			</table>
		</form>
    </div>

    <!-- foot -->
    <?php include "publicFile/footer.php"; ?>

</body>
</html>