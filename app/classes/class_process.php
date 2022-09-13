<?php 

include "../../includes/config.php";
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}

if(isset($_POST['subject_name'])){
	$count = 1;
	//Do the random looping as long as the subject code exist
	while($count > 0){
		$random_code = bin2hex(random_bytes(5));
		$sql = "SELECT code FROM subject_class WHERE code = '$random_code'";
		$result = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($result);
	}
	//Insert all the info to subject_class
	$subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
	$id = $_SESSION['user_id'];
	$sql = "INSERT INTO subject_class(subject_name, code, creator_id) VALUES('$subject_name', '$random_code', '$id')";
	//If the INSERT works get the last inert ID and INSERT into member
	if($conn->query($sql) === TRUE){
		$last_id = $conn->insert_id;
		$sql = "INSERT INTO member(class_id, access, user_id) VALUES('$last_id', '1', '$id')";
		if($conn->query($sql) === TRUE){
			//If the INSERT to member works, return the last insert id of subject_class to do a page redirect
			echo $last_id;
		}
		else{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

if(isset($_POST['code'])){
	$code = strtolower($_POST['code']);
	$sql = "SELECT * FROM subject_class WHERE code = '$code'";
	$result = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($result);
	//Check if there is a match
	if($count > 0){
		$row = $result->fetch_assoc();
		$class_id = $row['id'];
		$id = $_SESSION['user_id'];
		//Add the user as a member
		$sql = "INSERT INTO member(class_id, access, user_id) SELECT '$class_id', '0', '$id' WHERE NOT EXISTS(SELECT * FROM member WHERE class_id = '$class_id' AND user_id = '$id')";
		if($conn->query($sql) === TRUE){
			echo $class_id;
		}
		else{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	else{
		echo 0;
	}
}

$conn->close();
