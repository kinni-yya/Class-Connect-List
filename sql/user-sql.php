<?php 
function checkEmail($email){
	$conn = OpenCon();
	$sql = "SELECT user_id, email, password
			FROM user
			WHERE email = '$email'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn->close();
	return $row;
}

function checkContact($contact){
	$conn = OpenCon();
	$sql = "SELECT contact_no
			FROM user
			WHERE contact_no = '$contact'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$conn->close();
	return $row;
}

function createUser($email, $password, $contact, $fname, $mi, $lname){
	$conn = OpenCon();
	$sql = "INSERT INTO user (email, password, contact_no, f_name, m_name, l_name)
	VALUES (?,?,?,?,?,?)";

	$stmt = $conn->stmt_init();
	if ( ! $stmt->prepare($sql)) {
		die("SQL error: " . $conn->error);
	}
	$stmt->bind_param("ssssss", 
					$email, 
					$password, 
					$contact, 
					$fname, 
					$mi, 
					$lname);
	if ($stmt->execute()) {
    	return "Success";
    }
}
?>