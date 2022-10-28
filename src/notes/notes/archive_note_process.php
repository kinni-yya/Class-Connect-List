<?php 
// Include database connection with SQL queries function
include '../dbconnect.php';
// Open connection
$conn = OpenCon();

if(isset($_POST['note_id'])){
	$archive_note_message = UpdateNoteStatus($_POST['note_id'], $_POST['note_status'], $conn);
}

echo $archive_note_message;
?>