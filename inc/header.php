<?php
$categories = getMenu('cat');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="images/feedmelogo.svg" type="image/x-icon">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <!-- <link rel="stylesheet" href="css/styles.css"> -->
    <link rel="stylesheet" href="css/style.css">
    <title>F.O.S - <?= ucwords($_SESSION['pageTitle']); ?></title>

</head>

<body class="bg-light">
    <header class="">
        <div class="d-flex alig-content-center container justify-content-between head-flex">
            <div class="logo-container">
                <div class="logo ">
                    <a href="./" class="">
                        <img src="images/feedmelogo.svg" alt="" class="img-fluid">
                    </a>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="nav navbar-nav text-capitalize navbar-collapse collapse " id="navigate">
                    <li class="nav-item px-2">
                        <a class="nav-link" href="./">home</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="./why-feedme.php">Why FeedMe?</a>
                    </li>
                    <li class="nav-item px-2 dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#drop-menu" id='menu-category'>menu
                            <i class="fa fa-chevron-down text-red" aria-hidden="true"></i>
                        </a>


                        <div class="dropdown-menu header-drop shadow-sm" aria-labelledby="drop-menu">
                            <a class="dropdown-item nav-link" href="menu-category.php">Categories</a>

                            <?php if (isset($categories)) {
                                foreach ($categories as $category) { ?>

                            <a class="dropdown-item nav-link"
                                href="menu.php?cat=<?php echo $category['MenuCat_ID'] ?>"><?php echo $category['MenName'] ?></a>
                            <?php }
                            } ?>
                        </div>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link" href="contact-us.php">contact us</a>
                    </li>
                </ul>
            </nav>
            <div class="acc-search align-self-center d-flex">
                <a class="btn text-red navbar-toggler border-none d-lg-none nav-btn" data-toggle="collapse"
                    href="#navigate">
                    <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                </a>

                <a class="btn text-red" data-toggle="collapse" href="#search-form">
                    <i class="fa fa-search"></i>
                </a>

                <div class="dropdown">
                    <a class="btn btn-red text-white font-weight-bold" data-toggle="dropdown" data-target="#acc-drop">
                        My Account <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>

                    <div class="dropdown-menu header-drop shadow-sm" aria-labelledby="acc-drop">
                        <?php if (isset($_SESSION['email'])) { ?>

                        <a class="dropdown-item nav-link"
                            href="<?php echo $_SESSION['userType'] === 'cus' ? 'my-profile.php' : 'dashboard/my-profile.php' ?>">My
                            Profile
                        </a>
                        <?php if ($_SESSION['userType'] === 'cus') { ?>
                        <a class="dropdown-item nav-link" href="my-basket.php">My Basket</a>

                        <a class="dropdown-item nav-link" href="order.php">My Order</a>
                        <?php } ?>

                        <?php if ($_SESSION['userType'] !== 'cus') { ?>

                        <a class="dropdown-item nav-link" href="dashboard">Dashboard</a>

                        <?php } ?>

                        <a class="dropdown-item nav-link" href="auth.php?auth=logout">Logout</a>

                        <?php } else { ?>

                        <a class="dropdown-item nav-link" href="auth.php?auth=login">Login</a>
                        <a class="dropdown-item nav-link" href="auth.php?auth=register">Register</a>

                        <?php } ?>
                    </div>
                </div>


            </div>
        </div>
        <div class="container py-2 collapse" id="search-form">
            <form class="form-inline  container-fluid" action="#">
                <div class="form-group w-100">
                    <div class="input-group border-none w-100 mx-5">
                        <input type="search" class="form-control  border-bottom" name="search" id="search"
                            placeholder="Quick Searh" aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button class="btn btn-red" type="submit"><i class="fa fa-search"
                                    aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </header>

    <div class="page">