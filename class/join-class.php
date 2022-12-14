<?php
include "../dbconnect.php";
// Check if session exist
OpenSession();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Class - Class Connect List</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/create.css">
</head>

<body>
    <?php DisplayNavHeader(); ?>
    <!-- CONTENT -->
    <div class="create-container">
        <p>JOIN CLASS</p>
        <div class="create-form">
            <form action="with-class-process.php" method="POST">
                <div class="cp">
                    <span>
                        <p1>Enter the classroom code of the desired section.<br></p1>
                        <p1>Doing so will send a join request towards the section's class officers.<br></p1>
                </div>
                <div>
                    <input type="text" placeholder="Enter Class Code" name="class_code" class="form-control" required>
                </div>
                <button type="submit" class="btn">JOIN CLASS</button>
        </div>
        </form>
    </div>
</body>

</html>