<?php
	include "php/config.php";
?>

<?php
@session_start();
if(!isset($_SESSION['user'])){
	echo '<script>location.href = "login.php"</script>';
	exit;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
</head>
<body>
    <!-- head begin-->
    <?php
        include "publicFile/head.php";
    ?>
    <!-- head end-->

    
	<!-- menu -->
	<div class="container">
		<div class="menu">
			<ul class="navbar main">
				<li class="nav"><a href="index.php">Home</a></li>
				<?php
					if(isset($_SESSION['user']) && $_SESSION['user']["type"]=="admin"){
				?>
                <li class="nav"><a href="category.php">Category</a></li>
                <li class="nav"><a href="user.php">User</a></li>
                <?php
					}
				?>
                <?php
					if(isset($_SESSION['user'])){
				?>
                <li class="nav"><a href="order.php">Order</a></li>
                <?php
					}
				?>
                <li><img src="image/sale.jpg" style="height: 50px; float: right"/></li>
			</ul>
		</div>

	</div>
    <div class="container content">
        <form class="loginArea main register" action="php/doChangePassword.php" method="post">
			<table class="fl" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="colspan" colspan="2"><h1>Change Password</h1></td>
				</tr>
				<tr>
					<td class="label">Old password</td>
					<td><input type="password" name="oldPassword" id="oldPass"/></td>
				</tr>
				<tr>
					<td class="label">New password</td>
					<td><input type="password" name="newPassword" id="newPass1"/></td>
				</tr>
				<tr>
					<td class="label">Confirm password</td>
					<td><input type="password" name="repeat" id="newPass2"/></td>
				</tr>
                <tr >
                    <td class="colspan" colspan="2"><span id="msg" style="color: red"></span></td>
                    <td></td>
                </tr>
				<tr>
                    <td></td>
					<td><input type="submit" value="submit" class="submit" id="btn_submit"/>
                        <a href="index.php"><input type="button" value="cancel" class="submit" style="float: right"/></a>
                    </td>
				</tr>
			</table>
            <div style="float: left; padding-left: 40px;"><img class="fr" src="image/cover7.jpg" /></div>
            <div style="float: left; padding: 25px 25px"><img class="fr" src="image/cover8.jpg" /></div>
            <div style="float: left; padding-left: 1px"><img class="fr" src="image/cover3.jpg" /></div>
		</form>
    </div>

    <!-- foot -->
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
    <script>
        window.onload = function() {
            var oldPass = document.getElementById("oldPass");
            var newPass1 = document.getElementById("newPass1");
            var newPass2 = document.getElementById("newPass2");
            var msg = document.getElementById("msg");
            var btn_submit = document.getElementById("btn_submit");

            btn_submit.onclick = function (){
                if (oldPass.value=="") {
                    msg.innerHTML = "Please input your original password";
                    return false;
                }
                if (newPass1.value == ""){
                    msg.innerHTML = "Please input your new password";
                    return false;
                }
                if(!/(?=.*?[A-Z]){6,16}/.test(newPass1.value)) {
                    msg.innerHTML = "Password must contain at least one capital letter with 6 to 16 characters!";
                    return false;
                }
                if (newPass2.value == ""){
                    msg.innerHTML = "Input your new password again";
                    return false;
                }
                if(newPass2.value != newPass1.value) {
                    msg.innerHTML = "Twice passwords do not match";
                    return false;
                }

            }
        }

        $(document).ready(function () {
            // search
            $(".searchBtn").click(function (e) {
                location.href = "Index.php?searchText=" + $(this).siblings(".searchTxt").val();
            });
        });
    </script>
</body>
</html>