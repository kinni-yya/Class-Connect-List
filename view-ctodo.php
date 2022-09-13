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
        <div class="row">
            <?php
            $todoId = mysqli_real_escape_string($conn, $_GET["id"]);

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

            $sql1 = "SELECT * FROM classtodos WHERE id='{$todoId}'";
            $res1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($res1) > 0) {
                foreach ($res1 as $todo) {
            ?>
                    <main>
                        <a href="view-class-todo.php" class="mb-3 btn btn-outline-primary btn-sm text-dark">←Back to Class Notes</a>
                        <h1><?php echo $todo["note_title"]; ?></h1>
                        <p class="fs-5 col-md-8"><?php echo $todo["note_description"]; ?></p>

                        <div class="mb-5">
                            <a href="<?php echo 'edit-class-todo.php?id=' . $todo['id']; ?>" class="btn btn-primary btn-lg px-4">Edit</a>
                        </div>

                    </main>
            <?php }
            } else {
                header("Location: view-class.php");
                die();
            } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>