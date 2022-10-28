<?php 
// Include database connection with SQL queries function
include '../dbconnect.php';
// Check if session exist
OpenSession();

//Get the access attribute from Database, if 0 regular if 1 full
$access = MemberType($_SESSION['user_id']);
// Get the class_id from URL parameter
$class_id = $_GET['class_id'];
// Select all note table records without due date
$select_announcement_result = SelectAnnouncementRecord($class_id);
while($row = $select_announcement_result->fetch_assoc()) {

?>

<!-- Box -->
<div class="note-box">
	<div class="row" onclick="DisplayNoteDetails(this)">
		<!-- Title -->
		<span class="note-title col-6 align-self-center"><?php echo $row['note_title'];?></span>
		<!-- Details -->
		<span class="note-description col-4 align-self-center"><?php echo substr($row['description'], 0, 50); ?></span>
		<div class="col-2 align-self-center">
			<!-- Spent date -->
			<span class="note-due"></span>
			<br>
			<!-- Date -->
			<span class="note-day"><?php echo $row['post_date'];?></span>
		</div>
	</div>

	<div class="note-detail">
		<div class=" detail-container">
				<div class="note-detail-box">
					<span><?php echo $row['description'];?></span>	
				</div>
		</div>

		<div class="container d-flex justify-content-end">
			<?php 
			if($access == 0){
				echo "<button class=\"btn btn-outline-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#SuggestEditModal".$row['note_id']."\">Suggest Correction</button>";
			}
			else if($access == 1){
				echo "<button class=\"btn btn-outline-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#EditModal".$row['note_id']."\">Edit</button>";
			}
			 ?>
			&emsp;<button class="btn btn-outline-success" data-id="<?php echo $row['note_id']; ?>" onclick="CompleteTask(this)">Complete</button>
			&emsp;<button class="btn btn-outline-info">Add to My List</button>
			&emsp;<button class="btn btn-outline-secondary" onclick="CloseDisplayNote(this)">Close</button>
		</div>
		

	</div>
</div>
<br>



<!-- Edit Note Modal -->
<div class="modal fade" id="EditModal<?php echo $row['note_id']; ?>" tabindex="-1" aria-labelledby="EditNoteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
   		<div class="modal-content">
   		<form id="formEditNote" onsubmit="submitEditNote(this);event.preventDefault()">
      		<div class="modal-header">
        		<h1 class="modal-title fs-5" id="EditNoteModalLabel">Edit Note</h1>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
      			<?php echo NULL; ?>
      		<!-- Form to edit Note -->
        		<div class="form-group">
				    <label>Note/Task Title</label>
				    <input type="text" class="form-control" name="note_title" value="<?php echo $row['note_title'];?>" required>
				</div>

				<div class="form-group">
				    <label>Description</label>
				    <textarea class="form-control" name="description" style="height: 300px"><?php echo str_replace("<br />","",$row['description']);?></textarea>
				</div>

				<div class="form-group">
				    <label>Due Date</label>
				    <input type="date" class="form-control" name="due_date">
				</div>

				<div class="form-group">
					<input type="hidden" name="note_id" value="<?php echo $row['note_id'];?>">
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


<div class="modal fade" id="SuggestEditModal<?php echo $row['note_id']; ?>" tabindex="-1" aria-labelledby="SuggestEditModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
   		<div class="modal-content">
   		<form>
      		<div class="modal-header">
        		<h1 class="modal-title fs-5" id="SuggestEditModalLabel">Suggest Note</h1>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
        	<!-- Form to edit Note -->
        		<div class="form-group">
				    <label>Note/Task Title</label>
				    <input type="text" class="form-control" name="note_title" value="" required>
				</div>

				<div class="form-group">
				    <label>Description</label>
				    <textarea class="form-control" name="description" style="height: 300px" value=""></textarea>
				</div>

				<div class="form-group">
				    <label>Due Date</label>
				    <input type="date" class="form-control" name="due_date" value="">
				</div>

				<div class="form-group">
					<input type="hidden" name="note_id" value="">
				</div>
			<!-- END Form to edit Note -->
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        		<button type="submit" class="btn btn-success">Submit</button>
      		</div>
      	</form>
    	</div>
  	</div>
</div>
<!-- END Edit Note Modal -->

<?php 
}
?>