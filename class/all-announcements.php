<?php
include "../dbconnect.php";
// Check if session exist
OpenSession();

// Check if the user is in a class
if (checkClassJoin($_SESSION['user_id']) == FALSE) {
    header("location: ../class/no-class.php");
}

if(!isset($_GET['tab']) && empty($_SESSION['tab'])){
	// Tab parameter is empty so the tab can't figure out which information to display
	// Redirect page
	$_GET['tab'] = "due";
	header("Location: all-announcements.php?tab=".$_GET['tab']);
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
</head>
<body>
    <?php DisplayNavHeader(); ?>

    	<div class="container">
    		<h1>All Class Notes</h1>
		<div class="row">
			<ul class="nav nav-tabs col-10">
				<li class="nav-item">
			    <a class="nav-link text-success" id="due-navlink" href="#" onclick="window.location.href='all-announcements.php?tab=due';">Dues </a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link text-success" id="announcement-navlink" href="#" onclick="window.location.href='all-announcements.php?tab=announcement';">Announcement</a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link text-success" id="archive-navlink" href="#" onclick="window.location.href='all-announcements.php?tab=archive';">Archive</a>
			  	</li>
			</ul>
		</div>
	</div>

	<!-- AJAX / jQuery CDN -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
<!-- Check the URL parameter for the tab then load according to it -->
<script type="text/javascript">
	// Get the url tab parameter
	var tab_selected = "<?php echo $_GET['tab'];?>";
	// Check the value
	if (tab_selected == "announcement") {
		// Load the php page to the note-section class
		$("#note-section").load("all-announcement.php");
		// Set the tab navlink as active
		$("#announcement-navlink").addClass("active");
	}
	if (tab_selected == "due") {
		$("#note-section").load("all-due.php");
		$("#due-navlink").addClass("active");
	}
	if (tab_selected == "archive") {
		$("#note-section").load("all-archive.php");
		$("#archive-navlink").addClass("active");
	}
</script>

</body>
</html>