<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/db/connect.php');


// get employee from db
function getEmpByEmail($email)
{
    global $conn;
    $sql = "select * from fos_user join fos_employee on fos_employee.Email=fos_user.email where fos_user.email='$email'";

    $result = $conn->query($sql);
    if ($result)
        return $result->fetch_assoc();
    else return $conn->error;
}

// update epmloyee profile
function updateEmpProfile()
{
    global $conn;

    $smail = $_SESSION['email'];
    $email = $_POST['Email'];
    $id = $_POST['id'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Address = $_POST['Address'];
    $JobTitle = $_POST['JobTitle'];
    $Mobile = $_POST['PhoneNumber'];

    $User = $conn->query("update fos_user set email='$email' where email='$smail'");
    if ($User)
        $sql = "update fos_employee set Email='$email', FirstName='$FirstName', LastName='$LastName', Address='$Address', JobTitle='$JobTitle', PhoneNumber='$Mobile' where Emp_ID =$id";

    $res = $conn->query($sql);

    if ($res)
        $_SESSION['email'] = $email;
    else return print_r(mysqli_error($conn));
}

// upload menu image
function upload()
{
    $imgPath = null;
    $uploadDir = "../uploads/";

    if (isset($_FILES['image'])) {
        $imgName = bin2hex(random_bytes(5)) . '-' . strtolower(str_replace(' ', '-', $_FILES['image']['name']));
        $imgTmp = $_FILES['image']['tmp_name'];

        if (file_exists($uploadDir . $imgName)) {
            $imgName = 'new-' . $imgName;
        }

        if (move_uploaded_file($imgTmp, $uploadDir . $imgName)) {
            $imgPath = "http://localhost/food-os/uploads/" . $imgName;
        }
    }

    return $imgPath;
}

// save menu
function saveMenu($type)
{
    global $conn;
    $id = false;
    if (isset($_POST['id']))
        $id = $_POST['id'];
    if ($type === 'menu') {
        $menName = $_POST['menName'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $cat = $_POST['cat'];
        $qty = $_POST['qty'];
        if ($id)
            $sql = "update fos_menu set MenName='$menName', BuyPrice =$price, Description='$desc', MenuCat_ID=$cat, Qtyinstock=$qty where Menu_ID=$id";
        else
            $sql = "insert into fos_menu (MenName, BuyPrice, Description, MenuCat_ID, Qtyinstock) values('$menName',$price,'$desc',$cat,$qty)";
    } elseif ($type === 'cat') {
        $menName = $_POST['menName'];

        if ($id) {
            $image = upload();
            if (!$image === null) $image = getMenuById($id, 'cat')['Image'];
            $sql = "update fos_menucategory set MenName='$menName', Image='$image' where MenuCat_ID=$id";
        } else {
            $image = upload();
            if (!$image === null) $image = 'http://localhost/food-os/images/feedmelogo.png';

            $sql = "insert into fos_menucategory (MenName, Image) values('$menName','$image')";
        }
    }
    $res = $conn->query($sql);

    if ($res)
        return 'Successful';
    else return mysqli_error($conn);
}

// delete menu
function deleteMenu($id, $type)
{
    global $conn;
    if ($type === 'menu')
        $sql = "delete from fos_menu where Menu_ID=$id";
    elseif ($type === 'cat')
        $sql =  "delete from fos_menucategory where MenuCat_ID=$id";
    $res = $conn->query($sql);

    if ($res)
        return 'Successful';
    else return mysqli_error($conn);
}

// get all orders
function getAllOrder()
{
    global $conn;

    // $orders = $conn->query("select * from fos_order join fos_orderdetails ON fos_order.Ord_ID=fos_orderdetails.Ord_ID");
    $sql = "select fos_orderdetails.*, fos_order.OrderDate, fos_order.ShippedDate, fos_order.Status,fos_order.Emp_ID, fos_menu.MenName, fos_menucategory.Image from `fos_order` join `fos_orderdetails` on fos_order.Ord_ID=fos_orderdetails.Ord_ID join fos_menu on fos_orderdetails.Menu_ID=fos_menu.Menu_ID join fos_menucategory on fos_menu.MenuCat_ID=fos_menucategory.MenuCat_ID order by DateCreated desc";

    $orders = $conn->query($sql);

    $allOrds = [];

    while ($row = $orders->fetch_assoc()) {
        $allOrds[] = $row;
    }

    return $allOrds;
}

// get recent orders 
function getAllNewOrder()
{
    global $conn;

    $sql = "select *, fos_orderdetails.*, fos_menu.MenName, fos_menucategory.Image from `fos_order` inner join `fos_orderdetails` on fos_order.Ord_ID=fos_orderdetails.Ord_ID inner join fos_menu on fos_orderdetails.Menu_ID=fos_menu.Menu_ID inner join fos_menucategory on fos_menu.MenuCat_ID=fos_menucategory.MenuCat_ID join fos_customer on fos_order.Cus_ID=fos_customer.Cus_ID where fos_order.Emp_ID is null and fos_order.Status='pending' order by fos_order.DateCreated desc";

    $orders = $conn->query($sql);

    $newOrds = [];

    while ($row = $orders->fetch_assoc()) {
        $newOrds[] = $row;
    }

    return $newOrds;
}

function acceptOrder()
{
    global $conn;
    $empMail = $_SESSION['email'];
    $ordId = $_POST['Ord_ID'];

    $sql = "select Emp_ID from fos_employee where Email='$empMail'";
    $res = $conn->query($sql);
    if (!$res)
        return print_r($conn->error);
    $empId = $res->fetch_assoc()['Emp_ID'];
    return print_r($empId);
    $ordDate = date("Y-m-d H:i:s", time());

    $sql = "update `fos_order` set Status='in_route', Emp_ID='$empId',ShippedDate='$ordDate' where Ord_ID=$ordId";
    $res = $conn->query($sql);
    if (!$res)
        return print_r($conn->error);
}