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

    <div class="container">
        <div class="website-content">
            <h1>You have not joined any classes, yet.</h1>
            <p>Are you a class officer? Click below to create a classroom!</p>
            <a href="create-class.php" class="btn">CREATE CLASS</a>
            <a href="join-class.php" class="btn">JOIN CLASS</a>
        </div>
    </div>

</body>

</html>