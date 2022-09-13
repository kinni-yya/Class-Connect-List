<?php
include "includes/config.php";
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}
?>

<!doctype html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body>
    <?php getHeader(); ?>
    <div class="container">
        <h1 class="mb-4 fw-bold">Class</h1>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">See Class Lists</h4>
                    </div>
                    <div class="card-body">
                        <a href="view-class.php"><button type="button" class="w-100 btn btn-lg btn-outline-primary">View Classes</button></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Add Class</h4>
                    </div>
                    <div class="card-body">
                        <a href="add-class.php"><button type="button" class="w-100 btn btn-lg btn-outline-primary">Add</button></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Join Classes</h4>
                    </div>
                    <div class="card-body">
                        <a href="join-class.php"><button type="button" class="w-100 btn btn-lg btn-outline-primary">Join</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>