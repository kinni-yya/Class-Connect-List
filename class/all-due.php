<?php
// Include database connection with SQL queries function
include '../dbconnect.php';
// Check if session exist
OpenSession();

$select_announcement_result = SelectAllAnnouncementRecord($_SESSION['user_id'], "due");
while ($row = $select_announcement_result->fetch_assoc()) {

?>
    <!-- Box -->
    <div class="note-box">
        <div class="row" onclick="DisplayNoteDetails(this)">
            <!-- Title -->
            <span class="note-title col-6 align-self-center"><?php echo $row['note_title']; ?></span>
            <!-- Details -->
            <span class="note-description col-4 align-self-center">
                <?php
                if (strlen($row['description']) > 50) {
                    echo "\"" . substr($row['description'], 0, 50) . "\"...";
                } else {
                    echo $row['description'];
                }
                ?>
            </span>
            <div class="col-2 align-self-center">
                <!-- Spent date -->
                <span class="note-due"><?php 
                // Compute how many day before due date
                $difference = (strtotime($row['due_date']) - strtotime(date("Y-m-d"))) / (24*60*60);
                if($difference == 0){
                    echo "<span class=\"note-due\" style=\"color: orange;\">Today ".date('h:i A',strtotime($row['due_time']))."</span>";
                }
                else if ($difference > 0) {
                    echo "<span class=\"note-due\" style=\"color: green;\">Due on $difference day\\s ".date('h:i A',strtotime($row['due_time']))."</span>";
                }
             ?></span>
                <br>
                <!-- Date -->
                <span class="note-day"><?php echo $row['post_date']; ?></span>
            </div>
        </div>

        <div class="note-detail">
            <div class=" detail-container">
                <div class="note-detail-box">
                    <span><?php echo $row['description']; ?></span>
                </div>
            </div>

            <div class="container d-flex justify-content-end">
                &emsp;<button class="btn btn-outline-success" data-id='<?php echo json_encode(
                    array(
						"note_id" => $row['note_id'],
						"class_id" => $row['class_id'],
						"user_id" => $_SESSION['user_id']
					),
					JSON_HEX_QUOT
				); ?>' onclick="CompleteTask(this)">Complete</button>
                &emsp;<button class="btn btn-outline-secondary" onclick="CloseDisplayNote(this)">Close</button>
            </div>
        </div>
    </div>
    <br>

<?php
}
?>