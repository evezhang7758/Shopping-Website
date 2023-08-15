<?php
    include "config.php";

    $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
    mysqli_query($link, "SET NAMES UTF8");

    $id = $_POST['id'];
    $categoryID = $_POST['categoryID'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $img = $_FILES["img"];

    if ($id && $categoryID && $name && $price && $stock) {
        // save picture
        $dir = "../image/item/";
        $filename = "";
        //check the image type is allowed or not
        if (isset($img) && isset($img["name"])) {
            $uptypes = array(
                'image/jpg',
                'image/jpeg',
                'image/png',
                'image/pjpeg',
                'image/gif',
                'image/bmp',
                'image/x-png'
            );
            //save the info
            $file = $_FILES["img"];
            $img_name = pathinfo($file["name"]);
            $img_ext = isset($img_name['extension']) ? $img_name['extension'] : "";
            $img_full_path = $dir . time() . "." . $img_ext;
            if (in_array($file["type"], $uptypes)) {
                if (is_dir($dir)) {
                    if ($handle = opendir($dir)) {
                        while (($tmp_file = readdir($handle)) !== false) {
                            $explode = explode('.', $tmp_file);
                            $tmp_filename = reset($explode);
                            if ($tmp_filename == $id)
                                @unlink($dir . $tmp_file);
                        }
                        closedir($handle);
                    }
                }
                move_uploaded_file($file["tmp_name"], $img_full_path);
                $filename =  time() . "." . $img_ext;
            }
        }
        //Insert record
        $sql = "";
        if ($id != "") {
            if($filename != ""){
                $sql = "update item set name = '$name', categoryID = '$categoryID', price = '$price', stock = '$stock', img ='$filename' where id = '$id'";
            }else{
                $sql = "update item set name = '$name', categoryID = '$categoryID', price = '$price', stock = '$stock' where id = '$id'";
            }
        }

        $res = mysqli_query($link, $sql);

        if (!$res) {
            echo "<script language=javascript>alert('Operation failed!');location.href='../editItem.php</script>";
            exit;
        }
        echo "<script language=javascript>location.href='../index.php';</script>";
    } else
        echo "<script language=javascript>alert('Cannot be empty!');location.href='../editItem.php</script>";

?>