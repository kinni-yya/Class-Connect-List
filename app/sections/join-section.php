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
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet" />
    <?php getHead(); ?>
</head>

<body>
    <?php getHeader(); ?>
    <!-- <div class="container">
        <h1 class="mb-4 fw-bold">Class</h1>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">HOTDOG</h4>
                    </div>
                    <div class="card-body">
                        <a href="../classes/view-class.php"><button type="button" class="w-100 btn btn-lg btn-outline-primary">View Classes</button></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Add Class</h4>
                    </div>
                    <div class="card-body">
                        <a href="../classes/add-class.php"><button type="button" class="w-100 btn btn-lg btn-outline-primary">Add</button></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Join Classes</h4>
                    </div>
                    <div class="card-body">
                        <a href="../../join-class.php"><button type="button" class="w-100 btn btn-lg btn-outline-primary">Join</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html> -->
    <div class="v169_44">
        <div class="v12_102"><span class="v12_101">Join Section</span></div><span class="v12_103">Are you a class officer? Click here to create a classroom!</span><span class="v4_89">You have not joined any classes, yet. </span>
    </div>
    </div>
    </div>
</body>

</html> <br /><br />
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-size: 14px;
    }

    .v185_280 {
        width: 100%;
        height: 720px;
        background: url("../images/v185_280.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: relative;
        top: 0px;
        left: 0px;
        overflow: hidden;
    }

    .v169_56 {
        width: 100%;
        height: 720px;
        background: url("../images/v169_56.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: relative;
        top: 0px;
        left: 0px;
        overflow: hidden;
    }

    .v169_45 {
        width: 100%;
        height: 720px;
        background: url("../images/v169_45.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: relative;
        top: 0px;
        left: 0px;
        overflow: hidden;
    }

    .v169_46 {
        width: 100%;
        height: 720px;
        background: rgba(255, 255, 255, 1);
        opacity: 1;
        position: relative;
        top: 0px;
        left: 0px;
        overflow: hidden;
    }

    .v169_47 {
        width: 100%;
        height: 55px;
        background: url("../images/v169_47.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: absolute;
        top: 31px;
        left: 0px;
        overflow: hidden;
    }

    .name {
        color: #fff;
    }

    .name {
        color: #fff;
    }

    .v169_50 {
        width: 64px;
        color: rgba(0, 0, 0, 1);
        position: absolute;
        top: 7px;
        left: 1064px;
        font-family: Work Sans;
        font-weight: Medium;
        font-size: 12px;
        opacity: 1;
        text-align: left;
    }

    .v169_51 {
        width: 64px;
        color: rgba(0, 0, 0, 1);
        position: absolute;
        top: 7px;
        left: 952px;
        font-family: Work Sans;
        font-weight: Medium;
        font-size: 12px;
        opacity: 1;
        text-align: left;
    }

    .v169_52 {
        width: 43px;
        color: rgba(0, 0, 0, 1);
        position: absolute;
        top: 7px;
        left: 861px;
        font-family: Work Sans;
        font-weight: Medium;
        font-size: 12px;
        opacity: 1;
        text-align: left;
    }

    .v169_53 {
        width: 47px;
        color: rgba(0, 0, 0, 1);
        position: absolute;
        top: 7px;
        left: 766px;
        font-family: Work Sans;
        font-weight: Medium;
        font-size: 12px;
        opacity: 1;
        text-align: left;
    }

    .v169_54 {
        width: 326px;
        color: rgba(0, 0, 0, 1);
        position: absolute;
        top: 2px;
        left: 36px;
        font-family: Work Sans;
        font-weight: Medium;
        font-size: 20px;
        opacity: 1;
        text-align: left;
    }

    .v169_44 {
        width: 429px;
        height: 97px;
        background: url("../images/v169_44.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        opacity: 1;
        position: absolute;
        top: 311px;
        left: 426px;
        overflow: hidden;
    }

    .v12_102 {
        width: 87px;
        height: 33px;
        background: url("../images/v12_102.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        padding: 10px 10px;
        margin: 10px;
        opacity: 1;
        position: absolute;
        top: 64px;
        left: 171px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
        overflow: hidden;
    }

    .v12_101 {
        width: 67px;
        color: rgba(0, 0, 0, 1);
        position: absolute;
        top: 10px;
        left: 10px;
        font-family: Work Sans;
        font-weight: Regular;
        font-size: 11px;
        opacity: 1;
        text-align: left;
    }

    .v12_103 {
        width: 280px;
        color: rgba(0, 0, 0, 0.7900000214576721);
        position: absolute;
        top: 40px;
        left: 78px;
        font-family: Work Sans;
        font-weight: Regular;
        font-size: 10px;
        opacity: 1;
        text-align: left;
    }

    .v4_89 {
        width: 429px;
        color: rgba(0, 0, 0, 1);
        position: relative;
        top: 0px;
        left: 0px;
        font-family: Work Sans;
        font-weight: Regular;
        font-size: 24px;
        opacity: 1;
        text-align: left;
    }
</style>