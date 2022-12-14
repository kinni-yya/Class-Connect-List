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
    <title>Welcome - Class Connect List</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sections.css">
</head>

<body>
    <?php 
    DisplayNavHeader();?>

    <div class="para">
        <p class="p1">You have not joined any classes, yet.</p>
        <p class="p2">Are you a class officer? Click here to create a classroom!</p>
        <div class="btns">
            <button><a class="create" href="create-class.php">CREATE CLASS</a></button>
            <button><a class="join"href="join-class.php">JOIN CLASS</a></button>
        </div>
    </div>

</body>

</html>