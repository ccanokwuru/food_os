<?php
require_once('db/connect.php');

// get all menu
function getMenu($type)
{
    global $conn;
    if ($type === 'menu')
        $sql = "select *,fos_menucategory.MenName as MenuCat from fos_menu join fos_menucategory on fos_menucategory.MenuCat_ID=fos_menu.MenuCat_ID order by fos_menu.DateCreated desc";
    elseif ($type === 'cat')
        $sql = "select * from fos_menucategory order by DateCreated desc";
    $res = $conn->query($sql);

    if ($res) {
        $menus = [];
        while ($row = $res->fetch_assoc()) {
            $menus[] = $row;
        }
        return $menus;
    } else return mysqli_error($conn);
}

// get all in menucat_id
function getMenuByCatId($id)
{
    global $conn;
    $sql = "select *,fos_menucategory.MenName as MenuCat from fos_menu join fos_menucategory on fos_menucategory.MenuCat_ID=fos_menu.MenuCat_ID where fos_menu.MenuCat_ID=$id order by fos_menu.DateCreated desc";

    $res = $conn->query($sql);

    if ($res) {
        $menus = [];
        while ($row = $res->fetch_assoc()) {
            $menus[] = $row;
        }
        return $menus;
    } else return mysqli_error($conn);
}

// get one menu
function getMenuById($id, $type)
{
    global $conn;
    if ($type === 'menu')
        $sql = "select * from fos_menu where Menu_ID=$id";
    elseif ($type === 'cat')
        $sql = "select * from fos_menucategory where MenuCat_ID=$id";
    $res = $conn->query($sql);
    $res = $res->fetch_assoc();

    if ($res) {
        if ($type === 'menu') $res['Image'] = getMenuById($res['MenuCat_ID'], 'cat')['Image'];
        return $res;
    } else return mysqli_error($conn);
}

// get one menuname
function getMenuByName($name, $type)
{
    global $conn;
    if ($type === 'menu')
        $sql = "select *,fos_menucategory.MenName as MenuCat from fos_menu join fos_menucategory on fos_menucategory.MenuCat_ID=fos_menu.MenuCat_ID where MenName='$name'";
    elseif ($type === 'cat')
        $sql = "select * from fos_menucategory where MenName='$name'";
    $res = $conn->query($sql);

    if ($res)
        return $res->fetch_assoc();
    else return mysqli_error($conn);
}

// get customer from db
function getUserByEmail($email)
{
    global $conn;
    $sql = "select * from fos_user join fos_customer on fos_customer.Email=fos_user.email where fos_user.email='$email'";

    $result = $conn->query($sql);
    if ($result)
        return $result->fetch_assoc();
    else return $conn->error;
}

// get user from db
function getUser($email)
{
    global $conn;
    $sql = "select * from fos_user where email='$email'";

    $result = $conn->query($sql);
    if ($result)
        return $result->fetch_assoc();
    else return $conn->error;
}

// auth
function auth($type)
{
    global $conn;
    if (isset($_POST['submit'])) {
        $msg = "";

        $email = strtolower($_POST['email']);
        $password = $_POST['password'];


        // register
        if ($type === 'register') {
            $confirm = $_POST['confirm'];
            if ($confirm === $password) {
                $sql = "insert into fos_user (email, password) values('$email','$password')";
                $result = $conn->query($sql);

                if ($result) {
                    $user = getUserByEmail($email);
                    $_SESSION['email'] = $email;
                    $msg = 'Successful';
                    $sql = "insert into fos_customer (Email) values('$email')";
                } else {
                    $msg = 'Email exists';
                }
            } else $msg = 'Password match failed';
        }

        // login
        elseif ($type === 'login') {
            $msg = 'Credentials Invalid or Does not Exist';
            $user = getUser($email);

            if ($user && $user['password'] === $password) {

                $_SESSION['email'] = $email;
                $msg = 'Successful';
            }
        }

        isset($user['type']) ? $_SESSION['userType'] = $user['type'] : $_SESSION['userType'] = null;

        return $msg;
    }
}

// logout
function logout()
{
    unset($_SESSION['email']);
    unset($_SESSION['userType']);
}

// create order
function createOrder($umail)
{
    global $conn;
    $myBasket = $_SESSION['myBasket'];
    // return print_r(['basket' => $myBasket, 'mail' => $umail]);

    // Email
    // FirstName
    // LastName
    // Address
    // Mobile

    $fName = $_POST['FirstName'];
    $lName = $_POST['LastName'];
    $add = $_POST['Address'];
    $mob = $_POST['Mobile'];
    $email = $_POST['Email'];
    $id = $_POST['id'];


    // Cus_ID	FirstName	LastName Address	Mobile	Email	DateCreated	
    $sql = "update fos_user join fos_customer on fos_user.email=fos_customer.Email set FirstName='$fName', LastName='$lName', Address='$add', Mobile='$mob', fos_user.email='$email' where fos_user.email='$umail'";

    $user = $conn->query($sql);
    if ($user) {

        foreach ($myBasket as $item) {
            $qty = $item['Qty'];
            $MenuID = $item['Menu_ID'];
            $price = $item['BuyPrice'];

            // get menu price
            $UPrice = $conn->query("select BuyPrice from fos_menu where Menu_ID=$MenuID");
            $UPrice = mysqli_fetch_assoc($UPrice)['BuyPrice'];

            $price = $UPrice === $price ? $price : $UPrice;

            // return print_r($price);

            $ordDate = date("Y-m-d H:i:s", time() + 3600 * 3);
            // return print_r($ordDate);
            // create order
            $sql = "insert into `fos_order` (Cus_ID, OrderDate) values ($id, '$ordDate')";

            if ($conn->query($sql)) {
                $ordID = $conn->insert_id;

                $sql = "insert into fos_orderdetails (Ord_ID, Menu_ID, Qty, UnitPrice) values ($ordID, $MenuID, $qty,'$price')";

                $order = $conn->query($sql);
                if (!$order)
                    return print_r($conn->error);

                $sql = "update fos_menu set Qtyinstock=Qtyinstock-$qty where Menu_ID=$id";
                $res = $conn->query($sql);
                if (!$res)
                    return print_r($conn->error);
            } else
                return print_r($conn->error);
        }
        // update user detail
        $_SESSION['email'] = $email;

        unset($_SESSION['myBasket']);
    }

    return print_r($conn->error) || header("location: menu-details.php?menu_ID=$id");
}

