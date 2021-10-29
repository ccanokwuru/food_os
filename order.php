<?php
session_start();

if (!$_SESSION['email'] || $_SESSION['userType'] !== 'cus')
    header('location: ./');

include 'functions.php';

if (!isset($_SESSION['myBasket']))
    $_SESSION['myBasket'] = [];
$useremail = $_SESSION['email'];
$myBasket = $_SESSION['myBasket'];

$user = mysqli_fetch_assoc($conn->query("SELECT * FROM fos_customer WHERE Email='$useremail'"));

if (!$user)
    header('location: ./');

$myOrders = getMyOrder($user['Cus_ID']);


if (isset($_POST['submit'])) {
    if (isset($_REQUEST['new'])) {
        $smail = $_SESSION['email'];
        createOrder($smail);
    } elseif (isset($_REQUEST['delete']))
        deleteOrder();

    elseif (isset($_REQUEST['arrived']))
        arrivedOrder();

    header('location: order.php');
}


$_SESSION['pageTitle'] = 'order';
include 'inc/header.php';
?>

<!-- order -->
<!-- Cus_ID FirstName LastName Address Mobile Email DateCreated -->

<?php if (isset($_REQUEST['new'])) { ?>
<section class="mb-5 py-5 page">
    <div class="container my-5">
        <div class="text-center py-5">
            <h1 class="text-red">
                <b>New Order</b><br>
            </h1>
            <b class="text-dark">Shipping Details</b>
        </div>

        <form action="" method="post" class="row">
            <input type="number" class="d-none" name="id" value=<?php echo $user['Cus_ID'] ?>>
            <div class="col-md-6">
                <label for="FirstName">First Name</label>
                <input type="text" name="FirstName" id="FirstName" class="form-control" aria-describedby="helpId"
                    value="<?php echo $user['FirstName'] ?>">
                <small id="helpId" class="text-muted">John</small>
            </div>
            <div class="col-md-6">
                <label for="LastName">Last Name</label>
                <input type="text" name="LastName" id="LastName" class="form-control" aria-describedby="helpId"
                    value="<?php echo $user['LastName'] ?>">
                <small id="helpId" class="text-muted">Doe</small>
            </div>
            <div class="col-md-5">
                <label for="Mobile">Mobile</label>
                <input type="text" name="Mobile" id="Mobile" class="form-control" aria-describedby="helpId"
                    value="<?php echo isset($user['Mobile']) ? $user['Mobile'] : $user['PhoneNumber'] ?>">
                <small id="helpId" class="text-muted">080********</small>
            </div>
            <div class="col-md-7">
                <label for="Email">Email</label>
                <input type="Email" name="Email" id="Email" class="form-control" aria-describedby="helpId"
                    value="<?php echo $user['Email'] ?>">
                <small id="helpId" class="text-muted">example@*.com</small>
            </div>
            <div class="col-md-8">
                <label for="Address">Address</label>
                <textarea type="Address" name="Address" id="Address" class="form-control"
                    aria-describedby="helpId"><?php echo $user['Address'] ?></textarea>
                <small id="helpId" class="text-muted">Tanke Ilorin</small>
            </div>
            <div class="col-md-4 align-self-center">
                <button class="btn btn-warning btn-block" type="submit" name="submit">
                    Order
                </button>
            </div>
        </form>
    </div>
</section>

<?php } else { ?>
<section class="mb-5 py-5 page">
    <div class="container my-5">
        <h1 class="text-center text-red py-5"><b>My Orders</b></h1>
        <div class="p-3 mb-4">
            <table class="table table-striped table-inverse  bg-white p-3 rounded shadow-sm">
                <thead class="thead-inverse">
                    <tr>
                        <th scope="row">Item</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Shipped</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-capitalize">

                    <?php foreach ($myOrders as $ord) {
                        ?>
                    <tr>
                        <td scope="row">
                            <div class="row">
                                <div class="small-img-col col-md-3">
                                    <img src="<?php echo $ord['Image']; ?>" alt="" class="img-fluid rounded">
                                </div>
                                <div class="col">
                                    <b><?php echo $ord['MenName'] ?></b> <br>
                                    @ &#8358 <?php echo $ord['UnitPrice'] ?> <br>
                                    <small class="text-capitalize">to arrive on or before:
                                        <?php echo $ord['OrderDate'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $ord['Qty'] ?></td>
                        <td><?php echo $ord['UnitPrice'] * $ord['Qty'] ?></td>
                        <td><?php echo $ord['Status'] ?></td>
                        <td><?php echo $ord['ShippedDate'] ? $ord['ShippedDate'] : "wait for it" ?></td>
                        <td class="">
                            <?php if ($ord['Status'] !== 'delivered') {
                                        if (isset($ord['ShippedDate'])) { ?>
                            <form action="order.php?arrived" method="post" class="col-md-6">
                                <input type="text" name="Ord_ID" class="d-none" value="<?php echo $ord['Ord_ID'] ?>">
                                <input type="text" name="Menu_ID" class="d-none" value="<?php echo $ord['Menu_ID'] ?>">
                                <button class="btn badge btn-primary" type="submit" name="submit">Arrived</button>
                            </form>
                            <?php } else { ?>
                            <form action="order.php?delete" method="post" class="col-md-6">
                                <input type="text" name="Ord_ID" class="d-none" value="<?php echo $ord['Ord_ID'] ?>">
                                <input type="text" name="Menu_ID" class="d-none" value="<?php echo $ord['Menu_ID'] ?>">
                                <input type="text" name="Qty" class="d-none" value="<?php echo $ord['Qty'] ?>">
                                <button class="btn badge btn-danger" type="submit" name="submit">Cancel</button>
                            </form>
                            <?php }
                                    } else
                                        echo 'Delivered';
                                    ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php }
include 'inc/footer.php';
?>