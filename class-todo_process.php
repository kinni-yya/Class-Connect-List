<?php 
include "includes/config.php";
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}

if(isset($_POST['note_title'])){
	$title = mysqli_real_escape_string($conn, $_POST['note_title']);
	$description = mysqli_real_escape_string($conn, $_POST['note_desc']);
	$class_id = $_POST['class_id'];
	$sql = "INSERT INTO classtodos(note_title, note_description, subject_id) VALUES('$title', '$description', '$class_id')";
	if($conn->query($sql) === TRUE){
		echo 0;
	}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

if(isset($_POST['edit_note_title'])){
	$title = mysqli_real_escape_string($conn, $_POST['edit_note_title']);
	$description = mysqli_real_escape_string($conn, $_POST['edit_note_desc']);
	$id = $_POST['id'];
	$sql = "UPDATE classtodos SET note_title = '$title', note_description = '$description' WHERE id = '$id'";
	if ($conn->query($sql) === TRUE) {
		$sql = "SELECT subject_id FROM classtodos WHERE id = '$id'";
		$result = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($result);
		$row = $result->fetch_assoc();
		echo $row['subject_id'];
	}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}


$conn->close();
?>