// delete order
function deleteOrder()
{
    global $conn;

    $ordId = $_POST['Ord_ID'];
    $menId = $_POST['Menu_ID'];
    $qty = $_POST['Qty'];

    $sql = "delete from `fos_order` where Ord_ID=$ordId";
    $res = $conn->query($sql);
    if (!$res)
        return print_r($conn->error);
    else {
        $sql = "update fos_menu set Qtyinstock=Qtyinstock+$qty where Menu_ID=$menId";
        $res = $conn->query($sql);
        if (!$res)
            return print_r($conn->error);
    }
    header("location: order.php");
}

// order has been delivered
function arrivedOrder()
{
    global $conn;

    $ordId = $_POST['Ord_ID'];

    $sql = "update `fos_order` set Status='delivered' where Ord_ID=$ordId";
    $res = $conn->query($sql);
    if (!$res)
        return print_r($conn->error);
    header("location: order.php");
}

function getMyOrder($uid)
{
    global $conn;

    // $orders = $conn->query("select * from fos_order join fos_orderdetails ON fos_order.Ord_ID=fos_orderdetails.Ord_ID");
    $sql = "select  fos_orderdetails.*, fos_order.OrderDate, fos_order.ShippedDate, fos_order.Status, fos_menu.MenName, fos_menucategory.Image from `fos_order` join `fos_orderdetails` on fos_order.Ord_ID=fos_orderdetails.Ord_ID join fos_menu on fos_orderdetails.Menu_ID=fos_menu.Menu_ID join fos_menucategory on fos_menu.MenuCat_ID=fos_menucategory.MenuCat_ID where fos_order.Cus_ID=$uid order by DateCreated desc";

    $orders = $conn->query($sql);

    $myOrders = [];

    while ($row = $orders->fetch_assoc()) {
        $myOrders[] = $row;
    }

    return $myOrders;
}

// update profile
function updateProfile()
{
    global $conn;

    $smail = $_SESSION['email'];
    $email = $_POST['Email'];
    $id = $_POST['id'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Address = $_POST['Address'];
    $Mobile = $_POST['Mobile'];

    $User = $conn->query("update fos_user set email='$email' where email='$smail'");
    if ($User)
        $sql = "update fos_customer set Email='$email', FirstName='$FirstName', LastName='$LastName', Address='$Address', Mobile='$Mobile' where Cus_ID =$id";

    $res = $conn->query($sql);

    if ($res)
        $_SESSION['email'] = $email;
    else return print_r(mysqli_error($conn));
}

function addToBasket()
{
    if ($_SESSION['myBasket'] === []) {
        $addThis = getMenuById($_POST['menuId'], 'menu');
        $addThis = [
            'Menu_ID' => $addThis['Menu_ID'],
            'MenName' => $addThis['MenName'],
            'Image' => $addThis['Image'],
            'Qty' => 1,
            'BuyPrice' => $addThis['BuyPrice'],
        ];
    } else {
        if (!array_filter($_SESSION['myBasket'], function ($data) {
            return $data['Menu_ID'] === $_POST['menuId'];
        })) {
            $addThis = getMenuById($_POST['menuId'], 'menu');
            $addThis = [
                'Menu_ID' => $addThis['Menu_ID'],
                'MenName' => $addThis['MenName'],
                'Image' => $addThis['Image'],
                'Qty' => 1,
                'BuyPrice' => $addThis['BuyPrice'],
            ];
        } else {
            $addThis = array_values(array_filter($_SESSION['myBasket'], function ($data) {
                return $data['Menu_ID'] === $_POST['menuId'];
            }))[0];

            $_SESSION['myBasket'] = array_values(array_filter($_SESSION['myBasket'], function ($data) {
                return $data['Menu_ID'] !== $_POST['menuId'];
            }));

            // return print_r($addThis);
            $addThis['Qty'] = $addThis['Qty'] + 1;
        }
    }

    // add / update item by 1
    array_unshift($_SESSION['myBasket'], $addThis);
}

function deleteFromBasket()
{
    $_SESSION['myBasket'] = array_values(array_filter($_SESSION['myBasket'], function ($data) {
        return $data['Menu_ID'] !== $_POST['menuId'];
    }));
}

function updateBasket()
{
    $addThis = array_values(array_filter($_SESSION['myBasket'], function ($data) {
        return $data['Menu_ID'] === $_POST['menuId'];
    }))[0];

    $_SESSION['myBasket'] = array_values(array_filter($_SESSION['myBasket'], function ($data) {
        return $data['Menu_ID'] !== $_POST['menuId'];
    }));

    $addThis['Qty'] = $_POST['qty'];
    if ($addThis['Qty'] > 0)
        array_unshift($_SESSION['myBasket'], $addThis);
}