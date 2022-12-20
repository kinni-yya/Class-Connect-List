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
		<h1>SAMPLE</h1>
		<div class="row">
			<ul class="nav nav-tabs col-10">
				<li class="nav-item">
					<a class="nav-link text-success" id="due-navlink" href="#" onclick="">Dues</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-success" id="announcement-navlink" href="#" onclick="">Announcement</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-success" id="announcement-navlink" href="#" onclick="">Archive</a>
				</li>
			</ul>
		</div>
	</div>

	<!-- Section for loading information -->
	<section class="container" id="note-section"></section>

	<!-- AJAX / jQuery CDN -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- Bootstrap JS CDN -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<script type="text/javascript">
		var tab_selected = "<?php echo $_GET['tab']; ?>";
		if (tab_selected == "due") {
			//$("#note-section").load("all-announce-subpages/due.php?class_id=<?php //echo $_GET['class_id']; ?>");
			$("#note-section").load("all-announce-subpages/due.php");
			$("#due-navlink").addClass("active");
		}
		if (tab_selected == "announcement") {
			// Load the php page to the note-section class
			// $("#note-section").load("all-announce-subpages/announcement.php?class_id=
			// <?php //echo $_GET['class_id']; ?>");

			$("#note-section").load("all-announce-subpages/announcement.php");
			// Set the tab navlink as active
			$("#announcement-navlink").addClass("active");
		}
		if (tab_selected == "archive") {
			// $("#note-section").load("all-announce-subpages/archive.php?class_id=
			// <?php //echo $_GET['class_id']; ?>");
			$("#note-section").load("all-announce-subpages/archive.php");
			
			$("#archive-navlink").addClass("active");
		}
	</script>

	<!-- Make the note show their full details -->
	<script type="text/javascript">
		function DisplayNoteDetails(e) {
			// Get the note-box div parent element
			var note_box = e.closest(".note-box");
			// Get the note detail div child element
			var note_detail = note_box.querySelector(".note-detail");
			// Check if the class show already exist
			if (!note_detail.classList.contains('show')) {
				note_detail.classList.add('show');
			}
		}

		function CloseDisplayNote(e) {
			// Get the note detail dive parent element
			var note_detail = e.closest(".note-detail");
			// Remove the show class
			note_detail.classList.remove('show');
		}
	</script>

	<!-- Archive and Restore tasks -->
	<script type="text/javascript">
		function CompleteTask(e) {
			// Get the data-id attribute value from the onclick
			var note_id = $(e).attr("data-id");

			$.ajax({
				type: 'POST',
				url: 'archive_note_process.php',
				data: {
					"note_id": note_id,
					"member_id": <?php echo $member_id; ?>
				},
				success: function(data) {
					alert(data);
					location.reload();
				}
			});
		}

		function RestoreTask(e) {
			// Get the data-id attribute value from the onclick
			var archive_note_id = $(e).attr("data-id");

			$.ajax({
				type: 'POST',
				url: 'archive_note_process.php',
				data: {
					"archive_note_id": archive_note_id
				},
				success: function(data) {
					alert(data);
					location.reload();
				}
			});
		}
	</script>


</body>

</html>