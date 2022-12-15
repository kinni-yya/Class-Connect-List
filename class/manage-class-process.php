<?php
include '../dbconnect.php';
OpenSession();
// Open database connection for the nl2br
$conn = OpenCon();

/**  
 * FLOW OF PROCESS.php
 * 1. CHECK if the input boxes have values and if they are empty
 * 2. INSERT to table = send the parameters to function() to insert to a certain table
 * 3. GO BACK TO INITIAL PAGE
 */

// CHECK
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

// INSERT 
if (isset($_POST['subject_name']) && !empty($_POST['subject_name'])) {
	// Send the parameters to InsertSubject() function to insert to the subject table
	$add_subj_message = InsertSubject(
		$_POST['subject_name'],
		$subject_details,
		$professor,
		$_POST['class_id'],
		$conn
	);
}

// echo $add_subj_message;

// GO BACK: Check if the class_id returned has a value
if ($_POST['class_id'] > 0) {
	// Redirect to the add subject page
	header("location: with-class.php?class_id=" . $_POST['class_id'] . "");
}
