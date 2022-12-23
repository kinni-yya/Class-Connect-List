<?php 

// Select calendar per class and exclude unenrolled subeject
function SelectClassCalendar($class_id, $member_id){
	$conn = OpenCon();
	$sql = "SELECT *
        FROM calendar
        WHERE class_id = '$class_id' AND (subject_id NOT IN (
            SELECT subject_id
            FROM unenroll
            WHERE member_id = '$member_id') OR subject_id IS NULL)";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

// Insert into calendar
function InsertClassCalendarEvent($event_title, $description, $start_datetime, $end_datetime, $class_id, $subject_id, $conn){
	$sql = "INSERT INTO calendar(event_title, description, start_datetime, end_datetime, class_id, subject_id)
			VALUES ('$event_title', ".($description == null ? "NULL" : "'$description'").", '$start_datetime', '$end_datetime', '$class_id', ".($subject_id == null ? "NULL" : "'$subject_id'").")";
	if ($conn->query($sql) === TRUE) {
		// Create note after the calendar
		InsertNoteClassCalendar($event_title, $description, $start_datetime, $end_datetime, $class_id, $subject_id, $conn->insert_id);
	  	echo "Event created!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Update an event from the calendar table
function UpdateClassCalendarEvent($event_id, $event_title, $description, $start_datetime, $end_datetime, $class_id, $subject_id, $conn){
	$sql = "UPDATE calendar
			SET event_title = '$event_title', description = ".($description == null ? "NULL" : "'$description'").", start_datetime = '$start_datetime', end_datetime = '$end_datetime', class_id = '$class_id', subject_id = ".($subject_id == null ? "NULL" : "'$subject_id'")."
			WHERE event_id = '$event_id'";
	if ($conn->query($sql) === TRUE) {
		// Update the note after the calendar
		UpdateNoteClassCalendar($event_title, $description, $start_datetime, $end_datetime, $class_id, $subject_id, $event_id);
	  	echo "Event modified!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Delete an event from the calendar table
function DeleteClassCalendarEvent($event_id, $conn){
	$sql = "DELETE FROM calendar
			WHERE event_id = '$event_id'";
	if ($conn->query($sql) === TRUE) {
		// Remove the note after removing the calendar
		DeleteNoteClassCalendar($event_id);
	  	echo "Event removed!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Select the calendar per user
function SelectCalendarRecord($user_id){
	$conn = OpenCon();
	// Unioned the table that the user can see after excluding the unenroll and the table for user calendar
	// Set c_id as calendar_id which is a temporary row that auto incremate which will serve as the array key for the calendar
	// Added the class_id to determine if the event is from a user or from a class
	$sql = "SET @c_id = 0";
	if ($conn->query($sql) === TRUE) {
		$sql = "(SELECT (@c_id := @c_id + 1) AS 'calendar_id', calendar.event_id, calendar.event_title, calendar.description, calendar.start_datetime, calendar.end_datetime, member.user_id, calendar.class_id
				FROM calendar
				JOIN member
				ON calendar.class_id = member.class_id
				WHERE user_id = '$user_id' AND (subject_id NOT IN (
					SELECT subject_id
					FROM unenroll
					WHERE member_id = member.member_id) OR subject_id IS NULL) AND calendar.class_id NOT IN(
					SELECT class_id
					FROM archive_class
					WHERE user_id = '$user_id'))
				UNION ALL
				(SELECT (@c_id := @c_id + 1) AS 'calendar_id', user_calendar.*, NULL as 'class_id'
				FROM user_calendar
				WHERE user_id = '$user_id')";
		$result = $conn->query($sql);
	    $conn->close();
	    return $result;
		}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

// Insert into user_calendar table
function InsertUserCalendar($event_title, $event_details, $event_from_date, $event_to_date, $user_id, $conn){
	$sql = "INSERT INTO user_calendar(event_title, event_details, event_from_date, event_to_date, user_id)
			VALUES ('$event_title', ".($event_details == null ? "NULL" : "'$event_details'").", '$event_from_date', '$event_to_date', '$user_id')";
	if ($conn->query($sql) === TRUE) {
	  echo "Event created!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Update an event from the user calendar table
function UpdateUserCalendar($event_id, $event_title, $event_details, $event_from_date, $event_to_date, $user_id, $conn){
	$sql = "UPDATE user_calendar
			SET event_title = '$event_title', event_details = ".($event_details == null ? "NULL" : "'$event_details'").", event_from_date = '$event_from_date', event_to_date = '$event_to_date', user_id = '$user_id'
			WHERE event_id = '$event_id'";
	if ($conn->query($sql) === TRUE) {
	  echo "Event modified!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Delete an event from the calendar table
function DeleteUserCalendar($event_id, $conn){
	$sql = "DELETE FROM user_calendar
			WHERE event_id = '$event_id'";
	if ($conn->query($sql) === TRUE) {
	  echo "Event removed!";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Insert into calendar table from insert note
function InsertClassCalendarNote($event_title, $description, $start_datetime, $end_datetime, $class_id, $subject_id, $note_id){
	$conn = OpenCon();
	// Insert into the calendar table
	$sql = "INSERT INTO calendar(event_title, description, start_datetime, end_datetime, class_id, subject_id)
			VALUES ('$event_title', ".($description == null ? "NULL" : "'$description'").", '$start_datetime', '$end_datetime', '$class_id', ".($subject_id == null ? "NULL" : "'$subject_id'").")";
	if ($conn->query($sql) === TRUE) {
		// Insert into the note_calendar table so the calendar and note can be referenced
		$sql = "INSERT INTO note_calendar (note_id, event_id)
				VALUES ('$note_id', '".$conn->insert_id."')";
		if ($conn->query($sql) === TRUE) {
			echo "Event created! \n";
		} else {
	 	 	echo "Error: " . $sql . "<br>" . $conn->error;
	 	}
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}
// Update the calendar table when the note is edited
function UpdateClassCalendarNote($event_title, $description, $start_datetime, $end_datetime, $class_id, $subject_id, $note_id){
	$conn = OpenCon();
	$sql = "SELECT *
			FROM note_calendar
			WHERE note_id = '$note_id'";
	$result = $conn->query($sql);
	// Check if there is a connection from calendar and note using the note_calendar
	if($result->num_rows > 0){
		// There is a calendar event for the note
		$sql = "UPDATE calendar
				SET event_title = '$event_title', description = '$description', start_datetime = '$start_datetime', end_datetime = '$end_datetime', class_id = '$class_id', subject_id = ".($subject_id == null ? "NULL" : "'$subject_id'")."
				WHERE event_id = (SELECT event_id
				FROM note_calendar
				WHERE note_id = '$note_id')";
		if ($conn->query($sql) === TRUE) {
		  echo "Event updated! \n";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	else{
		// There is no calendar event for the note
		// Create calendar event
		$sql = "INSERT INTO calendar(event_title, description, start_datetime, end_datetime, class_id, subject_id)
				VALUES ('$event_title', ".($description == null ? "NULL" : "'$description'").", '$start_datetime', '$end_datetime', '$class_id', ".($subject_id == null ? "NULL" : "'$subject_id'").")";
		// After creating the event create the note_calendar row to connect them for future tables
		if ($conn->query($sql) === TRUE) {
			// Insert into the note_calendar table so the calendar and note can be referenced
			$sql = "INSERT INTO note_calendar (note_id, event_id)
					VALUES ('$note_id', '".$conn->insert_id."')";
			if ($conn->query($sql) === TRUE) {
				echo "Event updated! \n";
			} else {
		 	 	echo "Error: " . $sql . "<br>" . $conn->error;
		 	}
		}
	}
	$conn->close();
}
?>