<?php
include "includes/config.php";
if (session_status() != PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}  
?>

<!doctype html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body>
    <?php getHeader(); ?>
    <div class="container">
        <h1 class="mb-2 fw-bold">Class List</h1>
        <a href="add-class.php" class="mb-3 btn btn-outline-primary text-dark">Add Class</a>
        <div class="row mb-2">
		
		<?php
		$user_id = $_SESSION['user_id'];
		$sql = "SELECT subject_class.id, subject_class.subject_name, subject_class.code, member.user_id
			FROM subject_class
			INNER JOIN member ON subject_class.id=member.class_id
			WHERE member.user_id = '$user_id'";
		$result = mysqli_query($conn, $sql);
		while($row = $result->fetch_assoc()){
			echo '<div class="col-md-6">';
			echo '<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">';
				echo '<div class="col p-4 d-flex flex-column position-static">';
				echo '<strong class="d-inline-block mb-2 text-success">'.$row['code'].'</strong>';
				echo ' <h3 class="mb-0">'.$row['subject_name'].'</h3>';
				//echo '<div class="mb-1 text-muted">Tuesday/Friday | 7:30 pm - 9:30 pm  </div>';
				echo '<a href="view-class-todo.php?class_id='.$row['id'].'" class="stretched-link">See Notes</a>';
				echo '</div>';
			echo '</div>';
			echo '</div>';
		}
		?>
			
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>