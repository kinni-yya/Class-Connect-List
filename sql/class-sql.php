<?php

// Display the full name of the user for the class president text field
function SelectUserName($user_id)
{
	$conn = OpenCon();
	$sql = "SELECT f_name, l_name
			FROM user
			WHERE user_id = '$user_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn->close();
	return $row['f_name'] . " " . $row['l_name'];
}

// Create a class
function InputClass($class_name, $class_code, $user_id, $school_year)
{
	$conn = OpenCon();
	// Insert into class table
	$sql = "INSERT INTO class (class_name, class_code, creator_id, school_year)
			VALUES ('$class_name', '$class_code', '$user_id', '$school_year')";
	
	if ($conn->query($sql) === TRUE) {
		// Select the last insert id or the class id created
		$sql = "SELECT LAST_INSERT_ID();";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$class_id = $row['LAST_INSERT_ID()'];

		// Insert into member table
		$sql = "INSERT INTO member (member_type, class_id, user_id)
			VALUES ('1', '$class_id', '$user_id')";
		if ($conn->query($sql) === TRUE) {
			// If the insert member worked return the class id
			$conn->close();
			return $class_id;
		}
		// Error out if the member table insert did not work
		else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			$conn->close();
			return 0;
		}
	}
	// Error out if the class table insert did not work
	else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		$conn->close();
		return 0;
	}
}

// Select the class name using a class id
function SelectClassName($class_id)
{
	$conn = OpenCon();
	$sql = "SELECT class_name
			FROM class
			WHERE class_id = '$class_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn->close();
	return $row['class_name'];
}

function GetClass($user_id)
{
	$conn = OpenCon();
	// INNER JOIN = join the same attributes from different tables 
	// class table = class_id, class_name, class_code, school_year
	// member table = member_type
	$sql = "SELECT class.class_id, class.class_name, class.class_code, class.school_year, member.member_type
			FROM class
			JOIN member
			ON class.class_id = member.class_id
			WHERE member.user_id = '$user_id'";
	// why query() = simple queries (e.g., select, update, delete, insert)
	// multiquery() = ex. select sa loob ng WHERE/SELECT; so far si jim lang gumagamit 
	$result = $conn->query($sql);
	$conn->close();
	return $result;
}

function GetClassId($class_code){
	// opens connection to database
	$conn = OpenCon();
	$sql = "SELECT class_id
			FROM class
			WHERE class_code = '$class_code'";
	// conn can query, then stores the result to $result
	$result = $conn->query($sql);
	// convert to array/dictionary for PHP to make use of the info (since only sql can understand $result)
	$class_id = $result->fetch_assoc();
	$conn->close();
	// return value
	return $class_id['class_id'];
}
// 2 Types of using SQL row
// 1 row expected:
// $result = $conn->query($sql);
// $row = $result->fetch_assoc();
// 
// many rows expected:
// $result = $conn->query($sql);
// while($row = $result->fetch_assoc()){
// echo $row['column name']
// }

function GetSubject($class_id)
{
	$conn = OpenCon();
	$sql = "SELECT * 
			FROM subject
			WHERE class_id = $class_id";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn->close();
	return $row;
}

function InsertSubject($subject_name, $subject_details, $professor, $class_id, $conn)
{
	$sql = "INSERT INTO subject (subject_name, subject_details, professor, class_id)
			VALUES ('$subject_name', " .
		# TERNARY: NOT REQUIRED
		# IF variable is null, put "NULL"; else put the inputted variable
		($subject_details == null ? "NULL" : "'$subject_details'")
		. ", " .
		($professor == null ? "NULL" : "'$professor'")
		. ", '$class_id')";
	if ($conn->query($sql) === TRUE) {
		echo "Subject added successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}

// Check if the class code generated is unique
function checkClassCode($class_code){
	$conn = OpenCon();
	$sql = "SELECT class_id
			FROM class
			WHERE class_code = '$class_code'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0){
		$conn->close();
		return 1;
	}
	else{
		$conn->close();
		return 0;

	}
}

// Check if the user has a full access on the class
function checkManageClass($class_id, $user_id){
	$conn = OpenCon();
	$sql = "SELECT class_id
			FROM member
			WHERE class_id = '$class_id' AND user_id = '$user_id' AND member_type = '1'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0){
		$conn->close();
		return TRUE;
	}
	else{
		$conn->close();
		return FALSE;
	}
}

// Check if the user is in a class or not for the no-class and with-class page
function checkClassJoin($user_id){
	$conn = OpenCon();
	$sql = "SELECT member_id
			FROM member
			WHERE user_id = '$user_id'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0){
		$conn->close();
		return TRUE;
	}
	else{
		$conn->close();
		return FALSE;
	}
}

// User joining using a class code
function InsertMemberJoin($class_code, $user_id){
	$conn = OpenCon();
	// Check if the class code exist
	$sql = "SELECT class_id
			FROM class
			WHERE class_code = '$class_code'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	if ($result->num_rows > 0){
		// If the class exist insert the member
		$sql = "INSERT INTO member (member_type, class_id, user_id) 
				VALUES ('0', '".$row['class_id']."', '$user_id')";
		if ($conn->query($sql) === TRUE) {
			// echo $row['class_id'];
			header("location: ../class/with-class.php");
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	else{
		echo 0;
	}
	$conn->close();
}

// Select all the subject for a specific class
function SelectClassSubjectList($class_id, $member_id){
	$conn = OpenCon();
	$sql = "SELECT *
			FROM subject
			WHERE class_id = '$class_id'";
	$result = $conn->query($sql);
	$conn->close();
	return $result;
}

// Select all the member of a specific class
function SelectClassMemberList($class_id){
	$conn = OpenCon();
	$sql = "SELECT member.*, user.f_name, user.m_name, user.l_name
			FROM member
			JOIN user
			ON member.user_id = user.user_id
			WHERE class_id = '$class_id'";
	$result = $conn->query($sql);
	$conn->close();
	return $result;
}