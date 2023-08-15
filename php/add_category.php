<?php
    include "config.php";

    $link=@mysqli_connect($mysql_servername , $mysql_username , $mysql_password , $mysql_database);
    mysqli_query($link,"SET NAMES UTF8");  // set enctype
    $name=$_POST['name'];  // get the name from front-end

    if ($name != "") {   // if name is not null, continue
        $sql = "insert into category(name) values ('$name')";   // add category name, value is $name into table category
        $res = mysqli_query($link, $sql);  // execute sql

        if (!$res) {  // if $res is not null, that's it's an object, then continue
            echo "<script language=javascript>alert('Operation failed!');</script>";
            exit;
        }
        echo "<script language=javascript>location.href='../category.php';</script>";  // insert successfully, and return to category page
    }

?>
