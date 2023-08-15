
<div class="container" id="top">
    <div class="head main">
        <div class="logo fl">
            <img src="image/logo.png" />
        </div>
        <ul class="userinfo">
            <li><a href="changePassword.php"><?=$_SESSION['user']["name"]?></a></li>
            <li class="divide"></li>
            <li><a href="php/logout.php">Exit</a></li>
        </ul>
        <div class="search fr">
            <input type="text" class="searchTxt" name="key" value="" style="width: 170px"/>
            <input type="button" class="searchBtn" value="search" style="width: 55px"/>
            <a href="index.php"><input type="button" class="searchBtn" value="reset" style="width: 55px"/></a>
        </div>
    </div>
</div>