<?php
	include "config.php";
?>
<?php
	$link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database);
	mysqli_query($link,"SET NAMES UTF8");
	$id=$_REQUEST['id'];
	$table=$_REQUEST['table'];

	//Only admin have the permission to delete the item, if not then the operation shows error report
   // this file is delete operation, which is used for user model and category model, so we have to check it is user or not
    if ($id && $table == "user") {
        $sql = "delete from $table where id = $id"; // delete certain user information from table user
        $res = mysqli_query($link, $sql);
        if (!$res) {  // fail to delete, return alert.
            echo "<script language=javascript>alert('delete failed!');location.href='../$table.php';</script>";
            exit;
        }
        echo "<script language=javascript>location.href='../$table.php';</script>";  // success to delete, then return user page
    }

	if ($id && $table == "category") {   // delete certain category information from table category
		$sql = "delete from $table where id = $id";
		$res = mysqli_query($link, $sql);
		if (!$res) {   // fail to delete, return alert.
			echo "<script language=javascript>alert('delete failed!');location.href='../$table.php';</script>";
			exit;
		}
		echo "<script language=javascript>location.href='../$table.php';</script>";   // success to delete, then return category page
	}



?>