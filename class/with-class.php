<?php
include "../dbconnect.php";
OpenSession();

// Check if the user is in a class
if(checkClassJoin($_SESSION['user_id']) == FALSE){
    header("location: no-class.php");
}
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

<body >
    <div id="blur">
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

        <div class="cardwclass">
            <div class="buttons">
                <button type="button" class="view" onclick="location.href='create-class.php'">CREATE NEW CLASS</button>
                <button type="button" class="view" onclick="openAddClassForm()">JOIN CLASS</button>
            </div>
        </div>
    </div>

    <!-- SHOW CLASSES OF THE USER -->
    <div id="blur2">
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
                        <input type="hidden" name="class_id" value="<?php echo $rows['class_id']; ?>">
                    </form>
                        </br>
                        <div class="buttonswclass">
                            <button type="button" class="view" onclick="location.href='../notes/note.php?class_id=<?php echo $rows['class_id']; ?>&tab=due'">VIEW CLASS</button>

                            <?php 
                            // Check if the creator id of the class is the user logged in
                            $manage_class_id = checkManageClass($rows['class_id'], $_SESSION['user_id']);
                            if($manage_class_id == TRUE) {
                            echo "<button type=\"button\" class=\"view\" onclick=\"location.href='manage-class.php?class_id=".$rows['class_id']."'\">MANAGE CLASS</button></br></br>";
                            }?>
                        </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- POPUP -->
    <div class="center" id="center">
        <div class="form-popup" id="add-class-form">
            <form action="with-class-process.php" method="POST" class="form-container">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <button type="button" id="close" onclick="closeAddClassForm()">X</button>

                <h1>JOIN CLASSROOM</h1>
                <p class="details">Enter the classroom code of the desired class.<br></p>
                <p class="details">Doing so will send a join request towards the class officers.<br></p>
                <strong><em><br>Proceeding means that you are currently studying on multiple college degrees or taking subjects from different classes.<br></em></strong>

                <input type="text" placeholder="Enter Class Code" name="class_code" class="form-control" required>

                <button type="submit" class="btn">JOIN CLASS</button>
            </form>
        </div>
    </div>

    <script type="text/javascript">
            function openAddClassForm() {
                document.getElementById("add-class-form").style.display = "block";
                document.getElementById('blur').style.filter = "blur(5px)";
                document.getElementById('blur2').style.filter = "blur(5px)";
                document.getElementById('center').style.position = "absolute";
            }

            function closeAddClassForm() {
                document.getElementById("add-class-form").style.display = "none";
                document.getElementById('blur').style.filter = "blur(0)";
                document.getElementById('blur2').style.filter = "blur(0)";
            }
    </script>


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