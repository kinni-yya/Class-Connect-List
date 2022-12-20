<?php
include "../dbconnect.php";
OpenSession();

// Check if the user is in a class
if (checkClassJoin($_SESSION['user_id']) == FALSE) {
    header("location: no-class.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Announcementst</title>
	<!-- Bootstrap CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Header CSS -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
</head>
<body>
    <?php DisplayNavHeader(); ?>

    	<div class="container">
		<!-- <h1><?php echo $class_info['class_name']; ?></h1> -->
		<div class="row">
			<ul class="nav nav-tabs col-10">
				<!-- <?php // Count how many notes are due for today
				$due_count = CountDueNoteToday($_GET['class_id'], $member_id);?> -->
			<li class="nav-item">
				<a class="nav-link text-success" id="due-navlink" href="#" onclick="">Dues <?php if($due_count > 0) echo "<span class=\"badge rounded-pill bg-danger\">".$due_count."</span>"; ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-success" id="announcement-navlink" href="#" onclick="">Announcement</a>
			</li>
            <li class="nav-item">
				<a class="nav-link text-success" id="announcement-navlink" href="#" onclick="">Archive</a>
			</li>
			<!-- <li class="nav-item">
				<a class="nav-link text-success" id="all-navlink" href="#" onclick="window.location.href='note.php?class_id=<?php echo $_GET['class_id']; ?>&tab=all';">All</a>
			</li> -->
			</ul>
		</div>
	</div>
    
</body>
</html>