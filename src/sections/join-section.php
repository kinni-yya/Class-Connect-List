<?php
include "../../includes/config.php";
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION["user_email"])) {
    header("Location: ../../index.php");
    die();
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet" /> -->
    <?php getHead(); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- <link href="../../css/custom.css" rel="stylesheet" type="text/css"> -->
</head>

<body>
    <?php getHeader(); ?>

    <div class="col text-center fs-1 fw-semibold">You have not joined any classes, yet.</div>
    <div class="col text-center fs-4 fw-default">Are you a class officer? Click here to create a classroom!</div>
    <div class="col text-center">
        <button type="button" class="btn btn-primary">Join Section</button>
    </div>

</body>

</html> <br /><br />