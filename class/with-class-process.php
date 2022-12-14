<?php
include '../dbconnect.php';
OpenSession();
$conn = OpenCon();

// INSERT 
if (isset($_POST['class_code']) && !empty($_POST['class_code'])) {
	// Send the parameters to InsertSubject() function to insert to the subject table
	$insert_student = InsertStudent(
		$_POST['class_code'],
		$_SESSION['user_id'], 
		$conn
	);
}

// GO BACK: Check if the insert_student returned has a value
if ($insert_student > 0) {
	header("location: with-class.php?class_id=$class_id");
}
