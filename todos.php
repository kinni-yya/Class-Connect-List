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
        <h1 class="mb-2 fw-bold">My List</h1>
        <a href="add-todo.php" class="mb-3 btn btn-outline-primary text-dark">Add To-Do</a>
        <div class="row">
            <?php
                $sql = "SELECT id FROM users WHERE email='{$_SESSION["user_email"]}'";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                    $row = mysqli_fetch_assoc($res);
                    $user_id = $row["id"];
                } else {
                    $user_id = 0;
                }
                $sql = null;

                $sql1 = "SELECT * FROM todos WHERE user_id='{$user_id}' ORDER BY id DESC";
                $res1 = mysqli_query($conn, $sql1);
                if (mysqli_num_rows($res1) > 0) {
                    foreach ($res1 as $todo) {
            ?>
            <div class="col-lg-3 col-md-6 mb-4">
                <?php getTodo($todo); ?>
            </div>
            <?php } } else { echo "<h3 class='text-danger text-center fw-bold'>You have not set a To-Do!</h3>"; }?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>