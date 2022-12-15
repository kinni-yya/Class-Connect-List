<?php 
// Include database connection with SQL queries function
include '../dbconnect.php';
// Check if session exist
OpenSession();

//Get the access attribute from Database, if 0 regular if 1 full
$member_info = MemberInfo($_SESSION['user_id'], $_GET['class_id']);
$result = $member_info->fetch_assoc(); 
$member_id = $result['member_id'];
$access = $result['member_type'];
// Get the class_id from URL parameter
$class_id = $_GET['class_id'];
?>

<h3>Class Subjects</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th scope="col">Subject ID</th>
			<th scope="col">Subject Name</th>
			<th scope="col">Professor</th>
			<th scope="col">Details</th>
			<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		$result = SelectClassSubjectList($_GET['class_id'], $member_id);
		while($row = $result->fetch_assoc()){
	?>
		<tr>
			<th scope="row"><?php echo $row['subject_id'];?></th>
			<td><?php echo $row['subject_name'];?></td>
			<td><?php echo $row['professor'];?></td>
			<td><?php echo $row['subject_details'];?></td>
			<td><button class="btn btn-outline-danger">Unenroll</button></td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<br>
<h3>Class Members</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Member ID</th>
			<th scope="col">Member Name</th>
			<th scope="col">Member Type</th>
			<?php 
			// Check if the user logged in is a full user of the class to give access to change type of other users
			if($access == 1){
				echo "<th scope=\"col\">Action</th>";
			}?>
		</tr>
	</thead>
	<tbody>
	<?php 
		$result = SelectClassMemberList($_GET['class_id']);
		while($row = $result->fetch_assoc()){
	?>
		<tr>
			<th scope="row"><?php echo $row['member_id'];?></th>
			<td><?php echo $row['f_name']." ".$row['m_name']." ".$row['l_name']; ?></td>
			<td><?php 
			// Check if the member type of the member listed is full access or member
			if ($row['member_type'] == 1) {
				echo "Full Access";
			}
			else{
				echo "Member";
			}
			?></td>
			<td><?php
			// Check if the user logged in is a full user of the class to give access to change type of other users
			if($access == 1 && ($_SESSION['user_id'] != $row['user_id'])){
				echo "<button class=\"btn btn-outline-info\">Change Type</button>";
			}?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>