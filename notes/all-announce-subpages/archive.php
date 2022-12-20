<?php 
// Include database connection with SQL queries function
include '../dbconnect.php';
// Check if session exist
OpenSession();

//Get the access attribute from Database, if 0 regular if 1 full
$member_info = MemberInfo($_SESSION['user_id'], $_GET['class_id']);
$result = $member_info->fetch_assoc(); 
$member_id = $result['member_id'];
$access = $result['member_type'];
// Get the class_id from URL parameter
$class_id = $_GET['class_id'];
// Select all note table records without due date
$select_archive_result = SelectArchiveNote($class_id, $member_id);
while($row = $select_archive_result->fetch_assoc()) {

?>

<!-- Box -->
<div class="note-box">
	<div class="row" onclick="DisplayNoteDetails(this)">
		<!-- Title -->
		<span class="note-title col-6 align-self-center">
            <?php //echo $row['note_title'];?>
            Note title
        </span>
		<!-- Details -->
		<span class="note-description col-4 align-self-center">
            <?php //echo substr($row['description'], 0, 50); ?>
        </span>
		<div class="col-2 align-self-center">
			<!-- Spent date -->
			<span class="note-due">
                <?php //echo $row['due_date'];?></span>
			<br>
			<!-- Date -->
			<span class="note-day">
                <?php //echo $row['post_date'];?></span>
		</div>
	</div>
	
	<div class="note-detail">
		<div class=" detail-container">
				<div class="note-detail-box">
					<span><?php echo $row['description'];?></span>	
				</div>
		</div>

		<div class="container d-flex justify-content-end">
			<button class="btn btn-outline-success" data-id="
            <?php //echo $row['archive_note_id']; ?>" onclick="RestoreTask(this)">Restore</button>
			&emsp;<button class="btn btn-outline-secondary" onclick="CloseDisplayNote(this)">Close</button>
		</div>
		

	</div>
</div>
<br>

<?php 
}
?>