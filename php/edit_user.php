<?php
	include "config.php";

	$link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
	mysqli_query($link, "SET NAMES UTF8");

	// through $_POST to receive values sent from front end
	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];

	// if there exist the user, then update his information
	if ($id) {
		$sql = "update `user` set name='$name', email = '$email', phone = '$phone', address = '$address' where id = '$id'";
		$res = mysqli_query($link, $sql);
		if (!$res) {  // check whether update operation is executed successfully or not
			echo "<script language=javascript charset='UTF-8'>alert('Operation failed!');location.href='../userInfo.php;</script>";
			exit;
		}
		echo "<script language=javascript charset='UTF-8'>location.href='../user.php';</script>";  // if successfully, return to usr page
	} else
		echo "<script language=javascript charset='UTF-8'>alert('This user does not exist!');location.href='../userInfo.php;</script>";  // give a remind no such user.

?>