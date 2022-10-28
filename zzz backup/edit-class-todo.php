<?php
include "includes/config.php";
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}

if (isset($_GET["id"])) {
    $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
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
                        <h4 class="card-title">Edit Class To-Do</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM classtodos WHERE id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($result);
                        if ($count > 0) {
                            $row = $result->fetch_assoc();
                        ?>
                            <form id="editClassTodo">
                                <div class="mb-3">
                                    <label for="note_title" class="form-label">Note Title</label>
                                    <input type="text" class="form-control" id="edit_note_title" name="edit_note_title" placeholder="e.g. Assignment, Group Activity, Project" value="<?php echo $row['note_title']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="desc" class="form-label">Note Description/Details</label>
                                    <textarea class="form-control" id="edit_note_desc" name="edit_note_desc" rows="3" required><?php echo $row['note_description']; ?></textarea>
                                </div>
                                <div>
                                    <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id" />
                                </div>
                                <div>
                                    <button type="submit" name="updateTodo" class="btn btn-primary me-2">Update Class To-do</button>
                                </div>
                            </form>
                        <?php
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        } ?>
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
        $("#editClassTodo").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "class-todo_process.php",
                type: "POST",
                data: $("#editClassTodo").serialize(),
                success: function(data) {
                    if (data > 0) {
                        window.location = "view-class-todo.php?class_id=" + data;
                    } else if (data.match("Error: ")) {
                        alert(data);
                    }
                }
            });

        });
    </script>


</body>

</html>