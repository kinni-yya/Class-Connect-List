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
    <!-- Bootstrap CDN -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- <link rel="stylesheet" href="../css/sections.css"> -->
    <link rel="stylesheet" href="../css/create.css">
</head>

<body>
    <?php
    // HEADER
    DisplayNavHeader();
    ?>
    <!-- CONTENT -->
    <div class="create-container">
        <!-- <div class="create-title"> -->
            <p>CREATE CLASSROOM</p>
        <!-- </div> -->
        <div class="create-form">
            <form method="POST" action="create-class-process.php">
                <div class="cp">
                    <label><span>CLASS PRESIDENT</span></label>
                    <input type="text" id="creator" value="<?php echo SelectUserName($_SESSION['user_id']); ?>" class="class-pres" readonly/>
                </div>
                <div>
                    <label>NAME OF SECTION</label>
                    <input type="text" id="class_name" name="class_name" placeholder="e.g. BSIT 4-2" class="form-control" required>
                </div>
                <div>
                    <label>SCHOOL YEAR</label>
                    <input type="number" id="school_year" name="school_year" min="1900" max="2099" placeholder="2022" required>
                </div>
                <button type="submit" class="btn">CREATE CLASS</button>
        </div>
        </form>
    </div>
</body>

</html>