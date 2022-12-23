<?php 
// Include database connection with SQL queries function
include '../dbconnect.php';
// Open database connection for the nl2br
$conn = OpenCon();

$description = '';
// Check if description is empty if not properly put the strings for SQL format
if(isset($_POST['description'])){
	//nl2br converts the line breaks
	//mysqli_real_escape_string converts the special characters
	$description = mysqli_real_escape_string($conn, nl2br($_POST['description']));
}

$subject_id = null;
if(isset($_POST['subject_id']) && !empty($_POST['subject_id'])){
	// Check if the subject_id is not zero, if not assign proper value instead of null
	if ($_POST['subject_id'] != "0") {
		$subject_id = $_POST['subject_id'];
	}
}

$due_date = null;
// Check if due date is null
if(isset($_POST['due_date']) && !empty($_POST['due_date'])){
	$due_date = $_POST['due_date'];
}

$due_time = null;
// Check if due date is null
if(isset($_POST['due_time']) && !empty($_POST['due_time']) && isset($_POST['due_date']) && !empty($_POST['due_date'])){
	$due_time = $_POST['due_time'];
}

if(isset($_POST['note_title'])){
	// Send the parameters to UpdateNote() function to update a record in the note table
	$edit_note_message = UpdateNote($_POST['note_id'], $subject_id, $due_date, $due_time, $_POST['note_title'], $description, $_POST['class_id'], $conn);
}

echo $edit_note_message;
?>