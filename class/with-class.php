<?php
include "../dbconnect.php";
OpenSession();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Class Connect List</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sections.css">
    <link rel="stylesheet" href="../css/with-class.css">

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
    <?php DisplayNavHeader(); ?>

    <div class="container">
        <div class="website-content">
            <?php
            // GETs the parameter from the URL php?parameter=[value]&anohterParamaterifthereis=[value]
            echo "<h1>" . SelectClassName($_GET['class_id']) . "</h1>";
            echo "<p>Welcome " . SelectUserName($_SESSION['user_id']) . "!<p>";
            ?>
        </div>
    </div>

    <button class="open-button" onclick="openForm()">ADD SUBJECT</button>


    <!-- FETCH FROM DATABASE AND DISPLAY
        https://www.geeksforgeeks.org/how-to-fetch-data-from-localserver-database-and-display-on-html-table-using-php/ -->
    <?php

    $subject_info = GetSubject($_GET['class_id']);
    // LOOP TILL END OF DATA
    while ($rows = $result->fetch_assoc()) {

        echo '<div class="frame-4">';
            echo '<div class="frame-40">';
                if (isset($value["subject_name"])) {
                echo '<p class="buhay-at-mga-sinulat-ni-rizal valign-text-middle urbanist-bold-gossamer-24px">' . $value["subject_name"] . '</p><br>';
                }
                if (isset($value["subject_code"])) {
                echo '<div class="address valign-text-middle urbanist-bold-gossamer-20px">' . $value["subject_code"] . '</div>';
                }
                echo '</div>';
            if (isset($value["professor"])) {
            echo '<div class="sevilla-maria-angelica valign-text-middle urbanist-semi-bold-black-24px">' . $value["professor"] . '</div>';
            }

            // DIFFERENT METHODS WILL APPLY FOR SCHEDULE
            echo '<div class="group-14-3">';
                if (isset($value["subject_details"])){
                echo '<div class="wed valign-text-middle urbanist-semi-bold-black-24px">' . $value["subject_details"] . '</div>';
                }
                echo '</div>';
            echo '</div>';
        echo "<br>";
    }
    ?>
    <div class="form-popup" id="add-subj-form">
        <form action="with-class-process.php" class="form-container">
            <h1>!ADD SUBJECT</h1>
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

</html>