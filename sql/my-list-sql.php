<?php
function GetUserNote($user_id)
{
    $conn = OpenCon();
    $sql = "SELECT *
			FROM user_note
			WHERE user_id = '$user_id'
            AND note_id NOT IN (SELECT note_id FROM archive_user_note)
            ORDER BY note_id DESC";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function GetUserNoteArchive($user_id)
{
    $conn = OpenCon();
    $sql = "SELECT *
			FROM user_note AS user 
            JOIN archive_user_note AS archive
            ON user.note_id = archive.note_id
			WHERE user.user_id = '$user_id'
            ORDER BY archive.archive_user_note_id DESC";
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
    if ($conn->multi_query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

function ArchiveUserNote($note_id, $user_id, $conn)
{
    $sql = "INSERT INTO archive_user_note (note_id, user_id)
    VALUES ('$note_id',  $user_id)";
    if ($conn->query($sql) === TRUE) {
        echo "Note archived successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

function RestoreArchiveUserNote($archive_user_note_id, $conn)
{
    $sql = "DELETE FROM archive_user_note
    WHERE archive_user_note_id = '$archive_user_note_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Note restored successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
