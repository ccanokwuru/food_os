<?php
session_start();

include 'functions.php';
$categories = getMenu('cat');

$_SESSION['pageTitle'] = 'home';
include 'inc/header.php';
?>

<!-- banner section -->
<section class="bg-white mb-5 banner-section">
    <div class="container">
        <div class="row">
            <div class="banner-img pt-3 d-none d-md-block">
                <img src="images/headerimg.jpg" alt="add loading">
            </div>
            <div class="col-md-6 px-2 align-self-center">
                <h1 class="m-0 text-secondary" style="font-weight:bolder"> Get Yummy</h1>
                <h2 class="h-title text-dark"> Food </h2>

                <h2 class="text-secondary">
                    <i class="fa fa-at text-red" aria-hidden="true"></i>
                    <b>Your Doorstep</b>
                </h2>
                <a href="menu.php" class="btn btn-red text-white text-capitalize" style="border-radius: 25px;">
                    <h4>start
                        ordering now</h4>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- menu section -->
<section class="my-5 py-5">
    <div class="container">
        <h3 class="text-red text-center"><b>Menu</b></h3>
        <div class="d-flex justify-content-start align-self-center cardCarousel" id="cardCarousel"
            style="position: relative;">
            <!-- <div class="scrollbtns align-self-center row justify-content-between w-100 m-0">
                <button class="btn btn-warning text-white btn-sm" id="scrollLeft"><i class="fa fa-chevron-left"
                        aria-hidden="true"></i></button>
                <button class="btn btn-warning text-white btn-sm" id="scrollRight"><i class="fa fa-chevron-right"
                        aria-hidden="true"></i></button>
            </div> -->
            <div class="col-md-6 col-lg-4 p-3 carouselCard">
                <div class="card border-none shadow-sm">
                    <div class="menu-img-container">
                        <img class="card-img-top" src="images/all.jpg " alt="Card image cap"
                            style="background-color: grey;">
                    </div>
                    <div class="card-body text-center">
                        <h4><b>All</b></h4>
                        <a href="menu-category.php?cat=all" class=" btn btn-red text-white btn-block">
                            Open <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php if (isset($categories)) {
                foreach ($categories as $category) { ?>

            <div class="col-md-6 col-lg-4 p-3 carouselCard">
                <div class="card border-none shadow-sm">
                    <div class="menu-img-container">
                        <img class="card-img-top" src="<?php echo $category['Image'] ?>" alt="Card image cap"
                            style="background-color: grey;">
                    </div>
                    <div class="card-body text-center">
                        <h4><b><?php echo $category['MenName'] ?></b></h4>
                        <a href="menu-category.php?cat=<?php echo $category['MenuCat_ID'] ?>"
                            class=" btn btn-red text-white btn-block">
                            Open <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php }
            } ?>
        </div>
    </div>

</section>

<!-- app section -->
<section class="bg-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 p-3 align-self-center app-section">
                <h1 class="text-red text-capitalize h-title">
                    get started with FeedMe today
                </h1>
                <h3 class="h-subtitle">
                    Food anywhere, anytime and delivered A.S.A.P
                </h3>
                <a class="btn btn-red ad-btn">
                    <h3 class="m-0">GET THE APP</h3>
                </a>
            </div>
            <div class="col-md-4 p-3 d-none d-md-block">
                <div class="my-5 border-none">
                    <img class="img-fluid" src="./images/feedmelogo.png" alt="Card image cap">
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'inc/footer.php';
?>