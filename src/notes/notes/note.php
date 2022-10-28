<?php 
// Include the dbconnect.php file that has the function for the database queries
include '../dbconnect.php';
// Start Session - Call the start session function
OpenSession();
// Check if user_id session exist, if not the user is not logged in
if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id'])){
	// If not logged in go back to login page
	// ***TEMPORARY sets the user_id so we can proceed with the page
	$_SESSION['user_id'] = 1;
}

// Check if the page has the class_id parameter and tab parameter for the nav bar
if(!isset($_GET['class_id']) && empty($_SESSION['class_id'])){
	// class_id parameter is empty or doesn't exist
	// Throw 404 error
	// ***TEMPORARY sets the class_id so we can proceed with the page
	$_GET['class_id'] = 1;

	// Check if the page has the tab parameter that sets the information to display
	if(!isset($_GET['tab']) && empty($_SESSION['tab'])){
		// Tab parameter is empty so the tab can't figure out which information to display
		// Redirect page
		$_GET['tab'] = "due";
	}

	header("Location: note.php?class_id=".$_GET['class_id']."&tab=".$_GET['tab']);
}

//Get the access attribute from Database, if 0 regular if 1 full
$access = MemberType($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Class Connect: List</title>

	<!-- note_style CSS -->
	<link rel="stylesheet" type="text/css" href="../css/notes_style.css">
	<link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet" />
	<!-- Bootstrap CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>



	<!-- Row for the Navbar -->
	<div class="container">
		<h1>BSIT 4-2</h1>
	<div class="row">
		<ul class="nav nav-tabs col-10">
		<li class="nav-item">
		    <a class="nav-link text-success" id="due-navlink" href="#" onclick="window.location.href='note.php?class_id=<?php echo $_GET['class_id']; ?>&tab=due';">Dues</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link text-success" id="announcement-navlink" href="#" onclick="window.location.href='note.php?class_id=<?php echo $_GET['class_id']; ?>&tab=announcement';">Announcement</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link text-success" id="archive-navlink" href="#" onclick="window.location.href='note.php?class_id=<?php echo $_GET['class_id']; ?>&tab=archive';">Archive</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link text-success" id="calendar-navlink" href="#" onclick="window.location.href='note.php?class_id=<?php echo $_GET['class_id']; ?>&tab=calendar';">Calendar</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link text-success" id="resources-navlink" href="#" onclick="window.location.href='note.php?class_id=<?php echo $_GET['class_id']; ?>&tab=resources';">Resources</a>
		  </li>
		  <?php 
		  if($access == 1){
		  echo '<li class="nav-item">';
		  echo  '<a class="nav-link text-success" id="pending-navlink" href="#" onclick="window.location.href=\'note.php?class_id='.$_GET['class_id'].'&tab=pending\'" disabled>Pending Notes</a>';
		  echo '</li>';
		  echo '<li class="nav-item">';
		  echo   '<a class="nav-link text-success" id="member-navlink" href="#" onclick="window.location.href=\'note.php?class_id='.$_GET['class_id'].'&tab=member\'" >Member Settings</a>';
		  echo '</li>';
		  }
		  else if($access == 0){
		  echo '<li class="nav-item">';
		  echo  '<a class="nav-link text-success" id="approval-navlink" href="#" onclick="window.location.href=\'note.php?class_id='.$_GET['class_id'].'&tab=approval\'" disabled>Approval Notes</a>';
		  echo '</li>';
		  }
		  ?>
		</ul>

		<?php 
		if($access == 1){
		echo	'<div class="nav col-2 justify-content-end">';
		echo	'<button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#AddNoteModal">Add Note</button>';
		echo	'</div>';
		}
		else{
		echo	'<div class="nav col-2 justify-content-end">';
		echo	'<button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#SuggestNoteModal">Suggest Note</button>';
		echo	'</div>';
		}
		?>
	</div>
	</div>
	<!-- END Row for the Navbar -->

	<!-- Add Note Modal -->
	<div class="modal fade" id="AddNoteModal" tabindex="-1" aria-labelledby="AddNoteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	   		<div class="modal-content">
	   		<form id="formAddNote">
	      		<div class="modal-header">
	        		<h1 class="modal-title fs-5" id="AddNoteModalLabel">Add Note</h1>
	        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      		</div>
	      		<div class="modal-body">
	      			<?php echo NULL; ?>
	      		<!-- Form to add Note -->
	        		<div class="form-group">
					    <label>Note/Task Title</label>
					    <input type="text" class="form-control" name="note_title" placeholder="Title" required>
					</div>

					<div class="form-group">
					    <label>Description</label>
					    <textarea class="form-control" name="description" style="height: 300px" placeholder="Note Description (optional)"></textarea>
					</div>

					<div class="form-group">
					    <label>Due Date</label>
					    <input type="date" class="form-control" name="due_date">
					</div>

					<div class="form-group">
						<input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">
					</div>
				<!-- END Form to add Note -->
	      		</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        		<button type="submit" class="btn btn-success">Submit</button>
	      		</div>
	      	</form>	
	    	</div>
	  	</div>
	</div>

	<div class="modal fade" id="SuggestNoteModal" tabindex="-1" aria-labelledby="SuggestNoteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	   		<div class="modal-content">
	   		<form>
	      		<div class="modal-header">
	        		<h1 class="modal-title fs-5" id="SuggestNoteModalLabel">Suggest Note</h1>
	        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      		</div>
	      		<div class="modal-body">
	        	<!-- Form to add Note -->
	        		<div class="form-group">
					    <label>Note/Task Title</label>
					    <input type="text" class="form-control" name="note_title" placeholder="Title" required>
					</div>

					<div class="form-group">
					    <label>Description</label>
					    <textarea class="form-control" name="description" style="height: 300px" placeholder="Note Description (optional)"></textarea>
					</div>

					<div class="form-group">
					    <label>Due Date</label>
					    <input type="date" class="form-control" name="due_date">
					</div>

					<div class="form-group">
						<input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">
					</div>
				<!-- END Form to add Note -->
	      		</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	        		<button type="submit" class="btn btn-success">Submit</button>
	      		</div>
	      	</form>
	    	</div>
	  	</div>
	</div>
	<!-- END Add Note Modal -->

	<!-- Section for loading information -->
	<section class="container" id="note-section">

	</section>
	<!-- END Section for loading information -->


	<!-- AJAX / jQuery CDN -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- Bootstrap JS CDN -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Submit the AddNote form -->
<script type="text/javascript">
$("#formAddNote").submit(function(e){
	e.preventDefault();
	var form = $(this);

	$.ajax({
		type: 'POST',
		url: 'add_note_process.php',
		data: form.serialize(),
		success: function(data){
			alert(data);
			location.reload();
		}
	});
});
</script>

<!-- Check the URL parameter for the tab then load according to it -->
<script type="text/javascript">
	// Get the url tab parameter
	var tab_selected = "<?php echo $_GET['tab'];?>";
	// Check the value
	if (tab_selected == "announcement") {
		// Load the php page to the note-section class
		$("#note-section").load("announcement.php?class_id=<?php echo $_GET['class_id']; ?>");
		// Set the tab navlink as active
		$("#announcement-navlink").addClass("active");
	}
	if (tab_selected == "due") {
		$("#note-section").load("due.php?class_id=<?php echo $_GET['class_id']; ?>");
		$("#due-navlink").addClass("active");
	}
	if (tab_selected == "archive") {
		$("#note-section").load("archive.php?class_id=<?php echo $_GET['class_id']; ?>");
		$("#archive-navlink").addClass("active");
	}
	if (tab_selected == "calendar") {
		$("#note-section").load("calendar.php?class_id=<?php echo $_GET['class_id']; ?>");
		$("#calendar-navlink").addClass("active");
	}
	if (tab_selected == "resources") {
		$("#note-section").load("resources.php?class_id=<?php echo $_GET['class_id']; ?>");
		$("#resources-navlink").addClass("active");
	}
	if (tab_selected == "pending") {
		$("#note-section").load("pending.php?class_id=<?php echo $_GET['class_id']; ?>");
		$("#pending-navlink").addClass("active");
	}
	if (tab_selected == "member") {
		$("#note-section").load("member.php?class_id=<?php echo $_GET['class_id']; ?>");
		$("#member-navlink").addClass("active");
	}
	if (tab_selected == "approval") {
		$("#note-section").load("approval.php?class_id=<?php echo $_GET['class_id']; ?>");
		$("#approval-navlink").addClass("active");
	}
</script>

<!-- Make the note show their full details -->
<script type="text/javascript">
	function DisplayNoteDetails(e){
		// Get the note-box div parent element
		var note_box = e.closest(".note-box");
		// Get the note detail div child element
		var note_detail = note_box.querySelector(".note-detail");
		// Check if the class show already exist
		if(!note_detail.classList.contains('show')){
			note_detail.classList.add('show');
		}
	}

	function CloseDisplayNote(e){
		// Get the note detail dive parent element
		var note_detail = e.closest(".note-detail");
		// Remove the show class
		note_detail.classList.remove('show');
	}
</script>

<!-- Submit the edit note -->
<script type="text/javascript">
	function submitEditNote(e){
		// Get the form data
		var form = new FormData(e);

		$.ajax({
			type: 'POST',
			url: 'edit_note_process.php',
			data: form,
			processData: false,
  			contentType: false,
			success: function(data){
				alert(data);
				location.reload();
			}
		});
	}
</script>

<!-- Archive and Restore tasks -->
<script type="text/javascript">
	function CompleteTask(e){
		// Get the data-id attribute value from the onclick
		var note_id = $(e).attr("data-id");

		$.ajax({
			type: 'POST',
			url: 'archive_note_process.php',
			data: {
				"note_id": note_id,
				// Set the note status to 1 to archive
				"note_status": "1"
			},
			success: function(data){
				alert(data);
				location.reload();
			}
		});
	}

	function RestoreTask(e){
		// Get the data-id attribute value from the onclick
		var note_id = $(e).attr("data-id");

		$.ajax({
			type: 'POST',
			url: 'archive_note_process.php',
			data: {
				"note_id": note_id,
				// Set the note status to 0 to restore
				"note_status": "0"
			},
			success: function(data){
				alert(data);
				location.reload();
			}
		});
	}
</script>

</body>
</html>