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

<body class="bg-light">
    <?php getHeader(); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card bg-white p-4 rounded boarder shadow">
                    <div class="card-header">
                        <h4 class="card-title">Add Member to a Class</h4>
                    </div>
                    <div class="card-body">
                        <form id="joinClassForm">
                            <div class="mb-3">
                                <label class="form-label">Class/Subject Code</label>
                                <input type="text" class="form-control" name="code" required>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary me-2">Join</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <!--JQUERY CDN-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"> </script>

    <script>
        $("#joinClassForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "class_process.php",
                type: "POST",
                data: $("#joinClassForm").serialize(),
                success: function(data) {
                    if (data > 0) {
                        window.location = "view-class-todo.php?class_id=" + data;
                    } else if (data == 0) {
                        alert("The subject code does not exist!");
                    } else if (data.match("Error: ")) {
                        alert(data);
                    }
                }
            });

        });
    </script>


</body>

</html>