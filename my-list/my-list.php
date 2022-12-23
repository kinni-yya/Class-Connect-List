<?php
include "../dbconnect.php";
OpenSession();

// Check if the user is in a class
if (checkClassJoin($_SESSION['user_id']) == FALSE) {
    header("location: ../class/no-class.php");
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
    <link rel="stylesheet" href="../css/manage-class.css">
    <link rel="stylesheet" href="../css/my-list.css">
    <script src="https://kit.fontawesome.com/c11ce9a287.js" crossorigin="anonymous"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
</head>

<body id="scrll">
    <?php DisplayNavHeader(); ?>

    <p class="subj">MY LIST</p>

    <div class="buttons">
        <button class="button" onclick="openAddUserNoteForm()">ADD TO-DO</button>
    </div>

    <!-- BLUR -->
    <div id="blur" onclick="closeUserNoteForm()"></div>

    <!-- POPUP (ADD) -->
    <!-- ADD USER NOTE FORM -->
    <div id="addpopup" class="popup">
        <form id="formAddUserNote" class="form-container">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <!-- <button type="button" id="close" onclick="closeAddUserNoteForm()">X</button> -->

            <p class="addsubj-title">
                ADD TO-DO
            </p>
            <!-- Form to add Note -->
            <label>Note/Task Title</label>
            <input type="text" class="form-control" name="note_title" placeholder="Title" required>

            <label>Description</label>
            <textarea class="form-control" name="description" style="height: 100px" placeholder="Note Description (optional)"></textarea>
            <div>
                <label>Due date</label>
            </div>
            <div>
                <input type="date" class="form-control" name="due_date">
            </div>

            <div>
                <label>Due Time</label>
            </div>
            <div>
                <input type="time" class="form-control" name="due_time">
            </div>

            <div>
                <br>
                <span class="form-text">Due date and/or time are optional!</span>
            </div>
            <!-- END Form to add Note -->
            <br><button type="submit" class="btn">ADD</button>
        </form>
    </div>
    <!-- END POPUP (ADD)-->

    <!-- POPUP (VIEW/EDIT)-->
    <!-- VIEW/EDIT USER NOTE FORM -->
    <div id="editpopup" class="popup">
        <form id="formEditUserNote" class="form-container">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="note_id" id="note-id">

            <!-- <button type="button" id="close" onclick="closeUserNoteForm()">X</button> -->

            <p class="addsubj-title">
                EDIT TO-DO
            </p>
            <!-- Form to add Note -->
            <label>Note/Task Title</label>
            <input type="text" class="form-control" name="note_title" id="note-title" required>
            <label>Description</label>
            <textarea class="form-control" name="description" style="height: 100px" id="description"></textarea>
            <div>
                <label>Due date</label>
            </div>
            <div>
                <input type="date" class="form-control" name="due_date" id="due-date">
            </div>
            <div>
                <label>Due Time</label>
            </div>
            <div>
                <input type="time" class="form-control" name="due_time" id="due-time">
            </div>
            <div>
                <span class="form-text">Due date and/or time are optional!</span>
            </div>
            <!-- END Form to add Note -->
            <br><button type="submit" class="btn">EDIT</button>
        </form>
    </div>


    <!-- DISPLAY TO-DOs -->

    <div class="listcase">
        <?php $user_note_info = GetUserNote($_SESSION['user_id']);

        while ($rows = $user_note_info->fetch_assoc()) {    ?>
            <div class="listcard">
                <i class="fa-solid fa-box-archive" onclick="location.href='#'"></i>
                <div class="notetitle">
                    <p><?php echo $rows['note_title']; ?></p>
                </div>
                <p>Post Date: <span><?php echo $rows['post_date']; ?></span></p>
                <p style="color:#D53F3A">Due Date: <span><?php echo $rows['due_date']; ?></span></p></br>
                <div class="notedetails">
                    <p><?php
                        $description = $rows['description'];
                        // Split the text into an array of words
                        $words = explode(' ', $description);
                        // Limit the array to the first 20 words
                        $limitedWords = array_slice($words, 0, 20);
                        // Join the words back into a string and echo the result
                        echo implode(' ', $limitedWords) . "...";
                        ?>
                    </p>
                </div>
                </br>
                <div class="subjbuttons">
                    <button type="button" class="view" onclick="openEditUserNoteForm(<?php echo $rows['note_id']; ?>)">VIEW/EDIT</button>

                    <!-- <button type="button" class="view" onclick="#">DONE</button> -->
                    <!-- <button type="button" class="view" onclick="location.href='#'">EDIT</button> -->
                </div>
            </div>
        <?php
        } ?>
    </div>

    <!-- AJAX / jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Get the form value and send to the with-class-process for joining class -->
    <script type="text/javascript">
        $("#formAddUserNote").submit(function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                type: 'POST',
                url: 'add-user-note-process.php',
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
        $("#formEditUserNote").submit(function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                type: 'POST',
                url: 'edit-user-note-process.php',
                data: form.serialize(),
                success: function(data) {
                    if (data > 0) {
                        alert("Note edited successfully!");
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

        function getUserNoteInfo(note_id) {
            var note_record;
            $.ajax({
                type: 'POST',
                url: 'edit-user-note-process.php',
                dataType: 'json',
                data: {
                    edit_note: note_id
                },
                success: function(data) {
                    note_record = data;
                    document.getElementById('note-id').value = note_id;
                    var title = document.getElementById('note-title');
                    title.value = note_record.note_title;
                    title.placeholder = note_record.note_title;

                    var description = document.getElementById('description');
                    description.value = note_record.description;
                    description.placeholder = note_record.description;

                    var due_date = document.getElementById('due-date');
                    due_date.value = note_record.due_date;
                    // due_date.placeholder = note_record.due_date;

                    var due_time = document.getElementById('due-time');
                    due_time.value = note_record.due_time;
                    // due_time.placeholder = note_record.due_time;
                },
            });
        }
    </script>
    <script type="text/javascript">
        function openAddUserNoteForm() {
            document.getElementById("addpopup").style.display = "block";
            document.getElementById('blur').style.filter = "blur(5px)";
            document.getElementById('blur').style.display = "block";
            document.getElementById('scrll').style.overflow = "hidden";
        }

        function closeUserNoteForm() {
            document.getElementById("addpopup").style.display = "none";
            document.getElementById("editpopup").style.display = "none";
            document.getElementById('blur').style.filter = "blur(0)";
            document.getElementById('blur').style.display = "none";
            document.getElementById('scrll').style.overflow = "auto";
        }

        function openEditUserNoteForm(note_id) {
            document.getElementById("editpopup").style.display = "block";
            document.getElementById('blur').style.filter = "blur(5px)";
            document.getElementById('blur').style.display = "block";
            document.getElementById('scrll').style.overflow = "hidden";
            getUserNoteInfo(note_id);
        }
    </script>
</body>

</html>