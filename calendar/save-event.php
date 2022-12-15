<?php 
require_once('..\dbconnect.php');
$conn = OpenCon();
if($_SERVER['REQUEST_METHOD'] !='POST'){
    echo "<script> alert('Error: No data to save.'); location.replace('./calendar.php') </script>";
    $conn->close();
    exit;
}
extract($_POST);
$allday = isset($allday);

if(empty($id)){
    $sql = "INSERT INTO `calendar` (`title`,`description`,`event_type`, `start_datetime`,`end_datetime`, `class_id`) VALUES ('$title','$description','$event_type','$start_datetime','$end_datetime', '1')";
}else{
    $sql = "UPDATE `calendar` set `title` = '{$title}', `description` = '{$description}', `event_type` = '{$event_type}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
}
$save = $conn->query($sql);
if($save){
    echo "<script> alert('Event Successfully Saved.'); location.replace('./calendar.php') </script>";
}else{
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: ".$conn->error."<br>";
    echo "SQL: ".$sql."<br>";
    echo "</pre>";
}
$conn->close();
?>