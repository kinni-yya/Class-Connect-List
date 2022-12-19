<?php
include "../dbconnect.php";
OpenSession();

// Check if the user is in a class
if (checkClassJoin($_SESSION['user_id']) == FALSE) {
    header("location: no-class.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My List - Class Connect List</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sections.css">
    <link rel="stylesheet" href="../css/with-class.css">
    <link rel="stylesheet" href="../css/my-list.css">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
</head>

<body id="scrll">
    <?php DisplayNavHeader(); ?>
    <!-- MY LIST HEADER -->
    <div class="container">
        <div class="website-content">
            <p>My List</p>
        </div>
        <div class="cardwclass">
            <div class="buttons">
                <button type="button" class="view" onclick="openAddUserNoteForm()">ADD TO-DO</button>
            </div>
        </div>
    </div>

    <!-- DISPLAY TO-DOs -->

    <div class="case">
        <?php
        $user_note_info = GetUserNote($_SESSION['user_id']);

        while ($rows = $user_note_info->fetch_assoc()) {    ?>
            <div class="card">
                <i class="fa-solid fa-box-archive" onclick="location.href='#'"></i>
                <div class="cname">
                    <p><?php echo $rows['note_title']; ?></p>
                </div>
                <p>Post Date: <span><?php echo $rows['post_date']; ?></span></p></br>
                <p><?php
                    $description = $rows['description'];
                    // Split the text into an array of words
                    $words = explode(' ', $description);
                    // Limit the array to the first 20 words
                    $limitedWords = array_slice($words, 0, 20);
                    // Join the words back into a string and echo the result
                    echo implode(' ', $limitedWords) . "...";
                    ?></p>
                </br>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="buttonswclass">
                        <button type="button" class="view" onclick="location.href='#'">VIEW/EDIT</button>
                        <!-- <button type="button" class="view" onclick="location.href='#'">EDIT</button> -->
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- ADD USER NOTE FORM -->
    <div id="blur" onclick="closeAddUserNoteForm()"></div>
    <div class="center" id="center">
        <div class="form-popup" id="add-class-form">
            <form id="formAddUserNote" class="form-container">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <button type="button" id="close" onclick="closeAddUserNoteForm()">X</button>

                <h1>ADD TO-DO</h1>
                <!-- Form to add Note -->
                <br>
                <div class="form-group">
                    <label>Note/Task Title</label>
                    <input type="text" class="form-control" name="note_title" placeholder="Title" required>
                </div>

                <div class="form-group">
                    <label>Description</label><br>
                    <textarea class="form-control" name="description" style="height: 300px" placeholder="Note Description (optional)"></textarea>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-auto">
                        <label class="col-form-label">Due date</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="due_date">
                    </div>

                    <div class="col-auto">
                        <label class="col-form-label">Due Time</label>
                    </div>
                    <div class="col-auto">
                        <input type="time" class="form-control" name="due_time">
                    </div>

                    <div class="col-auto">
                        <span class="form-text">Due date and/or time are optional!</span>
                    </div>
                </div>
                <!-- END Form to add Note -->
                <br><button type="submit" class="btn">ADD</button>
            </form>
        </div>
    </div>
    <!-- OLD MY LIST -->
    <!-- <div class="create-container">
        <h1 class="mb-2 fw-bold">My List</h1>
        <a href="add-todo.php" class="mb-3 btn btn-outline-primary text-dark">Add To-Do</a>
        <div id="row" class="row">
            <div id="to-do" class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title">Title of To-Do</h3>
                        <p class="card-text text-justify">Ipsum consectetur nostrud elit ea magna elit Lorem dolore elit proident.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="#" type="button" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="#" type="button" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </div>
                            <small class="text-muted">Dec. 25, 2022</small>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div> -->

    <!-- AJAX / jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Get the form value and send to the with-class-process for joining class -->
    <script type="text/javascript">
        $("#formAddUserNote").submit(function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                type: 'POST',
                url: 'my-list-process.php',
                data: form.serialize(),
                success: function(data) {
                    if (data > 0) {
                        alert("Note added successfully!");
                        // window.location.replace("../notes/note.php?class_id=" + data);
                        window.location.replace("my-list.php");
                    } else {
                        alert(data);
                    }
                    alert(data);
                    location.reload();
                }
            });
        });
    </script>
    <script type="text/javascript">
        function openAddUserNoteForm() {
            document.getElementById("add-class-form").style.display = "block";
            document.getElementById('blur').style.filter = "blur(5px)";
            document.getElementById('blur').style.display = "block";
            document.getElementById('scrll').style.overflow = "hidden";
        }

        function closeAddUserNoteForm() {
            document.getElementById("add-class-form").style.display = "none";
            document.getElementById('blur').style.filter = "blur(0)";
            document.getElementById('blur').style.display = "none";
            document.getElementById('scrll').style.overflow = "auto";
        }
    </script>

</body>

</html>