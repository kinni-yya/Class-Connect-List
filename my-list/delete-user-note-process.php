<?php 
// Include database connection with SQL queries function
include '../dbconnect.php';
// Open database connection for the nl2br
$conn = OpenCon();

if(isset($_POST['note_id'])){
	$delete_note_message = DeleteUserNote($_POST['note_id'], $conn);
}

echo $delete_note_message;
?>