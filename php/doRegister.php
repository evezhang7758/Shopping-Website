<?php
    include "config.php";
    //Input information format restrictions
    $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
    mysqli_query($link, "SET NAMES UTF8");

    // Through $_POST to receive the request variables values from front-end and assign them to new variables
    $name = $_POST['name'];
    $passowrd = $_POST['password'];
    $email = $_POST['email'] != "" ? $_POST['email'] : "jimmyLi@mail.com" ;
    $phone = $_POST['phone'] != "" ? $_POST['phone'] : "8130000000";
    $address = $_POST['address'] != "" ? $_POST['address'] : "13123 thomasville circle";


    if ($name && $passowrd) {  // if name and password are not null, continue

        $sql = "SELECT * FROM user WHERE name = '$name'";    // query the information(all the fields in user table) from user, condition is name has to be $name
        $res = mysqli_query($link, $sql); // if success, return object, otherwise, return false or failure
        $rows = mysqli_num_rows($res);  // retrieve the object, return number of rows in the result set

        //check if user already in database
        if ($rows) {
            echo "<script language=javascript>alert('The name already exists！');location.href='../register.php';</script>";
            exit;
        }
        // If not, insert a new user to the table user
        $sql = "INSERT INTO user(name, password, email, phone, address) values('$name','$passowrd','$email','$phone','$address')";
        mysqli_query($link, $sql);
        session_start();
        $_SESSION['user'] = array("type" => 'user', "name" => $name);   // put user type and name in the session, so that they don't need to repeadly input their authorities info
        echo "<script language=javascript>location.href='../index.php';</script>";
    }
    else
        echo "<script language=javascript>alert('Name and password cannot be empty！');location.href='../register.php';</script>";

?>