<?php 
include '../dbconnect.php';
OpenSession();

$class_code = bin2hex(random_bytes(5));;
// Check on the database if this randomly generated class code already exist in the database

$school_year = $_POST['school_year']."-01-01";

// Check if the class_name have values and it is not an empty value
if(isset($_POST['class_name']) && !empty($_POST['class_name'])){
	$class_id = InputClass($_POST['class_name'], $class_code, $_SESSION['user_id'], $school_year);
}

// Process to check if the class_name and the school year exist at the same time on a single record, if yes say that the class already exist

// Check if the class_id returned has a value
if($class_id > 0){
	// Redirect to the add subject page
	// header("location: add_subject.php?class_id=$class_id");
	header("location: with-class.php?class_id=$class_id");
}
?>