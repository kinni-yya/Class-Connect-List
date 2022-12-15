<?php
include '../dbconnect.php';
OpenSession();

$join_message = InsertMemberJoin($_POST['class_code'], $_SESSION['user_id']);

echo $join_message;
?>