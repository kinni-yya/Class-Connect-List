<?php
// Check what member type is a user 0 for regular and 1 for officers
function MemberInfo($user_id, $class_id){
	$conn = OpenCon();
	$sql = "SELECT member_id, member_type
			FROM member
			WHERE user_id = $user_id AND class_id = $class_id";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}

// Get the information about a specific class
function GetClassRecord($class_id){
	$conn = OpenCon();
	$sql = "SELECT * 
			FROM class 
			WHERE class_id = $class_id";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc(); 
	$conn -> close();
	return $row;
}

// Get all the subject names from a given class
function GetAMemberSubjectNames($member_id, $class_id){
	$conn = OpenCon();
	$sql = "SELECT subject_id, subject_name
			FROM subject
			WHERE class_id = '$class_id' AND subject_id NOT IN (
				SELECT subject_id
				FROM unenroll
				WHERE member_id = '$member_id')";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}

// Insert to note table
function InsertNote($class_id, $subject_id, $due_date, $due_time, $note_title, $description, $conn){
	$offset = SynchTimeZone();
	// Change the timezone first then proceed with the query, this is a multi_query instead of a query
	$sql = "SET time_zone='$offset';

			INSERT INTO note (class_id, subject_id, post_date, due_date, due_time, note_title, description)
			VALUES ('$class_id', ".
			($subject_id == null ? "NULL" : "'$subject_id'")
			.", CURDATE(), ".
			($due_date == null ? "NULL" : "'$due_date'")
			.", ".
			($due_time == null ? "NULL" : "'$due_time'")
			.", '$note_title', '$description')";
	if ($conn->multi_query($sql) === TRUE) {
		echo "Note updated successfully";
	}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn -> close();
}

// Select records from the note table where due date have values
function SelectDueRecord($class_id, $member_id){
	$conn = OpenCon();
	$sql = "SELECT *
			FROM note
			WHERE class_id = '$class_id' AND due_date IS NOT NULL AND (subject_id NOT IN (
				SELECT subject_id
			    FROM unenroll
			    WHERE member_id = '$member_id') OR subject_id IS NULL) AND note_id NOT IN (
				SELECT note.note_id
				FROM note
				JOIN archive_note
				ON note.note_id = archive_note.note_id
				WHERE class_id = '$class_id' AND member_id = '$member_id')
			ORDER BY due_date ASC";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}

// Select records from the note table where due date is null
function SelectAnnouncementRecord($class_id, $member_id){
	$conn = OpenCon();
	$sql = "SELECT *
			FROM note
			WHERE class_id = '$class_id' AND due_date IS NULL AND (subject_id NOT IN (
				SELECT subject_id
			    FROM unenroll
			    WHERE member_id = '$member_id') OR subject_id IS NULL) AND note_id NOT IN (
				SELECT note.note_id
				FROM note
				JOIN archive_note
				ON note.note_id = archive_note.note_id
				WHERE class_id = '$class_id' AND member_id = '$member_id')
			ORDER BY post_date ASC";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}

// Update note table
function UpdateNote($note_id, $subject_id, $due_date, $due_time, $note_title, $description, $conn){
	$offset = SynchTimeZone();
	// Change the timezone first then proceed with the query, this is a multi_query instead of a query
	$sql = "SET time_zone='$offset';

			UPDATE note
			SET subject_id = ".($subject_id == null ? "NULL" : "'$subject_id'").", due_date = ".($due_date == null ? "NULL" : "'$due_date'").", due_time = ".($due_time == null ? "NULL" : "'$due_time'").", note_title = '$note_title', description = '$description'
			WHERE note_id = '$note_id'";
	if ($conn->multi_query($sql) === TRUE) {
		echo "Note updated successfully";
	}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn -> close();
}

// Update note_status from the note_table
function ArchiveNote($note_id, $member_id, $conn){
	$sql = "INSERT INTO archive_note (note_id, member_id)
			VALUES ('$note_id', '$member_id')";
	if($conn->query($sql) === TRUE){
		echo "Note archived successfully";
	}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn -> close();
}

// Select from note where note_status = 1
function SelectArchiveNote($class_id, $member_id){
	$conn = OpenCon();
	$sql = "SELECT archive_note.archive_note_id, note.*
			FROM note
			JOIN archive_note 
			ON note.note_id = archive_note.note_id
			WHERE class_id = '$class_id' AND member_id = '$member_id' AND note.note_id IN (
				SELECT note_id 
				FROM archive_note 
				WHERE member_id = '$member_id'
			    )
			ORDER BY post_date ASC";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}

// Delete from archive_note to restore the note
function RestoreArchiveNote($archive_note_id, $conn){
	$sql = "DELETE FROM archive_note
			WHERE archive_note_id = '$archive_note_id'";
	if ($conn->query($sql) === TRUE) {
	  echo "Note restored successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn -> close();
}

// Add values to Pending_Note which is from the suggest note
function AddNotePending($subject_id, $due_date, $due_time, $note_title, $description, $member_id, $class_id, $conn){
	$offset = SynchTimeZone();
	$sql = "SET time_zone='$offset';

			INSERT INTO pending_note (subject_id, due_date, due_time, note_title, description, pending_date, status, member_id, class_id)
			VALUES(".($subject_id == null ? "NULL" : "'$subject_id'").", ".($due_date == null ? "NULL" : "'$due_date'").", ".($due_time == null ? "NULL" : "'$due_time'").", '$note_title', '$description', CURDATE(), '0', '$member_id', '$class_id')";
	
	if ($conn->multi_query($sql) === TRUE) {
	echo "Approval note added successfully";
	}
	else{
	echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Select all from the pending_note table filtered by member_id or who is logged in
function SelectApprovalNote($class_id, $member_id){
	$conn = OpenCon();
	$sql = "SELECT *
			FROM pending_note
			WHERE class_id = '$class_id' AND member_id = '$member_id'
			ORDER BY pending_note_id DESC";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}

// Delete a pending note
function DeletePendingNote($pending_note_id){
	$conn = OpenCon();
	$sql = "DELETE FROM pending_note
			WHERE pending_note_id = '$pending_note_id'";
	if ($conn->query($sql) === TRUE) {
	  echo "Pending note cancelled";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn -> close();
}

// Add values to Pending_Note which is from the correction note
function AddCorrectionPending($note_id, $subject_id, $post_date, $due_date, $due_time, $note_title, $description, $member_id, $class_id, $conn){
	$offset = SynchTimeZone();
	$sql = "SET time_zone='$offset';

			INSERT INTO pending_note (note_id, subject_id, post_date, due_date, due_time, note_title, description, pending_date, status, member_id, class_id)
			VALUES('$note_id', ".($subject_id == null ? "NULL" : "'$subject_id'").", '$post_date', ".($due_date == null ? "NULL" : "'$due_date'").", ".($due_time == null ? "NULL" : "'$due_time'").", '$note_title', '$description', CURDATE(), '0', '$member_id', '$class_id')";
	if ($conn->multi_query($sql) === TRUE) {
	echo "Correction note added successfully";
	}
	else{
	echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Select pending note of the class
function SelectPendingNote($class_id){
	$conn = OpenCon();
	$sql = "SELECT *
			FROM pending_note
			WHERE class_id = '$class_id' AND status = '0'";
	$result = $conn->query($sql);
	$conn -> close();
	return $result;
}

// Get the subject name using the subject ID
function SelectSubjectName($subject_id){
	$conn = OpenCon();
	$sql = "SELECT subject_name
			FROM subject
			WHERE subject_id = '$subject_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn -> close();
	return $row['subject_name'];
}

// Select a single note record using note id
function SelectANoteRecord($note_id){
	$conn = OpenCon();
	$sql = "SELECT *
			FROM note
			WHERE note_id = '$note_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn -> close();
	return $row;
}

//Process the pendinte_note if accepted change status to 2 if rejected change status to 1
// If accepted copy the old data from note to note_history first before changing status
function ProcessPendingNote($pending_note_id, $note_id, $status){
	$conn = OpenCon();
	// If Rejected
	if($status == '1'){
		$sql = "UPDATE pending_note
				SET status = '1'
				WHERE pending_note_id = '$pending_note_id'";
		if ($conn->query($sql) === TRUE) {
		  echo "Note Change Rejected";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	// If Accepted
	else if($status == '2'){
		$offset = SynchTimeZone();
		// Check if note_id is not Null, if it is the note has been suggested
		if($note_id != NULL){
		$sql = "SET time_zone='$offset';

				INSERT INTO note_history (note_id, pending_note_id, prev_subject_id, prev_due_date, prev_due_time, prev_note_title, prev_description, change_date)
				SELECT note_id, '$pending_note_id', subject_id, due_date, due_time, note_title, description, CURDATE()
				FROM note
				WHERE note_id = (SELECT note_id FROM pending_note WHERE pending_note_id = '$pending_note_id');

				UPDATE note, pending_note
				SET note.subject_id = pending_note.subject_id, note.due_date = pending_note.due_date, note.due_time = pending_note.due_time, note.note_title = pending_note.note_title, note.description = pending_note.description
				WHERE note.note_id = pending_note.note_id AND pending_note.pending_note_id = '$pending_note_id';

				UPDATE pending_note
				SET status = '2'
				WHERE pending_note_id = '$pending_note_id';";
		}
		// Check if note_id is Null, if it is the note has been corrected
		else if($note_id == NULL){
			$sql = "SET time_zone='$offset';

				INSERT INTO note (class_id, subject_id, post_date, due_date, due_time, note_title, description)
				SELECT class_id, subject_id, CURDATE(), due_date, due_time, note_title, description
				FROM pending_note
				WHERE pending_note_id = '$pending_note_id';

				UPDATE pending_note
				SET note_id = LAST_INSERT_ID(), status = '2'
				WHERE pending_note_id = '$pending_note_id';";
		}

		if ($conn->multi_query($sql) === TRUE) {
		echo "Note Change Accepted";
		}
		else{
		echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	$conn->close();
	return;
}

// Check if the note_id exist in Histroy_note table
function SelectNoteIdInHistory($note_id){
	$conn = OpenCon();
	$sql = "SELECT *
			FROM note_history
			WHERE note_id = '$note_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn -> close();
	return $row;
}

// Check if a subject is unenrolled using subject ID and member ID
function SelectUnenrollbySubjectID($subject_id, $member_id){
	$conn = OpenCon();
	$sql = "SELECT *
			FROM unenroll
			WHERE subject_id = '$subject_id' AND member_id = '$member_id'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$conn -> close();
		return $row;
	} else {
		$conn->close();
		return FALSE;
	}	
}

// Insert into unenroll table
function InsertUnenroll($member_id, $subject_id){
	$conn = OpenCon();
	$sql = "INSERT INTO unenroll (member_id, subject_id)
			VALUES ('$member_id', '$subject_id')";
	if ($conn->query($sql) === TRUE) {
	  echo "Subject unenrolled!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Delete from unenroll table to enroll
function DeleteUnenroll($unenroll_id){
	$conn = OpenCon();
	$sql = "DELETE FROM unenroll
			WHERE unenroll_id = '$unenroll_id'";
	if ($conn->query($sql) === TRUE) {
	  echo "Subject enrolled!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Change the member type
function UpdateMember($member_id, $member_type){
	$conn = OpenCon();
	$sql = "UPDATE member
			SET member_type = '".($member_type == "0" ? "1" : "0")."'
			WHERE member_id = '$member_id'";
	if ($conn->query($sql) === TRUE) {
	  echo "Member type changed!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

function DeleteMember($member_id){
	$conn = OpenCon();
	$sql = "DELETE FROM member
			WHERE member_id = '$member_id'";
	if ($conn->query($sql) === TRUE) {
	  echo "Member removed!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Count how many row are status pending by class
function CountPendingNote($class_id){
	$conn = OpenCon();
	$sql = "SELECT COUNT(pending_note_id) AS 'pending_count'
			FROM pending_note
			WHERE class_id = '$class_id' AND status = '0'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn -> close();
	return $row['pending_count'];
}

// Count all the note due today by class
function CountDueNoteToday($class_id, $member_id){
	$conn = OpenCon();
	$sql = "SET time_zone='+08:00';";
	if($conn->query($sql) === TRUE){
		$sql = "SELECT COUNT(note_id) AS 'due_count'
				FROM note
				WHERE class_id = '$class_id' AND due_date IS NOT NULL AND (subject_id NOT IN (
				SELECT subject_id
			    FROM unenroll
			    WHERE member_id = '$member_id') OR subject_id IS NULL) AND note_id NOT IN (
				SELECT note.note_id
				FROM note
				JOIN archive_note
				ON note.note_id = archive_note.note_id
				WHERE class_id = '$class_id' AND member_id = '$member_id') AND due_date = CURDATE()";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$conn -> close();
		return $row['due_count'];
	}
	$conn -> close();
}
?>