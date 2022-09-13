<?php
include "includes/config.php";
session_start();
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
        <div class="col-md-12 mx-auto">
                <div class="card bg-white p-4 rounded boarder shadow"> 
                    <div class="card-body">
                        <div class="card-header bg-white">
                            <h1 class="mb-4 fw-bold">Group CheckLists</h1>
                        </div>
                        <div class="container">
                            <div class="list-group w-auto">
                                <label class="list-group-item d-flex gap-3">
                                    <input class="form-check-input flex-shrink-0" type="checkbox" value="" checked="" style="font-size: 1.375em;">
                                    <span class="pt-1 form-checked-content">
                                    <strong>Finish Projects</strong>
                                    <small class="d-block text-muted">
                                        <use xlink:href="#calendar-event"></use>
                                        1:00–2:00pm
                                    </small>
                                    </span>
                                </label>
                                <label class="list-group-item d-flex gap-3">
                                    <input class="form-check-input flex-shrink-0" type="checkbox" value="" style="font-size: 1.375em;">
                                    <span class="pt-1 form-checked-content">
                                    <strong>Turn-in Assignments</strong>
                                    <small class="d-block text-muted">
                                        <use xlink:href="#calendar-event"></use>
                                        2:00–2:30pm
                                    </small>
                                    </span>
                                </label>
                                <label class="list-group-item d-flex gap-3">
                                    <input class="form-check-input flex-shrink-0" type="checkbox" value="" style="font-size: 1.375em;">
                                    <span class="pt-1 form-checked-content">
                                    <strong>Attend Seminars</strong>
                                    <small class="d-block text-muted">
                                        <use xlink:href="#alarm"></use>
                                        Tomorrow
                                    </small>
                                    </span>
                                </label>
                                <label class="list-group-item d-flex gap-3">
                                    <input class="form-check-input flex-shrink-0" type="checkbox" value="" style="font-size: 1.375em;">
                                    <span class="pt-1 form-checked-content">
                                    <strong>Class for IAS</strong>
                                    <small class="d-block text-muted">
                                        <use xlink:href="#alarm"></use>
                                        7:30am-12:30pm
                                    </small>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>