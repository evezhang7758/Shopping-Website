<?php
session_start();
if(isset($_SESSION['user'])){
    echo '<script>location.href = "index.php"</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<!-- Head -->
<div class="container" id="top">
    <div class="head main">
        <div class="logo fl">
            <img src="image/logo.png" />
        </div>
        <ul class="userinfo">
            <li><a href="login.php">Log in</a></li>
            <li class="divide"></li>
            <li><a href="register.php">Register</a></li>
        </ul>
        <div class="search fr">
            <input type="text" class="searchTxt" name="key" value=""/>
            <input type="button" class="searchBtn" value="Search"/>
        </div>
    </div>
</div>

<!-- Menu -->
<div class="container">
    <div class="menu">
        <ul class="navbar main">
            <li class="nav"><a href="index.php">Home</a></li>
            <li><img src="image/sale.jpg" style="height: 50px; float: right"/></li>
        </ul>
    </div>
</div>
<div class="container content">
    <form class="loginArea main register" action="php/doRegister.php" method="post">
        <table class="fl" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td class="colspan" colspan="2" style="height: "><h1>Register</h1></td>
            </tr>
            <tr>
                <td class="label">Name:</td>
                <td><input type="text" name="name" id="name"/></td>
            </tr>
            <tr>
                <td class="label">Password:</td>
                <td><input type="password" name="password" id="pass"/></td>
            </tr>
            <tr>
                <td class="label">Repeat Password:</td>
                <td><input type="password" name="password" id="repass"/></td>
            </tr>
            <tr>
                <td class="label">Email:</td>
                <td><input type="text" name="email"/></td>
            </tr>
            <tr>
                <td class="label">Phone:</td>
                <td><input type="text" name="phone" /></td>
            </tr>
            <tr>
                <td class="label">Address:</td>
                <td><input type="text" name="address" /></td>
            </tr>
            <tr >
                <td class="colspan" colspan="2"><span id="msg" style="color: red"></span></td>
                <td></td>
            </tr>
            <tr>
                <td class="colspan" colspan="2"><input type="submit" value="Submit" class="submit" id="btn_submit" style="float: right"/></td>
            </tr>
        </table>
        <div style="float: left; padding-left: 100px;"><img class="fr" src="image/cover5.jpg" /></div>
        <div style="float: left; padding-left: 50px"><img class="fr" src="image/cover4.jpg" /></div>
    </form>
</div>

<!-- footer -->
<div class="container">
    <div class="foot">
        <div class="main">
            <div>
                <ul>
                    <li>
                        © 2020 G&B Website
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

</body>

<script>

    window.onload = function() {
        var name = document.getElementById("name");
        var pass = document.getElementById("pass");
        var repass = document.getElementById("repass");
        var msg = document.getElementById("msg");
        var btn_submit = document.getElementById("btn_submit");

        btn_submit.onclick = function (){
            if (name.value=="") {
                msg.innerHTML = "Name can not be null";
                return false;
            }
            if (pass.value == ""){
                msg.innerHTML = "Password can not be null";
                return false;
            }
            if(!/(?=.*?[A-Z]){6,16}/.test(pass.value)) {
                msg.innerHTML = "Password must contain 6 to 16 characters with at least one capital!";
                return false;
            }
            if (repass.value != pass.value){
                msg.innerHTML = "Twice password doesn't match";
                return false;
            }
        }
    }
</script>
</html>
