<?php 

// Display the full name of the user for the class president text field
function SelectUserName($user_id){
	$conn = OpenCon();
	$sql = "SELECT f_name, l_name
			FROM user
			WHERE user_id = '$user_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn->close();
	return $row['f_name']." ".$row['l_name'];
}

// Create a class
function InputClass($class_name, $class_code, $user_id, $school_year){
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
		else{
			echo "Error: " . $sql . "<br>" . $conn->error;
			$conn->close();
			return 0;
		}
	}
	// Error out if the class table insert did not work
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
		$conn->close();
		return 0;
	}
}

// Select the class name using a class id
function SelectClassName($class_id){
	$conn = OpenCon();
	$sql = "SELECT class_name
			FROM class
			WHERE class_id = '$class_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn->close();
	return $row['class_name'];
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
?>