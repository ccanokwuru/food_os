<?php
session_start();

include 'functions.php';
// $categories = getMenu('cat');

$menu = getMenu('menu');
$catName = 'all';

if (isset($_REQUEST['cat']) && $_REQUEST['cat'] !== 'all') {
    $catName = getMenuById($_REQUEST['cat'], 'cat')['MenName'];
    $menu = getMenuByCatId($_REQUEST['cat']);
}

// return print_r($menu);

$_SESSION['pageTitle'] = 'menu';
include 'inc/header.php';
?>

<!-- menu categories -->
<section class="mb-5 py-5 page">
    <div class="container mt-5">

        <?php if (!isset($menu)) { ?>

        <h1 class="text-center text-red py-5 h-title"><b>Nothing Found</b></h1>

        <?php } else { ?>

        <!-- display menus-->
        <h1 class="text-center text-red py-5"><b><?php echo ucwords($catName) ?></b></h1>

        <div class="p-3 mb-5 row">
            <?php foreach ($menu as $menu) { ?>
            <div class="col-md-6 col-lg-4 p-3">
                <div class="card border-none shadow-sm">
                    <div class="menu-img-container">
                        <a href="./menu-info.php?menuid=<?php echo $menu['Menu_ID'] ?>" class="link text-dark">
                            <h6 class="item-price pl-4 p-2 bg-red text-white">
                                <b> &#8358; <?php echo $menu['BuyPrice'] ?></b>
                            </h6>
                            <img class="card-img-top" src="<?php echo $menu['Image'] ?>" alt="Card image cap"
                                style="background-color: grey;">
                        </a>
                    </div>
                    <div class="card-body text-center">
                        <a href="./menu-info.php?menuid=<?php echo $menu['Menu_ID'] ?>" class="link text-dark">
                            <h4><b><?php echo $menu['MenName'] ?></b></h4>
                        </a>
                        <strong class="">
                            <?php echo $menu['Qtyinstock'] > 0 ? 'In stock' : 'Out of stock' ?>
                        </strong>
                        <form action="./my-basket.php?add" method="post">
                            <input type="number" class="d-none" name="menuId" value="<?php echo $menu['Menu_ID'] ?>">
                            <button class="btn btn-red text-white btn-block" type="submit">
                                <b>Buy <i class="fa fa-shopping-basket" aria-hidden="true"></i></b>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</section>

<?php include 'inc/footer.php'; ?>