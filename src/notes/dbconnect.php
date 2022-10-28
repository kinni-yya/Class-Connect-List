<?php
// Open the Database Connection
function OpenCon(){
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "root123";
	$db = "list";
	// Create the SQL connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

	return $conn;
}

// Start the PHP Session
function OpenSession(){
	// Check if session already exist
	if (session_status() === PHP_SESSION_NONE) {
		// Start session
    	session_start();
    	// Synch the time zone for PH time
    	SynchTimeZone();
	}
}

// Change the PHP timezone
function SynchTimeZone(){
	// Set PHP time zone
	define('TIMEZONE', 'Asia/Singapore');
	date_default_timezone_set(TIMEZONE);

	// Calculate PHP time zone
	$now = new DateTime();
	$mins = $now->getOffset() / 60;
	$sgn = ($mins < 0 ? -1 : 1);
	$mins = abs($mins);
	$hrs = floor($mins / 60);
	$mins -= $hrs * 60;
	$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
	
	// Return PHP timezone to use for SQL
	return $offset;
}

// Check what member type is a user 0 for regular and 1 for officers
function MemberType($user_id){
	$conn = OpenCon();
	$sql = "SELECT access FROM member WHERE user_id =$user_id";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc(); 
	$conn -> close();
	return $row['access'];
}

// Insert to note table
function InsertNote($class_id, $note_title, $description, $due_date, $conn){
	$offset = SynchTimeZone();
	// Change the timezone first then proceed with the query, this is a multi_query instead of a query
	if($due_date == null){
		$sql = "SET time_zone='$offset'; INSERT INTO note (class_id, post_date, due_date, note_title, description, note_status) VALUES ('$class_id', CURDATE(), null, '$note_title', '$description', '0')";
	}
	else{
		$sql = "SET time_zone='$offset'; INSERT INTO note (class_id, post_date, due_date, note_title, description, note_status) VALUES ('$class_id', CURDATE(), '$due_date', '$note_title', '$description', '0')";
	}
	if ($conn->multi_query($sql) === TRUE) {
		echo "Note created successfully";
	}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn -> close();
} 

// Select records from the note table where due date is null
function SelectAnnouncementRecord($class_id){
	$conn = OpenCon();
	$sql = "SELECT note_id, class_id, post_date, note_title, description, note_status FROM note WHERE class_id = '$class_id' AND due_date IS NULL AND note_status = '0'";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}


// Select records from the note table where due date have values
function SelectDueRecord($class_id){
	$conn = OpenCon();
	$sql = "SELECT note_id, class_id, post_date, due_date, note_title, description, note_status FROM note WHERE class_id = '$class_id' AND due_date IS NOT NULL AND note_status = '0' ORDER BY due_date ASC";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}

// Update note table
function UpdateNote($note_id, $note_title, $description, $due_date, $conn){
	$offset = SynchTimeZone();
	// Change the timezone first then proceed with the query, this is a multi_query instead of a query
	if($due_date == null){
		$sql = "SET time_zone='$offset'; UPDATE note SET due_date = null, note_title = '$note_title', description = '$description' WHERE note_id = '$note_id'";
	}
	else{
		$sql = "SET time_zone='$offset'; UPDATE note SET due_date = '$due_date', note_title = '$note_title', description = '$description' WHERE note_id = '$note_id'";
	}
	if ($conn->multi_query($sql) === TRUE) {
		echo "Note updated successfully";
	}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn -> close();
}

// Update note_status from the note_table
function UpdateNoteStatus($note_id, $note_status, $conn){
	// Note Status 1 to Archive
	if($note_status == 1){
		$sql = "UPDATE note SET note_status = '1' WHERE note_id = '$note_id'";
		if($conn->query($sql) === TRUE){
			echo "Note archived successfully";
		}
		else{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn -> close();
	}
	// Note Status 0 to restore
	else if($note_status == 0){
		$sql = "UPDATE note SET note_status = '0' WHERE note_id = '$note_id'";
		if($conn->query($sql) === TRUE){
			echo "Note restored successfully";
		}
		else{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn -> close();
	}
}

// Select from note where note_status = 1
function SelectArchiveNote($class_id){
	$conn = OpenCon();
	$sql = "SELECT note_id, class_id, post_date, due_date, note_title, description, note_status FROM note WHERE class_id = '$class_id' AND note_status = '1'";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}
?>