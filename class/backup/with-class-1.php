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
            echo "<h1>" . SelectClassName($_GET['class_id']) . "</h1>";
            echo "<p>Welcome " . SelectUserName($_SESSION['user_id']) . "!<p>";
            ?>
        </div>
    </div>

    <?php getSubj();
    $keys = array_keys($_SESSION["subject"]);

    // # of subjects
    // for ($i = 0; $i < count($_SESSION["subject"]); $i++) {

    // values of subject[]
    // foreach ($_SESSION["subject"][$keys[$i]] as $key => $value) {
    foreach ($_SESSION["subject"] as $value) {
        echo '<div class="frame-4">';
        echo '<div class="frame-40">';
        if (isset($value["subject_name"])) {
            echo '<p class="buhay-at-mga-sinulat-ni-rizal valign-text-middle urbanist-bold-gossamer-24px">' . $value["subject_name"] . '</p><br>';
        }
        if (isset($value["subject_code"])) {
            echo '<div class="address valign-text-middle urbanist-bold-gossamer-20px">' . $value["subject_code"] . '</div>';
        }
        echo '</div>';
        if (isset($value["professor"])) {
            echo '<div class="sevilla-maria-angelica valign-text-middle urbanist-semi-bold-black-24px">' . $value["professor"] . '</div>';
        }

        // DIFFERENT METHODS WILL APPLY FOR SCHEDULE
        echo '<div class="group-14-3">';
        if (isset($value["subject_details"])){
            echo '<div class="wed valign-text-middle urbanist-semi-bold-black-24px">' . $value["subject_details"] . '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo "<br>";
    }
    // }
    ?>
    
    <!-- SAMPLE SUBJECT -->
    <!-- <div class="frame-4">
        <div class="frame-40">
            <p class="buhay-at-mga-sinulat-ni-rizal valign-text-middle urbanist-bold-gossamer-24px">
                BUHAY AT MGA SINULAT NI RIZAL
            </p>
            <div class="address valign-text-middle urbanist-bold-gossamer-20px">GEED 10013</div>
        </div>
        <div class="sevilla-maria-angelica valign-text-middle urbanist-semi-bold-black-24px">SEVILLA, MARIA ANGELICA</div>
        
        <div class="group-14-3">
            <div class="wed valign-text-middle urbanist-semi-bold-black-24px">WED</div>
            <div class="x13pm-300pm valign-text-middle urbanist-semi-bold-black-24px">1:30PM - 3:00PM</div>
        </div>
        <div class="group-15-1">
            <div class="sat-1 valign-text-middle urbanist-semi-bold-black-24px">SAT</div>
            <div class="x13pm-300pm valign-text-middle urbanist-semi-bold-black-24px">1:30PM - 3:00PM</div>
        </div>
    </div> -->

</body>

</html>