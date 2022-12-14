<?php
include "../dbconnect.php";
OpenSession();
// $sesh_id = $_SESSION['user_id'];
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
</head>

<body>
    <?php DisplayNavHeader(); ?>

    <div class="container">
        <div class="website-content">
            <?php
            // GETs the parameter from the URL php?parameter=[value]&anohterParamaterifthereis=[value]
            // echo "<h1>" . SelectClassName($_GET['class_id']) . "</h1>";
            echo "<p>Welcome " . SelectUserName($_SESSION['user_id']) . "!<p>";
            ?>
        </div>
    </div>

    <div class="card">
        <div class="buttons">
            <button type="button" class="view" onclick="openAddClassForm()">Add Class</button>
            <button type="button" class="view" onclick="openAddSubjForm()">Add Subject</button>
        </div>
    </div>

    <div class="form-popup" id="add-class-form">
        <form action="with-class-process.php" method="POST" class="form-container">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <button type="button" id="close" onclick="closeAddClassForm()">X</button>

            <h1>JOIN CLASSROOM</h1>
            <p1>Enter the classroom code of the desired section.<br></p1>
            <p1>Doing so will send a join request towards the section's class officers.<br></p1>
            <strong><em><br>Proceeding means that you are currently studying on multiple college degrees.<br></em></strong>

            <input type="text" placeholder="Enter Class Code" name="class_code" required>

            <br><button type="submit">CONTINUE</button>
        </form>
    </div>

    <div class="form-popup" id="add-subj-form">
        <form action="with-class-process.php" method="POST" class="form-container">
            <button type="button" id="close" onclick="closeAddSubjForm()">X</button>

            <h1>ADD SUBJECT</h1>
            <p1>Enter the subject code of the desired subject.<br></p1>
            <p1>Doing so will send a join request towards the section’s class officers.<br></p1>
            <strong><em><br>Proceeding means that you are taking extra subjects that your current section does not partake (e.g. Irregular Student).<br></em></strong>

            <input type="text" placeholder="Enter Subject Code" name="subj_code" required>

            <br><button type="submit">CONTINUE</button>
        </form>
    </div>

    <script type="text/javascript">
        function openAddClassForm() {
            document.getElementById("add-class-form").style.display = "block";
        }

        function closeAddClassForm() {
            document.getElementById("add-class-form").style.display = "none";
        }

        function openAddSubjForm() {
            document.getElementById("add-subj-form").style.display = "block";
        }

        function closeAddSubjForm() {
            document.getElementById("add-subj-form").style.display = "none";
        }
    </script>

    <!-- SHOW CLASSES OF THE USER -->
    <div class="case">
        <?php
        $class_info = GetClass($_SESSION['user_id']);
        /**
         * 1. WHAT IS "$class_info->fetch_assoc())"
         *       = convert class_info (aka results GetClass()) into a dictionary/array
         * 2. LOOP TILL END OF DATA (kailangan si $rows kasi doon naka store yung naconvert)
         */
        while ($rows = $class_info->fetch_assoc()) {    ?>
            <div class="card">
                <div class="cname">
                    <p><?php echo $rows['class_name']; ?></p>
                </div>
                <p>Class Code: <span><?php echo $rows['class_code']; ?></span></p></br>
                <p>SY: <?php echo $rows['school_year']; ?></p>
                <form method="GET" action="note.php">
                    <input type="hidden" name="class_id" value="<?php echo GetClassId($rows['class_code']); ?>">
                    </br>
                    <div class="buttons">
                        <button type="button" class="view" onclick="location.href='../notes/note.php?class_id=<?php echo GetClassId($rows['class_code']); ?>&tab=due'">VIEW CLASS</button>
                        <button type="button" class="view" onclick="location.href='manage-class.php?class_id=<?php echo GetClassId($rows['class_code']); ?>'">MANAGE CLASS</button></br></br>
                    </div>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- 
    VIEW CLASSES
    1. CLICK VIEW BUTTON 
    2. GO TO NOTE.PHP (noting class_id)

    MANAGE CLASSES
    OFFICER
	    - addClassForm and remove subj, 
	    - edit the class name, 
	    - change member access, 
	    - remove member
    MEMBER 
        - access class and see corresponding subjects
        - archive classes
-->

</html>