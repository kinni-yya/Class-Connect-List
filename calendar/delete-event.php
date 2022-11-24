<?php 
require_once('db-connect.php');
if(!isset($_GET['id'])){
    echo "<script> alert('Undefined Event ID.'); location.replace('./calendar.php') </script>";
    $conn->close();
    exit;
}

$delete = $conn->query("DELETE FROM `calendar` where id = '{$_GET['id']}'");
if($delete){
    echo "<script> alert('Event deleted successfully.'); location.replace('./calendar.php') </script>";
}else{
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: ".$conn->error."<br>";
    echo "SQL: ".$sql."<br>";
    echo "</pre>";
}
$conn->close();

?>