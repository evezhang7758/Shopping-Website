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
	<title>Login in</title>
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
				<input type="submit" class="searchBtn" value="Search"/>
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
    <div class="container">
        <form class="loginArea main" action="php/doLogin.php" method="post">
            <table class="fl" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="colspan" colspan="2"><h1>Log in</h1></td>
                </tr>
                <tr>
                    <td class="label">Name:</td>
                    <td><input type="text" name="name"/></td>
                </tr>
                <tr>
                    <td class="label">Password:</td>
                    <td><input type="password" name="password"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="submit" class="submit" style="float: right"/></td>
                </tr>
            </table>
            <div style="float: left; padding-left: 100px;"><img class="fr" src="image/cover1.jpg"/></div>
            <div style="float: left; padding: 25px 50px"><img class="fr" src="image/cover2.jpg" /></div>
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
</html>
