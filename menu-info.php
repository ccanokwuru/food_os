<?php
session_start();

include 'functions.php';

if (isset($_REQUEST['menuid'])) {
    $menu = getMenuById($_REQUEST['menuid'], 'menu');
}

$_SESSION['pageTitle'] = 'food info';
include 'inc/header.php';
?>

<!-- login -->
<section class="mb-5 py-5 page">
    <div class="container my-5">
        <?php if (!isset($menu)) { ?>

        <h1 class="text-center text-red py-5 h-title"><b>Nothing Found</b></h1>

        <?php } else { ?>

        <!-- display menus-->
        <h1 class="text-center text-red py-5"><b><?php echo ucwords($menu['MenName']) ?></b></h1>

        <div class="p-3 mb-5 row">
            <div class="col-md-5 px-5 py-2 text-center">
                <div class="container-fluid" style="max-height: 300px; min: height 200px;">
                    <img class="img-fluid" src="<?php echo $menu['Image'] ?>" alt="Card image cap"
                        style="background-color: grey;">
                </div>

                <div class="my-3 row">
                    <div class="col-md-5">
                        <?php echo $menu['Qtyinstock'] ?> Left
                    </div>
                    <div class="col-md-7">
                        Price: <b> &#8358; <?php echo $menu['BuyPrice'] ?></b>
                    </div>
                </div>
                <form action="./my-basket.php?add" method="post">
                    <input type="number" class="d-none" name="menuId" value="<?php echo $menu['Menu_ID'] ?>">
                    <button class="btn btn-red text-white btn-block" type="submit">
                        <b>Buy <i class="fa fa-shopping-basket" aria-hidden="true"></i></b>
                    </button>
                </form>
            </div>
            <div class="col-md-7 px-2 border">
                <?php echo $menu['Description'] ?>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

<?php
include 'inc/footer.php';
?>