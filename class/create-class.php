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
    <title>Create Class - Class Connect List</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/sections.css">
</head>

<body>
    <?php
    // HEADER
    DisplayNavHeader();
    ?>
    <!-- CONTENT -->
    <div class="container">
        <form method="POST" action="create-class-process.php">
            <div class="website-content">
                <h1>CREATE CLASSROOM</h1>
                <p>NAME OF SECTION</p>
                <input type="text" id="class_name" name="class_name" placeholder="e.g. BSIT 4-2" required>

                <p>SCHOOL YEAR</p>
                <input type="number" id="school_year" name="school_year" min="1900" max="2099" required>

                <p>CLASS PRESIDENT</p>
                <input type="text" id="creator" value="<?php echo SelectUserName($_SESSION['user_id']); ?>" readonly />

                <br>
                <button type="submit" class="btn">CREATE CLASS</button>
            </div>
        </form>
    </div>
</body>

</html>