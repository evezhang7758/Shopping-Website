<?php
	include "config.php";
	@session_start();  // turn on this, $_SESSION['user']) can be the global variable
?>
<?php
	$link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database);
	mysqli_query($link,"SET NAMES UTF8");
	$oldPass=$_POST['oldPassword'];
	$pass1=$_POST['newPassword'];
	$pass2 = $_POST['repeat'];

	// query password equal to $oldPass and id equal to the id stored in the session
	$sql = "SELECT * FROM user WHERE password='$oldPass' and id='".$_SESSION['user']["id"]."'";
	$res = mysqli_query($link, $sql);  // execute sql
	$rows = mysqli_fetch_array($res);

	//$rows is not null, continue to update user information
	if ($rows) {
		$sql = "update user set password='$pass1' where id='" . $_SESSION['user']["id"] . "'";
		mysqli_query($link, $sql);  // execute data in the database
		echo "<script language=javascript>location.href='../index.php';</script>";
	} else{
		echo "<script language=javascript>alert('Error: Your original password is not correct!');location.href='../changePassword.php';</script>";
		exit;
	}


?>