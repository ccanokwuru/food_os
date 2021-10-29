<?php
session_start();

include 'functions.php';

$_SESSION['pageTitle'] = 'menu category';
include 'inc/header.php';
?>

<!-- menu categories -->
<section class="mb-5 py-5 page">
    <div class="container mt-5">

        <?php if (isset($categories)) { ?>

        <h1 class="text-center text-red py-5"><b>Our Menu Categories</b></h1>
        <div class="row justify-content-around">
            <div class="col-md-6 col-lg-4 p-3">
                <div class="card border-none shadow-sm">
                    <div class="menu-img-container">
                        <img class="card-img-top" src="images/all.jpg " alt="Card image cap"
                            style="background-color: grey;">
                    </div>
                    <div class="card-body text-center">
                        <h4><b>All</b></h4>
                        <a href="menu.php" class=" btn btn-red text-white btn-block">
                            Open <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php if (isset($categories)) {
                    foreach ($categories as $category) { ?>

            <div class="col-md-6 col-lg-4 p-3">
                <div class="card border-none shadow-sm">
                    <div class="menu-img-container">
                        <img class="card-img-top" src="<?php echo $category['Image'] ?>" alt="Card image cap"
                            style="background-color: grey;">
                    </div>
                    <div class="card-body text-center">
                        <h4><b><?php echo $category['MenName'] ?></b></h4>
                        <a href="menu.php?cat=<?php echo $category['MenuCat_ID'] ?>"
                            class=" btn btn-red text-white btn-block">
                            Open <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php }
                } ?>
        </div>

        <?php } else { ?>

        <!-- display menus-->
        <h1 class="text-center text-red py-5 h-title"><b>Nothing Found</b></h1>

        <?php } ?>
    </div>
</section>

<?php include 'inc/footer.php'; ?>