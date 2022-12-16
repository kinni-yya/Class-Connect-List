<?php
// Include the dbconnect.php file that has the function for the database queries
include '../dbconnect.php';
// Check if session exist
OpenSession();
$class_info = GetClassRecord($_GET['class_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/manage-class.css">

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
        <form action="manage-class-process.php" method="POST" class="form-container">
            <h1>ADD SUBJECT for <?php echo $class_info['class_name']; ?></h1>
            <input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">

            <label for="subject"><b>SUBJECT</b></label>
            <input type="text" placeholder="e.g. English" name="subject_name" required><br>

            <label for="subject"><b>COURSE CODE</b></label>
            <input type="text" placeholder="e.g. EN 1001" name="subject_details" required><br>

            <label for="subject"><b>PROFESSOR</b></label>
            <input type="text" placeholder="e.g. Juan Dela Cruz" name="professor"><br>
            <label for="subject"><b>MEETING TIME</b></label>

        </form>
    </div>
    <br>

    <form id="myForm">
        <ul class="donate-now">
            <li>
                <input type="radio" id="MON" name="button" value="MON" />
                <label for="MON">MON</label>
            </li>
            <li>
                <input type="radio" id="TUE" name="button" value="TUE" />
                <label for="TUE">TUE</label>
            </li>
            <li>
                <input type="radio" id="WED" name="button" value="WED" />
                <label for="WED">WED</label>
            </li>
            <li>
                <input type="radio" id="THU" name="button" value="THU" />
                <label for="THU">THU</label>
            </li>
            <li>
                <input type="radio" id="FRI" name="button" value="FRI" />
                <label for="FRI">FRI</label>
            </li>
            <li>
                <input type="radio" id="SAT" name="button" value="SAT" />
                <label for="SAT">SAT</label>
            </li>
            <li>
                <input type="radio" id="SUN" name="button" value="SUN" />
                <label for="SUN">SUN</label>
            </li>
        </ul>
        <br><br><br>

        <label for="from"><b>FROM</b></label>
        <input type="time" id="time1" required>

        <label for="subject"><b>TO</b></label>
        <input type="time" id="time2" required>

        <br><button type="submit" onclick="appendValue(event)">Add Meeting Time</button>

    </form>
    <div id="output"></div>
    <button>ADD SUBJECT</button>


    <script>
        function appendValue(event) {
            event.preventDefault(); // prevent form submission and page refresh
            var form = document.getElementById("myForm");
            var time1 = form.time1.value;
            var time2 = form.time2.value;
            var selectedButton;
            for (var i = 0; i < form.length; i++) {
                if (form[i].type == "radio" && form[i].name == "button" && form[i].checked) {
                    selectedButton = form[i].value;
                    break;
                }
            }
            var output = document.getElementById("output");
            var div = document.createElement("div");
            div.innerHTML = "Time 1: " + time1 + "<br>Time 2: " + time2 + "<br>Selected button: " + selectedButton;
            var deleteButton = document.createElement("button");
            deleteButton.innerHTML = "Delete";
            deleteButton.onclick = function() {
                div.parentNode.removeChild(div);
            };
            div.appendChild(deleteButton);
            output.appendChild(div);
        }
    </script>
</body>

</html>