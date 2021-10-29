<?php
session_start();

if (!$_SESSION['email'] || $_SESSION['userType'] !== 'cus')
    header('location: ./');

include 'functions.php';

if (!isset($_SESSION['myBasket'])) $_SESSION['myBasket'] = [];

if (isset($_REQUEST['add']) && isset($_POST['menuId'])) {
    addToBasket();

    header('location: ./my-basket.php');
} elseif (isset($_REQUEST['delete']) && isset($_POST['menuId'])) {
    deleteFromBasket();

    header('location: ./my-basket.php');
} elseif (isset($_REQUEST['update']) && isset($_POST['menuId'])) {
    updateBasket();

    header('location: ./my-basket.php');
}

$_SESSION['pageTitle'] = 'my basket';
$myBasket = $_SESSION['myBasket'];

// return print_r($myBasket);
include 'inc/header.php';
?>

<!-- food basket -->
<section class="mb-5 py-5 page">
    <div class="container my-5">
        <?php if (isset($myBasket) && count($myBasket) > 0) { ?>
        <div class="bg-white containter-fluid rounded p-3 shadow-sm">
            <h4 class="text-center text-red pb-4"><b>My Basket</b></h4>
            <div class="row text-capitalize text-center bold d-none d-md-flex">
                <b class="col-md-7 border-right">
                    item description
                </b>
                <b class="col-md-3 border-right">
                    amount
                </b>
                <b class="col-md-2">
                    remove
                </b>
            </div>
            <?php foreach ($myBasket as $item) {
                    $inStock = getMenuById($item['Menu_ID'], 'menu')['Qtyinstock'];
                ?>
            <div class="row border-bottom py-3">
                <div class="col-md-7">
                    <div class="row">
                        <div class="basket-img-holder col-md-3">
                            <a href="./menu-info.php?menuid=<?php echo $item['Menu_ID'] ?>" class="link">
                                <img src="<?php echo $item['Image'] ?>" alt="product image" sizes="300px" srcset=""
                                    class="img-fluid">
                            </a>
                        </div>
                        <div class="col-md-9 row">
                            <div class="col-md-7 px-3">
                                <a href="./menu-info.php?menuid=<?php echo $item['Menu_ID'] ?>" class="link text-dark">
                                    <h4 class="m-0"><?php echo $item['MenName'] ?></h4>
                                    <small>price: &#8358; <?php echo $item['BuyPrice'] ?></small>
                                    <small>qty: <?php echo $item['Qty'] ?></small>
                                    <?php if ($inStock < $item['Qty']) { ?>
                                    <em> insufficient stock reduce by <?= $item['Qty'] - $inStock ?></em>
                                    <?php } ?>
                                </a>
                            </div>

                            <form action="my-basket.php?update" method="post" class="form-inline col-md-5 px-3">
                                <input type="number" class="d-none" name="menuId" value=<?php echo $item['Menu_ID'] ?>>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Qty</span>
                                    </div>
                                    <input type="number" class="form-control" min="0" aria-label="Small"
                                        aria-describedby="inputGroup-sizing-sm" name="qty" id="qty"
                                        value=<?php echo $item['Qty'] ?>>
                                    <div class="input-group-append">
                                        <button class="btn btn-red" type="submit">Ok</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col col-md-3 text-center">
                    &#8358; <?php echo $item['BuyPrice'] * $item['Qty'] ?>
                </div>
                <div class="col col-md-2 text-center">
                    <form action="my-basket.php?delete" method="post">
                        <input type="number" class="d-none" name="menuId" value=<?php echo $item['Menu_ID'] ?>>
                        <button class="text-red btn" type="submit">
                            <b class="d-block d-md-none">Remove
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </b>
                            <b class="d-none d-md-block">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </b>
                        </button>
                    </form>
                </div>
            </div>
            <?php } ?>
            <div class="container col-md-6 py-3">
                <a href="order.php?new" class="btn btn-red container btn-block"> <b>Buy Now</b></a>
            </div>
        </div>
        <?php } else { ?>
        <h1 class="text-center text-red py-5 h-title"><b>Nothing Found</b></h1>
        <?php } ?>
    </div>
</section>

<?php
include 'inc/footer.php';
?>