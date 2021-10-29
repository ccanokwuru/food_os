<?php
session_start();

include 'functions.php';

$msg = "";
$role = "";

$type = $_REQUEST['auth'];

// get user from db
if (isset($_SESSION['email'])) {
    getUser($_SESSION['email']);
    $role = $_SESSION['userType'];
}



// only access if not logged in
if (isset($_SESSION['email']) && $type !== 'logout')
    $_SESSION['userType'] === 'cus' ?
        header('location: my-basket.php') :
        header('location: dashboard/');

// auth
if (isset($_POST['submit'])) {

    $msg = auth($type);
    $role = $_SESSION['userType'];
}

$_SESSION['pageTitle'] = $type;
// print_r($user);

include 'inc/header.php';
?>

<section class="my-5 py-5 page">
    <div class="container col-md-6 my-5">
        <script>
        const msg = `<?php echo $msg ?>`;
        const role = `<?php echo $role ?>`;
        const success = msg === 'Successful';

        console.log(success)
        if (success)
            role === 'adm' || role === 'emp' ?
            window.onload = () => setInterval(() => {
                redirect('/dashboard', true);
            }, 3000) :
            window.onload = () => setInterval(() => {
                redirect('/my-basket.php', true);
            }, 3000);

        consol.log(email)
        </script>
        <!-- login -->
        <?php if ($type === 'login') { ?>
        <form class="p-4 bg-white rounded shadow-sm" method="post">
            <h5 class="text-red text-center" style="font-weight: bolder;">
                Login
            </h5>
            <?php if (isset($msg)) { ?>
            <div class="text-info text-center text-capitalize">
                <strong> Login
                    <?php echo $msg ?>
                </strong>
            </div>
            <?php } ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder=""
                    aria-describedby="helpId">
                <small id="helpId" class="text-muted">user@example.com</small>
            </div>
            <div class="form-group">
                <label for="email">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder=""
                    aria-describedby="helpId">
                <small id="helpId" class="text-muted">your secret password</small>
            </div>

            <div class="form-group row">
                <div class="col-md-5">
                    <button type="submit" class="btn btn-red btn-lg btn-block" name="submit">Login</button>
                </div>
                <div class="col-md-7 text-center">
                    <a href="./auth.php?auth=register">Don't have an Account? <br> Create one today</a>
                </div>
            </div>
        </form>

        <?php } elseif ($type === 'register') { ?>

        <!-- register -->
        <form class="p-4 bg-white rounded shadow-sm" method="post">
            <h5 class="text-red text-center" style="font-weight: bolder;">
                Register
            </h5>
            <?php if (isset($msg)) { ?>
            <div class="text-info  text-center text-capitalize">
                <strong> Registration
                    <?php echo $msg ?>
                </strong>
            </div>
            <?php } ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder=""
                    aria-describedby="helpId">
                <small id="helpId" class="text-muted">user@example.com</small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder=""
                    aria-describedby="helpId">
                <small id="helpId" class="text-muted">your secret password</small>
            </div>
            <div class="form-group">
                <label for="confirm">Confirm Password</label>
                <input type="password" name="confirm" id="confirm" class="form-control" placeholder=""
                    aria-describedby="helpId">
                <small id="helpId" class="text-muted">your secret password again</small>
            </div>

            <div class="form-group row">
                <div class="col-md-5">
                    <button type="submit" class="btn btn-red btn-lg btn-block" name="submit">Register</button>
                </div>
                <div class="col-md-7 text-center">
                    <a href="./auth.php?auth=login">Already have an Account? <br> Login</a>
                </div>
            </div>
        </form>
        <?php } elseif ($type === 'logout') {
            logout();
        ?>

        <!-- loged out success -->

        <div class="container text-capitalize text-center">
            <h1 class="h-title">
                you have logged out successfully
            </h1>

            <script>
            window.onload =
                setInterval(() => {
                    redirect('/', true);
                }, 3000);
            </script>

        </div>
        <?php } ?>

    </div>
</section>

<?php
include 'inc/footer.php';
?>