<?php

include "includes/config.php";
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}

if(isset($_POST["email"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, md5($_POST["password"]));

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
	$result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $row = $result->fetch_assoc();
		$_SESSION['user_id'] = $row['id'];
		$_SESSION['user_email'] = $row['email'];
		echo "0";
    }
	else{
		echo "1";
	}
}

if(isset($_POST["register_email"])){
	$email = mysqli_real_escape_string($conn, $_POST["register_email"]);
    $password = mysqli_real_escape_string($conn, md5($_POST["password"]));
	
	$sql = "SELECT * FROM users WHERE email = '$email'";
	$result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
		echo "1";
	}else{
		$sql = "INSERT INTO users(email, password) VALUES('$email', '$password')";
		if($conn->query($sql) === TRUE){
			$last_id = $conn->insert_id;
			$_SESSION['user_id'] = $last_id;
			$_SESSION['user_email'] = $email;
			echo "0";
		}
		else{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

$conn->close();
?>