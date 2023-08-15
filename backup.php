<?php
    include "php/config.php";
    date_default_timezone_set('EST');  // 设置时区
    @session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']["type"] != "admin") {
        echo '<script>location.href = "login.php"</script>';
        exit;
    }

    $file_path_name = './backup';
    if (!file_exists($file_path_name)) {
        mkdir($file_path_name, 0777);
    }

// 备份
    if (isset($_GET['a']) && $_GET['a'] == 'backup') {
        $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database) or die(mysqli_connect());
        mysqli_query($link, "SET NAMES UTF8");

        $sql = "-- -----------------------------\n";
        $sql .= "-- MySQL Data Transfer \n";
        $sql .= "-- \n";
        $sql .= "-- servername     : " . $mysql_servername . "\n";
        $sql .= "-- Database       : " . $mysql_database . "\n";
        $sql .= "-- \n";
        $sql .= "-- Date : " . date("Y-m-d H:i:s") . "\n";
        $sql .= "-- -----------------------------\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n";

        $q1 = mysqli_query($link, "show tables");
        while ($t = mysqli_fetch_array($q1)) {
            $table = $t[0];
            $q2 = mysqli_query($link, "show create table `$table`");
            $result = mysqli_fetch_array($q2);

            $sql .= "\n";
            $sql .= "-- -----------------------------\n";
            $sql .= "-- Table structure for `{$table}`\n";
            $sql .= "-- -----------------------------\n";
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= trim($result['Create Table']) . ";\n\n";


            $q3 = mysqli_query($link, "select * from `$table`");
            $sql .= "-- -----------------------------\n";
            $sql .= "-- Records of `{$table}`\n";
            $sql .= "-- -----------------------------\n";
            while ($data = mysqli_fetch_assoc($q3)) {
                $keys = array_keys($data);
                $keys = array_map('addslashes', $keys);
                $keys = join('`,`', $keys);
                $keys = "`" . $keys . "`";
                $vals = array_values($data);
                $vals = array_map('addslashes', $vals);
                $vals = join("','", $vals);
                $vals = "'" . $vals . "'";
                $sql .= "INSERT INTO `$table`($keys) VALUES($vals);\r\n";
            }
        }

        $filename = $mysql_database . '_' . date('YmdHis') . ".sql";

        $fp = fopen($file_path_name . '/' . $filename, 'w');
        fputs($fp, $sql);
        fclose($fp);
//        echo "<script language=javascript>location.href='backup.php';</script>";
        echo "<script language=javascript></script>";

    }
// 删除
    else if (isset($_GET['a']) && isset($_GET['file']) && $_GET['a'] == 'del') {
        if (!preg_match("/^([0-9a-z_]+)[0-9]{14}(\.sql)$/", $_GET['file'])) {
            echo "<script language=javascript>alert('The file is invalid!');location.href='backup.php';</script>";
            exit;
        }

        $fileInfo = $file_path_name . '/' . $_GET['file'];
        if (file_exists($fileInfo)) {
            $res = unlink($fileInfo);
        }

    }
// 恢复
    else if (isset($_GET['a']) && isset($_GET['file']) && $_GET['a'] == 'restore') {
        if (!preg_match("/^([0-9a-z_]+)[0-9]{14}(\.sql)$/", $_GET['file'])) {
            echo "<script language=javascript>alert('The file is invalid!');location.href='backup.php';</script>";
            exit;
        }

        $fileInfo = $file_path_name . '/' . $_GET['file'];
        if (!file_exists($fileInfo)) {
            echo "<script language=javascript>alert('The file does not exist!');location.href='backup.php';</script>";
        } else {
            $sql = file_get_contents($fileInfo);
            $sql = trim($sql);
            $sqlArr = explode(';', $sql);

            $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database) or die(mysqli_connect());
            mysqli_query($link, "SET NAMES UTF8");

            $msg = '';
            foreach ($sqlArr as $_value) {
                if ($_value) {
                    $q1 = mysqli_query($link, $_value . ';');
                    if (mysqli_error($link)) {
                        $msg .= $_value;
                        $msg .= "\r\n---------------------------------------\r\n";
                        $msg .= "<span style='color:#f00;font-weight: 600;'>" . mysqli_error($link) . "</span>";
                        $msg .= "\r\n---------------------------------------\r\n";
                    }
                }
            }

            if ($msg) {
                echo "<pre>";
                echo $msg;
                echo "<br>";
                echo '<input type="button" onclick="history.back()" value="Go Back">';
            } else {
                echo "<script language=javascript>alert('restore successfully!');location.href='backup.php';</script>";
            }
            exit;
        }
    }


?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Category</title>
    <link rel="stylesheet" type="text/css" href="css/global.css"/>
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
</head>
<body>
<!-- head -->
<?php include "publicFile/head.php"; ?>

<!-- menu -->
<div class="container">
    <div class="menu">
        <ul class="navbar main">
            <li class="nav"><a href="index.php">Home</a></li>
            <li class="nav"><a href="category.php">Category</a></li>
            <li class="nav"><a href="user.php">User</a></li>
            <li class="nav"><a href="order.php">Order</a></li>
            <li class="nav active"><a href="backup.php">Backup</a></li>
        </ul>
    </div>
</div>

    <div class="container content">
        <div class="main" style="width:600px;margin-top: 20px;text-align: right;">
            <input type="button" value="backup" class="submit" onclick="location.href='?a=backup'"/>
        </div>
        <table class="table_big" width="600" border="1px" bordercolor="#000000" cellspacing="0px"
               style="border-collapse:collapse">
            <tr>
                <th>ID</th>
                <th>Backup File</th>
                <th>Backup Time</th>
                <th>Restore</th>
                <th>Delete</th>
            </tr>

            <?php
            $fileArr = array();
            if (is_dir($file_path_name)) {
                if ($handle = opendir($file_path_name)) {
                    while (($file = readdir($handle)) !== false) {
                        if ((is_dir($file_path_name . "/" . $file)) && $file != "." && $file != "..") {
                            continue;
                        } else {
                            if ($file != "." && $file != "..") {
                                if (preg_match("/^([0-9a-z_]+)[0-9]{14}(\.sql)$/", $file)) {
                                    $ctime = filectime($file_path_name . '/' . $file);
                                    $fileArr[$ctime] = $file;
                                }
                            }
                        }
                    }
                    closedir($handle);
                }
            }
            krsort($fileArr);
            $idx = 0;
            foreach ($fileArr as $time => $file) {
                $idx++;
                ?>
                <tr>
                    <td><?= $idx ?></td>
                    <td><?= $file ?></td>
                    <td><?= date("Y-m-d H:i:s", $time) ?></td>
                    <td>
                        <a href="?a=restore&file=<?= $file ?>">restore</a>
                    </td>
                    <td>
                        <a href="?a=del&file=<?= $file ?>">delete</a>
                    </td>
                </tr>

            <?php } ?>
        </table>
    </div>

<!-- foot -->
<?php include "publicFile/footer.php"; ?>

</body>
</html>