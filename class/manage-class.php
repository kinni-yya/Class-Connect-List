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

</head>

<body id="scrll">
    <?php
    // HEADER
    DisplayNavHeader();
    ?>
    <p class="subj">SUBJECTS</p>
    <div class="buttons">
        <button class="button" onclick="location.href='with-class.php'">GO BACK</button>
        <button class="button" onclick="openAddClassForm()">ADD SUBJECT</button>
    </div>

    <!-- BLUR -->
    <div id="blur" onclick="closeAddClassForm()"></div>
    <!-- POPUP -->
    <div id="popup">
        <form action="manage-class-process.php" method="POST" class="form-container" id="addSubjectForm">

                <p class="addsubj-title">
                    ADD SUBJECT for
                    <?php
                    $class_name = $class_info['class_name'];
                    echo "<span class='class_name'>$class_name</span>";
                    ?>
                </p>
            <div id="add-subj-form">   
                <input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">

                <label for="subject"><b>SUBJECT</b></label>
                <input type="text" placeholder="e.g. English" name="subject_name" required><br><br>

                <label for="subject"><b>Subject Details</b></label>
                <input type="text" placeholder="e.g. EN 1001" name="subject_details"><br><br>

                <label for="subject"><b>PROFESSOR</b></label>
                <input type="text" placeholder="e.g. Juan Dela Cruz" name="professor"><br><br>
            </div>
            <label class="MT"><b>MEETING TIME</b></label>
            <button onclick="addSubjectDate(event)">Add Meeting Time</button>

            <div id="scheduled_time">
                <label for="day"><b>DAY</b></label>
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

                
                <br>
            </div>
            <div id="output"></div>
            <div class="submit">
                <button type="submit">Add Subject</button>
            </div>
        </form>
    </div>
    
    <!-- Table of all the subjects for the class -->
    <br>
    <div class="classcase">
        <?php 
        $result = SelectClassSubjectList($_GET['class_id']);
        while($row = $result->fetch_assoc()){       ?>
            <div class="classcard">
                <div class="subjname">
                    <div>
                        <?php echo $row['subject_name'];?>
                    </div>
                    <div class="details">
                        <?php echo $row['subject_details'];?>
                    </div>
                </div>
                <div class="subjprof">
                    <p><?php echo $row['professor'];?></p>
                </div>
                <div class="subjsched1">
                    <p class="subjday">Day</p>
                    <p>echo sched time dapat</p>
                </div>
                <div class="subjsched2">
                    <p class="subjday">Day</p> 
                    <p>echo sched dapat</p>
                </div>
                <div class="subjbuttons">
                    <button>Edit</button> 
                    <button data-subject-id="<?php echo $row['subject_id']; ?>" onclick="RemoveSubject(this)">Delete</button>
                </div>
            </div>
        <?php } ?>
    </div>

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


<!-- Popup JS -->
<script type="text/javascript">
    function openAddClassForm() {
        document.getElementById("popup").style.display = "block";
        document.getElementById("blur").style.display = "block";
        document.getElementById("blur").style.filter = "blur(10px)";
        document.getElementById("scrll").style.overflow = "hidden";
    }

    function closeAddClassForm() {
        document.getElementById("popup").style.display = "none";
        document.getElementById('blur').style.filter = "blur(0)";
        document.getElementById('blur').style.display = "none";
        document.getElementById('scrll').style.overflow = "auto";
    }
</script>

</body>
</html>