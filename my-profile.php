<?php
session_start();

if (!$_SESSION['email'] || $_SESSION['userType'] !== 'cus')
    header('location: ./');

include 'functions.php';
$categories = getMenu('cat');

if (isset($_SESSION['email'])) {
    $user = getUserByEmail($_SESSION['email']);
}
if (isset($_POST['submit'])) {
    updateProfile();

    header('location: my-profile.php');
}

$_SESSION['pageTitle'] = 'my profile';
include 'inc/header.php';
?>

<!-- info -->
<!-- Cus_ID FirstName LastName Address Mobile Email DateCreated -->
<section class="py-5 mb-5 page">
    <div class="container mt-5">
        <h1 class="text-center text-red py-5"><b>My Profile</b></h1>
        <div class="bg-white rounded shadow-sm p-5">

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
                        value="<?php echo $user['Mobile'] ?>">
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
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
include 'inc/footer.php';
?>