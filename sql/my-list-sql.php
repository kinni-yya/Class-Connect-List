<?php
function GetUserNote($user_id)
{
    $conn = OpenCon();
    $sql = "SELECT *
			FROM user_note
			WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function InsertMyListNote($user_id, $due_date, $due_time, $note_title, $description, $conn)
{
    $offset = SynchTimeZone();
    // Change the timezone first then proceed with the query, this is a multi_query instead of a query
    $sql = "SET time_zone='$offset';
			INSERT INTO user_note (user_id, post_date, due_date, due_time, note_title, description)
			VALUES ('$user_id', CURDATE(), " .
        ($due_date == null ? "NULL" : "'$due_date'")
        . ", " .
        ($due_time == null ? "NULL" : "'$due_time'")
        . ", '$note_title', '$description')";
    if ($conn->multi_query($sql) === TRUE) {
        echo "Note added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

function SelectUserNoteRecord($note_id)
{
    $conn = OpenCon();
    $sql = "SELECT note_id, post_date, due_date, due_time, note_title, description
			FROM user_note
            WHERE note_id = '$note_id'";
    $result = $conn->query($sql);
    $conn->close();
    return $result->fetch_assoc();
}

function UpdateUserNote($note_id, $user_id, $due_date, $due_time, $note_title, $description, $conn)
{
    $offset = SynchTimeZone();
    $sql = "SET time_zone='$offset';

			UPDATE user_note
			SET user_id = " . ($user_id == null ? "NULL" : "'$user_id'") . ", 
                due_date = " . ($due_date == null ? "NULL" : "'$due_date'") . ", 
                due_time = " . ($due_time == null ? "NULL" : "'$due_time'") . ", 
                note_title = '$note_title', description = '$description'
			WHERE note_id = '$note_id'";
    if ($conn->multi_query($sql) === TRUE) {
        echo "Note updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
