<?php
include "./config.php";
?>
<?php
$link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
$name = $_POST['name'];
$password = $_POST['password'];

if ($name && $password) {
    $sql = "SELECT * FROM user WHERE name = '$name' and password='$password'";
    $res = mysqli_query($link, $sql);  // $res must be an object or boolean type

    // $row is a array, if $res exist and $row exist, continue to execute if sentence
    if ($res && $row = mysqli_fetch_array($res)) {
        //check the status to see if user can login or not
        if ($row["status"] != "enabled") {
            echo "<script language=javascript>alert('You are blocked！');location.href='../login.php';</script>";
            exit;
        }
        @session_start();  // open session
        $_SESSION['user'] = array("type" => $row["type"], "id" => $row["id"], "name" => $row["name"]);  // store user or admin type, id, name into session
        echo "<script language=javascript>location.href='../index.php';</script>";
        exit;
    }
    echo "<script language=javascript>alert('The name or password is not correct！');location.href='../login.php';</script>";
} else
    echo "<script language=javascript>alert('The Name and password cannot be empty！');location.href='../login.php';</script>";
?>