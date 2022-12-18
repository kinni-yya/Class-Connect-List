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
    </div>

    <form action="manage-class-process.php" method="POST" class="form-container" id="addSubjectForm">
        <div class="form-popup" id="add-subj-form">
            <h1>ADD SUBJECT for
                <?php
                $class_name = $class_info['class_name'];
                echo "<span class='class_name'>$class_name</span>";
                ?></h1>
            <input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">

            <label for="subject"><b>SUBJECT</b></label>
            <input type="text" placeholder="e.g. English" name="subject_name" required><br>

            <label for="subject"><b>Subject Details</b></label>
            <input type="text" placeholder="e.g. EN 1001" name="subject_details"><br>

            <label for="subject"><b>PROFESSOR</b></label>
            <input type="text" placeholder="e.g. Juan Dela Cruz" name="professor"><br>
            <label for="subject"><b>MEETING TIME</b></label>
        </div>

        <button onclick="addSubjectDate(event)">Add Meeting Time</button>
        <button type="submit">Add Subject</button>

        <div id="scheduled_time">
            <label for="day">DAY</label>
            <select name="day[]">
                <option value="1">MON</option>
                <option value="2">TUE</option>
                <option value="3">WED</option>
                <option value="4">THU</option>
                <option value="5">FRI</option>
                <option value="6">SAT</option>
                <option value="7">SUN</option>
            </select>

            <label for="from"><b>FROM</b></label>
            <input type="time" id="time1" name="from_time[]" required>

            <label for="to"><b>TO</b></label>
            <input type="time" id="time2" name="to_time[]" required>

            <button onclick="removeSubjectDate(this)">Remove</button>
            <br>
        </div>

        <div id="output"></div>
    </form>
    
    <!-- Table of all the subjects for the class -->
    <br>
    <h3>Class Subjects</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Subject ID</th>
                <th scope="col">Subject Name</th>
                <th scope="col">Professor</th>
                <th scope="col">Details</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $result = SelectClassSubjectList($_GET['class_id']);
            while($row = $result->fetch_assoc()){
        ?>
            <tr>
                <th scope="row"><?php echo $row['subject_id'];?></th>
                <td><?php echo $row['subject_name'];?></td>
                <td><?php echo $row['professor'];?></td>
                <td><?php echo $row['subject_details'];?></td>
                <td><button>Edit</button> 
                <button data-subject-id="<?php echo $row['subject_id']; ?>" onclick="RemoveSubject(this)">Delete</button></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- AJAX / jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Script for cloning or duplicating the input for the subject schedule -->
<script type="text/javascript">
    function addSubjectDate(e){
        $('#scheduled_time').clone().prependTo('#output');
    }

    function removeSubjectDate(e){
        $(e).parent().remove();
    }
</script>

<!-- Delete the subject -->
<script type="text/javascript">
function RemoveSubject(e) {
    var subject_id = $(e).attr("data-subject-id");

    $.ajax({
        type: 'POST',
        url: 'manage-class-process.php',
        data: {
            "subject_id": subject_id,
            "process_type": "delete"
        },
        success: function(data){
            alert(data);
            location.reload();
        }
    });
}
</script>

</body>
</html>