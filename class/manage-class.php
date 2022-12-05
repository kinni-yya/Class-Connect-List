<?php 
// Include the dbconnect.php file that has the function for the database queries
include '../dbconnect.php';
// Check if session exist
OpenSession();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/subject.css">
    <title>Manage Class</title>

    <script type="text/javascript">
        function openForm() {
            document.getElementById("add-subj-form").style.display = "block";
        }

        function closeForm() {
            document.getElementById("add-subj-form").style.display = "none";
        }
    </script>
</head>

<body>
    <?php
    // HEADER
    DisplayNavHeader();
    ?>
    <div class="buttons">
        <button class="button" onclick="location.href='with-class.php'">GO BACK</button>
        <button class="open-button" onclick="openForm()">ADD SUBJECT</button>
    </div>
    <!-- FETCH FROM DATABASE AND DISPLAY
        https://www.geeksforgeeks.org/how-to-fetch-data-from-localserver-database-and-display-on-html-table-using-php/ -->

    <div class="form-popup" id="add-subj-form">
        <form action="with-class-process.php" method="POST" class="form-container">
            <h1>ADD SUBJECT</h1>
            <input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">

            <label for="subject"><b>SUBJECT</b></label>
            <input type="text" placeholder="Subject Name" name="subject_name" required>

            <label for="subject"><b>SUBJECT CODE</b></label>
            <input type="text" placeholder="Subject Code" name="subject_code">

            <label for="subject"><b>PROFESSOR</b></label>
            <input type="text" placeholder="Professor" name="professor">
            <button type="submit" class="btn">ADD SUBJECT</button>
            <button type="button" class="btn cancel" onclick="closeForm()">CANCEL</button>
        </form>
    </div>
</body>

</html>