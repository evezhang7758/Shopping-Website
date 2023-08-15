<?php
    header("Content-type:text/json");
    @session_start();
    include "config.php";

/*
 * type is from index.js file. type has 0, 1, 2, 3, 4, 5, which are used to encode different function.
 * if type is 0, nothing to do, exit;
 * if type is 1, add new item into cart;
 * if type is 2, reduce the number of item in the cart;
 * if type is 3, increase the number of item in the cart;
 * if type is 4, clear cart;
 * if type is 5, execute pay function
 *
 * */

    $type = isset($_POST['type']) ? $_POST['type'] : 0;
    if ($type == 0)
        exit;
    else {

        // check item with id equal to $id whether it has been in the cart.
        function exist($cart, $id)
        {
            for ($i = 0; $i < count($cart); $i++) {  // traverse item in the cart by checking each item's id
                if ($cart[$i]['id'] == $id)
                    return true;
            }
            return false;
        }

        $id = $_POST['id'];  // received item id
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();  // if cart has been change, then its value is $_SESSION['cart'], or it is a new array


        // add a new item to cart
        if ($type == 1) {
            $name = $_POST['name'];  // received item name
            $price = $_POST['price'];  // received item price
            $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
            $sql = "select stock from item where id = '$id'";   // query item stock where its id equal to $id
            $query = mysqli_query($link, $sql);  // execute query

            $numTemp = mysqli_fetch_assoc($query)['stock'];  // successfully then return a array, otherwise return full
            if ($numTemp > 0) {   // if stock in the database more than 0, then continue
                if (exist($cart, $id)) {
                    echo json_encode(array("code" => 300, "msg" => "Item is already in the shopping cart!"));
                    exit;
                } else {
                    array_push($cart, array("id" => $id, "name" => $name, "price" => $price, "qty" => 1));  // there is not this item in the cart, then add it into cart
                    $_SESSION['cart'] = $cart;  // store $cart into session
                    echo json_encode(array("code" => 200, "msg" => "successful!"));
                    exit;
                }
            }
        } // reduce quantity of an item in cart
        else if ($type == 2) {
            if (!exist($cart, $id)) {   // if doesn't exist this item, return message: This item does not exist!
                echo json_encode(array("code" => 300, "msg" => "This item does not exist!"));
                exit;
            } else {  // if it exists, then traverse shopping cart to find specified item id
                for ($i = 0; $i < count($cart); $i++) {
                    if ($cart[$i]['id'] == $id) {
                        $cart[$i]['qty'] = $cart[$i]['qty'] - 1;  // decrease this item's number
                        if ($cart[$i]['qty'] <= 0) {  // can't reduce if number less than 0, and assign a new empty array to $new_cart
                            $new_cart = array();
                            for ($j = 0; $j < count($cart); $j++)  // add remained item into $new_cart
                                if ($cart[$j]['id'] != $id)
                                    array_push($new_cart, $cart[$j]);

                            $_SESSION['cart'] = $new_cart;  // put $new_cart into session
                            echo json_encode(array("code" => 300, "msg" => "delete successfully！"));  // return feedback, delete successfully
                            exit;
                        } else {
                            $_SESSION['cart'] = $cart;  // if if number more than 0, add it into session
                            echo json_encode(array("code" => 200, "msg" => "successful!"));
                            exit;
                        }
                    }
                }
            }
        } // increase quantity of an item in cart
        else if ($type == 3) {
            if (!exist($cart, $id)) {  // check whether this item is in the cart or not
                echo("{'code':300, 'msg':'Product does not exist!'}");
                exit;
            } else {
                //update the count
                $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
                for ($i = 0; $i < count($cart); $i++) {
                    if ($cart[$i]['id'] == $id) {
                        $sqlstr = "select stock from item where id=" . $cart[$i]['id'];
                        $query = mysqli_query($link, $sqlstr);
                        $numTemp = mysqli_fetch_assoc($query)['stock'];  // check the item stock
                        if ($numTemp) {
                            if ($cart[$i]['qty'] >= $numTemp) {  // if add item number more than its stock, return the following message
                                echo json_encode(array("code" => 988, "msg" => "This item's stock is insufficient"));
                                exit;
                            } else {    // if add item number less than its stock, increase its number in the cart
                                $cart[$i]['qty'] = $cart[$i]['qty'] + 1;
                                $_SESSION['cart'] = $cart;
                                echo json_encode(array("code" => 200, "msg" => "successful!"));
                                exit;
                            }
                        }
                    }
                }
            }
        }

        // clear cart by unsetting sesseion
        else if ($type == 4) {
            unset($_SESSION['cart']);
            echo json_encode(array("code" => 200, "msg" => "successful!"));
            exit;
        }

        // pay
        else if ($type == 5) {
            // check if it is user, if not send error
            if (!isset($_SESSION['user']) || $_SESSION['user']["type"] == "admin") {
                echo json_encode(array("code" => 300, "msg" => "Please log in first"));
                exit;
            } else if (count($cart) == 0) { // if the item number in the cart is equal to 0, return the following message
                echo json_encode(array("code" => 400, "msg" => "Your shopping cart is empty!"));
                exit;
            } else {
                $link = @mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
                $total = 0;  // set amount of item
                $numTemp = 0;  // stock number query from database
                $newStock = 0;  // used to encode updated value of stock
                $error = '';  // means error message

                // calculate the item number in the cart
                for ($i = 0; $i < count($cart); $i++) {
                    $sqlstr = "select stock from item where id=" . $cart[$i]['id'];   // query stock of specified item
                    $query = mysqli_query($link, $sqlstr);
                    if (mysqli_error($link)) {  // if fail to connect database, add error message into msg
                        echo json_encode(array("code" => 988, "msg" => mysqli_error($link)));
                        exit;
                    }
                    $numTemp = mysqli_fetch_assoc($query)['stock'];
                    if ($numTemp > 0 && $numTemp >= $cart[$i]["qty"]) {   // if stock number is more than 0 and more than its number in the cart
                        $total = $total + $cart[$i]["qty"] * $cart[$i]["price"] * 0.75;   // calculate total amount of all the items
                        $newStock = $numTemp - $cart[$i]["qty"];
                        $update_stock = "update item set stock = '$newStock' where id = '" . $cart[$i]['id'] . "'";  // update stock of specified product in table item
                        $query_stock = mysqli_query($link, $update_stock);  // execute update
                    } else {
                        $error .= $cart[$i]['name'] . ', ';
                    }
                }

                // error report
                if ($error) {  // return error message
                    echo json_encode(array("code" => 988, "msg" => "The stock of '" . $error . "' is insufficient"));
                    exit;
                }

                $sql = "insert into `orders`(userID, total) values(" . "'" . $_SESSION['user']['id'] . "'," . $total . ")";  // add order info into table orders
                $query = mysqli_query($link, $sql);

                if ($query) {
                    $sql = "select max(id) as newid from `orders`";  // query the max id from table orders in orde to add corresponding trade recorde into table orderdetail
                    $query = mysqli_query($link, $sql);
                    if ($query && $row = mysqli_fetch_array($query)) {
                        $newid = $row['newid'];
                        for ($i = 0; $i < count($cart); $i++) {
                            $sql = "insert into `orderdetail`(orderID, itemID, quantity) values(" .
                                $newid . "," .
                                $cart[$i]["id"] . "," .
                                $cart[$i]["qty"] . ")";
                            $query = mysqli_query($link, $sql);  // execute insert operation to add new record into orderdetail
                        }
                        echo json_encode(array("code" => 200, "msg" => "successful!"));  // return successful if execute successfully
                        unset($_SESSION['cart']);
                        exit;
                    }
                }

                echo json_encode(array("code" => 500, "msg" => "Operation failed!"));  // otherwise, return failed
            }
        }
    }
?>