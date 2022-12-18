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
$select_pending_result = SelectPendingNote($class_id);
while($row = $select_pending_result->fetch_assoc()) {

?>

<!-- Box -->
<div class="note-box">
	<div class="row" onclick="DisplayNoteDetails(this)">
		<!-- Title -->
		<span class="note-title col-6 align-self-center"><?php echo $row['note_title'];?></span>
		<!-- Details -->
		<span class="note-description col-4 align-self-center">
			<?php 
				if(strlen($row['description']) > 50){
					echo "\"".substr($row['description'], 0, 50)."\"...";
				}
				else{
					echo $row['description'];
				}
			?>
		</span>
		<div class="col-2 align-self-center">
			<!-- Spent date -->
			<span class="note-due"><?php 
				if($row['status'] == 0){ echo "Pending"; }
				else if($row['status'] == 2){ echo "<span class=\"note-due\" style=\"color: green;\">Accepted</span>"; }
				else if($row['status'] == 1){ echo "<span class=\"note-due\" style=\"color: red;\">Rejected</span>"; }
			 ?></span>
			<br>
			<!-- Date -->
			<span class="note-day"><?php echo $row['pending_date'];?></span>
		</div>
	</div>

	<div class="note-detail">
		<div class="detail-container">
				<div class="note-detail-box">
					<span><?php echo $row['description'];?></span>	
				</div>
		</div>

		<div class="container d-flex justify-content-around">
			<?php 
				if($row['subject_id'] != NULL){
					echo "<span>Subject: ".SelectSubjectName($row['subject_id'])."</span>";
				}
				else{
					echo "<span>Subject: General</span>";
				}

				if($row['due_date'] != NULL){
					echo "<span>Due Date: ".$row['due_date']."</span>";
				}
				else{
					echo "<span>Due Date: Not Set</span>";
				}

				if($row['due_time'] != NULL){
					echo "<span>Due Time: ".$row['due_time']."</span>";
				}
				else{
					echo "<span>Due Time: Not Set</span>";
				}
			?>
		</div>

		<?php 
		// Check if the note has a previous record or is being edited then display the before note
		if($row['note_id'] != NULL){
			echo '<hr>';
		?>
		<h5>Before</h5>
		<?php $note_row = SelectANoteRecord($row['note_id']); ?>

		<span class="note-title col-6 align-self-center"><?php echo $note_row['note_title'];?></span>
		<div class="detail-container">
				<div class="note-detail-box">
					<span><?php echo $note_row['description'];?></span>	
				</div>
		</div>

		<div class="container d-flex justify-content-around">
			<?php 
				if($note_row['subject_id'] != NULL){
					echo "<span>Subject: ".SelectSubjectName($row['subject_id'])."</span>";
				}
				else{
					echo "<span>Subject: General</span>";
				}

				if($note_row['due_date'] != NULL){
					echo "<span>Due Date: ".$note_row['due_date']."</span>";
				}
				else{
					echo "<span>Due Date: Not Set</span>";
				}

				if($note_row['due_time'] != NULL){
					echo "<span>Due Time: ".$note_row['due_time']."</span>";
				}
				else{
					echo "<span>Due Time: Not Set</span>";
				}
			?>
		</div>
		<?php 
		}
		?>


		<div class="container d-flex justify-content-end">
			<button class="btn btn-outline-danger" data-id="<?php echo $row['pending_note_id']; ?>" data-status="1" data-note-id="<?php echo $row['note_id']; ?>" onclick="proccessPendingNote(this)">Reject</button>
			&emsp;<button class="btn btn-outline-success" data-id="<?php echo $row['pending_note_id']; ?>" data-status="2" data-note-id="<?php echo $row['note_id']; ?>" onclick="proccessPendingNote(this)">Approve</button>
			&emsp;<button class="btn btn-outline-secondary" onclick="CloseDisplayNote(this)">Close</button>
		</div>
	</div>

</div>
<br>



<?php 
}
?>