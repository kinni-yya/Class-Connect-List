<?php
include '../dbconnect.php';
OpenSession();
// Open database connection for the nl2br
$conn = OpenCon();

$subject_details = NULL;
// Check if subject_code is empty if not properly put the strings for SQL format
if (isset($_POST['subject_details']) && !empty($_POST['subject_details'])) {
	//nl2br converts the line breaks
	//mysqli_real_escape_string converts the special characters
	$subject_details = mysqli_real_escape_string($conn, nl2br($_POST['subject_details']));
}

$professor = NULL;
if (isset($_POST['professor']) && !empty($_POST['professor'])) {
	$professor = mysqli_real_escape_string($conn, nl2br($_POST['professor']));
}

// INSERT to subject table
$subject_id = 0;
if (isset($_POST['subject_name']) && !empty($_POST['subject_name'])) {
	// Send the parameters to InsertSubject() function to insert to the subject table then return subject id
	$subject_id = InsertSubject(
		$_POST['subject_name'],
		$subject_details,
		$professor,
		$_POST['class_id'],
		$conn
	);
}

// Insert the schedule for the subject using the returned subject id
if($subject_id > 0){
	for ($i=0; $i < sizeof($_POST['day']); $i++) { 
		InsertSubjectSchedule($subject_id, $_POST['from_time'][$i], $_POST['to_time'][$i], $_POST['day'][$i], $_POST['class_id']);
	}

	header("Location: manage-class.php?class_id=".$_POST['class_id']);
}

// Delete the subject from the table
if(isset($_POST['process_type']) || !empty($_POST['process_type'])){
	$delete_subject_message = DeleteSubject($_POST['subject_id']);
	echo $delete_subject_message;
}

?>