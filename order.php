<?php
include "php/config.php";
@session_start();
if (!isset($_SESSION['user'])) {
    echo '<script>location.href = "login.php"</script>';
    exit;
}

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";

if ($id && $status && $type == "status") {
    if ($status == "Waiting for shipment")
        $status = "Delivered";
    else
        $status = "Waiting for shipment";

    $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
    mysqli_query($link, "SET NAMES UTF8");
    $sql = "update `orders` set status='$status' where id = '$id'";

    $res = mysqli_query($link, $sql);
}

if ($id && $type == "drop") {
    $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
    mysqli_query($link, "SET NAMES UTF8");
    $sql = "delete from `orders` where id = '$id'";
    $res = mysqli_query($link, $sql);
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Order</title>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
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
                <li class="nav active"><a href="order.php">Order</a></li>
                <?php
            }
            ?>
            <?php
            if(isset($_SESSION['user']) && $_SESSION['user']["type"]=="admin"){
                ?>
                <li class="nav"><a href="backup.php">Backup</a></li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>

<div class="container content">
    <table class="table_big" width="900" border="1px" bordercolor="#000000" cellspacing="0px" style="border-collapse:collapse;">
        <tr>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']["type"]=="admin"){ ?>
                <th>User ID</th>
                <th>Order ID</th>
            <?php } ?>
            <th>Item Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Order Time</th>
            <th>Status</th>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']["type"]=="admin"){ ?>
                <th>Update Order Status</th>
                <th>Cancel</th>
            <?php } ?>
        </tr>

        <?php
        if(isset($_SESSION['user']) && $_SESSION['user']["type"]=="admin") {

            $num = 12; //每页显示的数量
            $page = isset($_GET['p']) ? $_GET['p'] : 1; //$page如果有get传值就获取，没有就默认第一页
            //页码小于等于1，就不变化
            if ($page <= 0) {
                $page = $page + 1;
            }
            # 计算偏移量
            $offset = ($page - 1) * $num;

            # 1.连接数据库
            $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);

            # 2.查询数据库
            $sql = "select orderID, userID, total, orderTime, status, quantity, item.name itemName, price, category.name categoryName
                    from orders, orderdetail, item, category where orderdetail.orderID = orders.id and orderdetail.itemID = item.id and item.categoryID = category.id
                    order by orderTime desc limit {$offset}, {$num}";

            //计算总条数
            if ($tempRes = mysqli_query($link, "SELECT count(*) as count FROM `orderdetail`")) {
                $row = mysqli_fetch_assoc($tempRes);
                $count = $row['count']; //记录总数
            }

            $query = mysqli_query($link, $sql);
            $i = 0;
            $drop = "drop";

            # 3.循环解析数据
            while ($row = mysqli_fetch_array($query)) { ?>

                <?php if ($i % 2 == 1)
                    echo '<tr bgcolor="#eff3ff">';
                else
                    echo '<tr bgcolor="#ffffff">';
                ?>
                <td><?= $row["userID"] ?></td>
                <td><?= $row["orderID"] ?></td>
                <td><?= $row["itemName"] ?></td>
                <td><?= $row["categoryName"] ?></td>
                <td>$<?= $row["price"] ?></td>
                <td><?= $row["quantity"] ?></td>
                <td>$<?= $row["total"] ?></td>
                <td><?= $row["orderTime"] ?></td>
                <td><?= $row["status"] ?></td>
                <td><?php if ($row["status"] != 'Delivered'): ?>
                        <a href="?id=<?= $row["orderID"] ?>&type=status&status=<?= $row["status"] ?>">Update order status</a>
                    <?php endif ?>
                </td>
                <td><a href="?id=<?= $row["orderID"] ?>&type=drop&drop=<?= $drop ?>">cancel</a></td>
                </tr>
                <?php $i++;
            } ?>

            <?php
            //如果到了尾页，就不再往后跳转了
            //计算出总页数= 总记录数 / 每天显示的数量
            $total = ceil($count / $num); //ceil函数大于当前数就显示整数
            if ($page > $total) {
                $page = $page - 1;
            }
            echo '<p align="center" style="margin-top: 20px">';
            echo '<a href="?p=' . ($page - 1) . '"><u style="font-size: 15px;">Last</u>&nbsp;&nbsp;&nbsp;</a>';
            echo '<a href="?p=' . ($page + 1) . '"><u style="font-size: 15px">Next</u>&nbsp;&nbsp;&nbsp;</a>';
            echo '<span style="font-size: 15px">(Total:' . $count . '</span>';
            echo '&nbsp;&nbsp;&nbsp;<span style="font-size: 15px">Pages:' . $total . ')</span>';
            ?>
        <?php    } ?>


        <?php
        if (isset($_SESSION['user']) && $_SESSION['user']["type"] != "admin") {

            $num = 12; //每页显示的数量
            $page = isset($_GET['p']) ? $_GET['p'] : 1; //$page如果有get传值就获取，没有就默认第一页
            //页码小于等于1，就不变化
            if ($page <=0){
                $page = $page+1;
            }
            # 计算偏移量
            $offset = ($page-1)*$num;

            # 1.连接数据库
            $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);

            $sql = "select total, orderTime, status, quantity, item.name itemName, price, category.name categoryName
                    from orders, orderdetail, item, category where orderdetail.orderID = orders.id and orderdetail.itemID = item.id and item.categoryID = category.id 
                    and userID = '".$_SESSION['user']['id']."' order by orderTime desc limit {$offset}, {$num}";

            if($tempRes=mysqli_query($link,"SELECT count(*) as count FROM orders, orderdetail where userID='".$_SESSION['user']['id']."' and orderID = orders.id")){
                $row=mysqli_fetch_assoc($tempRes);
                $count = $row['count']; //记录总数
            }

            $query = mysqli_query($link, $sql);
            $i = 0;

            while ($row = mysqli_fetch_array($query)) { ?>
                <?php
                if ($i % 2 == 1)
                    echo '<tr bgcolor="#eff3ff">';
                else
                    echo '<tr bgcolor="#ffffff">';
                ?>
                <td><?= $row["itemName"] ?></td>
                <td><?= $row["categoryName"] ?></td>
                <td>$<?= $row["price"] ?></td>
                <td><?= $row["quantity"] ?></td>
                <td>$<?= $row["total"] ?></td>
                <td><?= $row["orderTime"] ?></td>
                <td><?= $row["status"] ?></td>
                </tr>
                <?php $i++;
            } ?>

            <?php
            $total = ceil($count / $num);
            if ($page > $total){
                $page = $page-1;
            }
            echo '<p align="center" style="margin-top: 20px">';
            echo '<a href="?p='.($page-1).'"><u style="font-size: 15px;">Last</u>&nbsp;&nbsp;&nbsp;</a>';
            echo '<a href="?p='.($page+1).'"><u style="font-size: 15px">Next</u>&nbsp;&nbsp;&nbsp;</a>';
            echo '<span style="font-size: 15px">(Total:'.$count.'</span>';
            echo '&nbsp;&nbsp;&nbsp;<span style="font-size: 15px">Pages:'.$total.')</span>';
        } ?>

    </table>
</div>

</body>
</html>