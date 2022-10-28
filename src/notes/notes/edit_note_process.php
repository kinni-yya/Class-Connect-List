<?php 
// Include database connection with SQL queries function
include '../dbconnect.php';
// Open connection
$conn = OpenCon();

$description = '';
// Check if description is empty if not properly put the strings for SQL format
if(isset($_POST['description'])){
	//nl2br converts the line breaks
	//mysqli_real_escape_string converts the special characters
	$description = mysqli_real_escape_string($conn, nl2br($_POST['description']));
}

$due_date = null;
// Check if due date is null
if(isset($_POST['due_date']) || !empty($_POST['due_date'])){
	$due_date = $_POST['due_date'];
}

if(isset($_POST['note_title'])){
	// Send the parameters to UpdateNote() function to update a record in the note table
	$edit_note_message = UpdateNote($_POST['note_id'], $_POST['note_title'], $description, $due_date, $conn);
}

echo $edit_note_message;
?>