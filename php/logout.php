<?php
    //system log out function
    @session_start();
    unset($_SESSION['user']);  // clear session then return to login page
    echo "<script language=javascript>location.href='../login.php';</script>";
?>