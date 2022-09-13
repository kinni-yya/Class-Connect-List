<?php
include "includes/config.php";
session_start();
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}

if (isset($_GET["id"])) {
    $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
} else {
    header("Location: todos.php");
}

$msg = "";

if (isset($_POST["updateTodo"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $desc = mysqli_real_escape_string($conn, $_POST["desc"]);

    // Updating todo
    $sql = "UPDATE todos SET title='{$title}', description='{$desc}', date=CURRENT_TIMESTAMP WHERE id='{$todoId}'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $_POST["title"] = "";
        $_POST["desc"] = "";
        $msg = "<div class='alert alert-success'>Todo is updated.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Todo is not updated.</div>";
    }
}

$sql = "SELECT id FROM users WHERE email='{$_SESSION["user_email"]}'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
if ($count > 0) {
    $row = mysqli_fetch_assoc($res);
    $user_id = $row["id"];
} else {
    $user_id = 0;
}

$sql = "SELECT * FROM todos WHERE id='{$todoId}' AND user_id='{$user_id}'";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) > 0) {
    $todoData = mysqli_fetch_assoc($res);
} else {
    header("Location: todos.php");
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
                        <h4 class="card-title">Edit To-Do</h4>
                    </div>
                    <div class="card-body">
                        <?php echo $msg; ?>
                        <form action='' method='POST'>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="e.g. IAS Project" value="<?php echo $todoData['title']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Details</label>
                                <textarea class="form-control" id="desc" name="desc" rows="3" required><?php echo $todoData['description']; ?></textarea>
                            </div>
                            <div>
                                <button type="submit" name="updateTodo" class="btn btn-primary me-2">Update To-do</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>