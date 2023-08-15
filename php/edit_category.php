<?php
	include "config.php";

    //connect with database
	$link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database);
	mysqli_query($link,"SET NAMES UTF8");  // set enctype

    // get the id and name sent from front end
    $id=$_POST['id'];
	$name=$_POST['name'];

    // if id is not null, continue to execute sql
    if ($id != "") {
        $sql = "update `category` set name = '$name' where id = '$id'";  // update name
        $res = mysqli_query($link, $sql);
        if (!$res) {  // if update name successfully, return to category page
            echo "<script language=javascript>alert('Operation failed!');</script>";
            exit;
        }
        echo "<script language=javascript>location.href='../category.php';</script>";
    }

?>