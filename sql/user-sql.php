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
?>