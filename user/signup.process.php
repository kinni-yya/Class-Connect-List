<?php
include '../dbconnect.php';
if (session_status() === PHP_SESSION_NONE) {
    // Start session
    session_start();
}

$email_result = checkEmail($_POST['email']);
$contact_result = checkContact($_POST['contact']);

if($contact_result != NULL){
    echo "Contact Number Already Exist"; echo "<br>";
    echo $contact_result['contact_no'];
}
elseif($email_result != NULL){
    echo "Email Already Exist";
}
elseif($_POST['password'] != $_POST['repassword']){
    echo "Password Not Same";
}
else{
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $result = createUser(strtolower($_POST['email']), $password_hash, $_POST['contact'], 
    ucwords($_POST['fname']), $_POST['mi'], ucwords($_POST['lname']));
    echo $result;
}