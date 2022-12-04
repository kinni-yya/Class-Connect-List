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

    <!-- SHOW CLASSES OF THE USER -->
    <?php

    $class_info = GetClass($_SESSION['user_id']);
    /**
     * 1. WHAT IS "$class_info->fetch_assoc())"
     *       = convert class_info (aka results GetClass()) into a dictionary/array
     * 2. LOOP TILL END OF DATA (kailangan si $rows kasi doon naka store yung naconvert)
     */


    // class table = class_id, class_name, class_code, school_year
    // member table = member_type
    while ($rows = $class_info->fetch_assoc()) {
<<<<<<< Updated upstream
    ?>
        <?php echo $rows['class_name']; ?>\
        <?php echo $rows['class_code']; ?>
        <?php echo $rows['school_year']; ?>
        <!-- INSERT BUTTONS -->
=======
        ?>
    <?php
        echo $rows['class_name']; echo "</br>";
            echo $rows['class_code']; echo " ";
            echo $rows['school_year']; echo " ";
            echo $rows['school_year']; ?> </br>
        <form method="GET" action="note.php">
            <input type="hidden" name="class_id" value="<?php echo GetClassId($rows['class_code']);?>">
            <button type="button" onclick="location.href='../notes/note.php'">View Class</button>
            <button type="button" onclick="location.href='../notes/note.php?class_id=<?php echo GetClassId($rows['class_code']);?>&tab=due'">View Class</button>
        </br>
        </br>
        <!-- </form> -->
>>>>>>> Stashed changes
    <?php
        echo '<br>';
    }
    ?>

</html>