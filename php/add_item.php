<?php
    include "config.php";

    // connect to mysql
    $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
    mysqli_query($link, "SET NAMES UTF8");  // set enctype

    // received request variables' values and assign them to new variables
    $categoryID = $_POST['categoryID'];
    $name = $_POST['name'];
    $price = $_POST['price'] != "" ? $_POST['price'] : 129;
    $stock = $_POST['stock'] != "" ? $_POST['stock'] : 20;
    $img = $_FILES["img"];  // $_FILES received file value

    // if they are all not null
    if ($categoryID && $name && $price && $stock) {

        $dir = "../image/item/";   // set file path
        $filename = "";   // file name, for following image insert into database
        if ($img['error'] == 0) {  // error is 0, means file upload successfully
            $type = explode('/', $img['type']);  // explode return a array
            if ($type[0] == 'image') {   // make sure the file is image file
                $imgType = array('png', 'jpg', 'jpeg');   // set acceptable image type
                if (in_array($type[1], $imgType)) {   // if upload image belong to one of type in the $imgType
                    $imgName = $dir . time() . '.' . $type[1];    // set a new image name, which is unique, make sure it will not have a repeated name with other image
                    if (is_dir($dir)) {   // if this file path is root path
                        if ($handle = opendir($dir)) {  // open file stream
                            while (($tmp_file = readdir($handle)) !== false) {  // read file
                                $explode = explode('.', $tmp_file);  // return image name of temperate file
                                $tmp_filename = reset($explode);    // mixed the value of the first array element, or false if the array is
                            }
                            closedir($handle);  // close file stream
                        }
                    }
                    $res = move_uploaded_file($img['tmp_name'], $imgName);  // move temperate file to a new path
                    $filename = time() . "." . $type[1];   // assign $filename
                }
            } else {
                echo "<script language=javascript>alert('image type is not correct!');location.href='../addItem.php';</script>";
            }
        } else {  // fail to upload file
            echo $img['error'];
        }
        // if $filename is not null, insert all item information into database
        if ($filename != "") {
            $sql = "insert into item(name, categoryID, price, stock, img) values('$name', '$categoryID', '$price', '$stock' ,'$filename')";
        } else {  // if $filename is null, only all item information except img
            $sql = "insert into item(name, categoryID, price, stock) values('$name', '$categoryID', '$price', '$stock')";
        }

        $res = mysqli_query($link, $sql);  // execute mysql
        if (!$res) {  // fail to execute insert operation
            echo "<script language=javascript>alert('Operation failed!');location.href='../addItem.php</script>";
            exit;
        }
        echo "<script language=javascript>location.href='../index.php';</script>";  // successfully, return to index page
    } else
        echo "<script language=javascript>alert('Cannot be empty!');location.href='../addItem.php</script>";   // if one of variables above is null, return to addItem page

?>