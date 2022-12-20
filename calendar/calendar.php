<?php 
require_once('../dbconnect.php');
OpenSession(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Calendar CSS -->
    <link rel="stylesheet" href="../css/calendar.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/fullcalendar.css">
</head>

<body>
    <?php DisplayNavHeader(); ?>
    
    <div class="container" id="page-container">
        <div class="row">

            <div class="col-md-9">
                <div id="calendar"></div>
            </div>

            <div class="col-md-3">
                <!-- CATEGORIES OF CALENDAR -->
                <div class="cardt rounded-0 shadow">
                    <div class="card-header text-light">
                        <h5 class="card-title">Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="form-group mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Subject Schedule
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Deadlines
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        My List
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded">
                <div class="modal-header rounded 4">
                    <h5 class="modal-title" color="yellow">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Event Title</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="description" class=""></dd>
                            <dt class="text-muted">Event Start</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">Event End</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-4">
                    <div class="text-end">
                        <!-- Delete commented for now -->
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                        <!-- <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button> -->
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->

    <!-- Add Event Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="add-event-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content popup">
            <form id="add-event-form">

                <div class="modal-header rounded 4 part1">
                    <h5 class="modal-title" color="yellow">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body part2">
                    
                    <div class="form-group mb-2">
                        <label for="title" class="form-label">Event Title:</label>
                        <input type="text" name="event_title" id="event_title" class="form-control" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="description" class="form-label">Event Description:</label>
                        <textarea rows="3" name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group mb-2">
                        <label for="start_datetime" class="form-label">Event Start:</label>
                        <input type="datetime-local" name="start_datetime" id="start_datetime" class="form-control" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="end_datetime" class="form-label">Event Due:</label>
                        <input type="datetime-local" name="end_datetime" id="end_datetime" class="form-control" required>
                    </div>

                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                </div>
                <div class="modal-footer rounded-4 part3">
                    <div class="text-end">
                        <!-- Save button for add commented for now since it is not working -->
                        <!-- <button type="submit" class="btn btn-primary btn-sm rounded-0 submitbtn">Save</button> -->
                        <button type="button" class="btn btn-secondary btn-sm rounded-0 closebtn" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>

            </form>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->

    <!-- Edit Event Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="edit-event-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded">
            <form id="edit-event-form">

                <div class="modal-header rounded 4">
                    <h5 class="modal-title" color="yellow">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="event_id">
                    
                    <div class="form-group mb-2">
                        <label for="title" class="form-label">Event Title:</label>
                        <input type="text" name="event_title" id="event_title" class="form-control" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="description" class="form-label">Event Description:</label>
                        <textarea rows="3" name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group mb-2">
                        <label for="start_datetime" class="form-label">Event Start:</label>
                        <input type="datetime-local" name="start_datetime" id="start_datetime" class="form-control" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="end_datetime" class="form-label">Event Due:</label>
                        <input type="datetime-local" name="end_datetime" id="end_datetime" class="form-control" required>
                    </div>

                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                </div>
                <div class="modal-footer rounded-4">
                    <div class="text-end">
                        <!-- Save edit button commented for now since it is not working -->
                        <!-- <button type="submit" class="btn btn-primary btn-sm rounded-0">Save</button> -->
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>

            </form>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->

    <!-- AJAX / jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Full calendar script -->
    <script src="https://unpkg.com/fullcalendar@5.10.1/main.js"></script>

<?php 
// Show only the calendar per class and exlude the subjects the user is unenrolled
$schedules = SelectCalendarRecord($_SESSION['user_id']);

$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
    $sched_res[$row['calendar_id']] = $row;
}
?>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];

    $(function() {
        if (!!scheds) {
            Object.keys(scheds).map(k => {
                var row = scheds[k]
                events.push({
                    id: row.calendar_id,
                    title: row.event_title,
                    start: row.start_datetime,
                    end: row.end_datetime
                });
            })
        }

        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        calendar = new Calendar(document.getElementById('calendar'), {
            customButtons: {
                addEvent: {
                    text: 'Add Event',
                    click: function(){
                        $('#add-event-modal').modal('show');
                    }
                }
            },
            headerToolbar: {
                right: 'addEvent today prev,next',
                left: 'dayGridMonth,timeGridWeek,listWeek',
                center: 'title',
            },
            selectable: true,
            themeSystem: 'standard',
            //Random default events
            events: events,
            eventClick: function(info) {
                var _details = $('#event-details-modal')
                var calendar_id = info.event.id
                if (!!scheds[calendar_id]) {
                    _details.find('#title').text(scheds[calendar_id].event_title)
                    _details.find('#description').text(scheds[calendar_id].description)
                    _details.find('#start').text(scheds[calendar_id].sdate)
                    _details.find('#end').text(scheds[calendar_id].edate)
                    _details.find('#edit,#delete').attr('data-id', calendar_id)
                    _details.modal('show')
                } else {
                    alert("Event is undefined");
                }
            }
        });

        calendar.render();

        // Edit Button
        $('#edit').click(function() {
            var calendar_id = $(this).attr('data-id');
            if (!!scheds[calendar_id]) {
                var _form = $('#edit-event-modal');
                _form.find('[name="event_id"]').val(scheds[calendar_id].event_id);
                _form.find('[name="event_title"]').val(scheds[calendar_id].event_title);
                _form.find('[name="description"]').val(scheds[calendar_id].description);
                _form.find('[name="start_datetime"]').val(String(scheds[calendar_id].start_datetime).replace(" ", "T"));
                _form.find('[name="end_datetime"]').val(String(scheds[calendar_id].end_datetime).replace(" ", "T"));
                $('#event-details-modal').modal('hide');
                $('#edit-event-modal').modal('show');
                _form.find('[name="event_title"]').focus();
            } else {
                alert("Event is undefined");
            }
        });

        // Delete Button / Deleting an Event
        $('#delete').click(function() {
            var calendar_id = $(this).attr('data-id');
            if (!!scheds[calendar_id]) {
                var _conf = confirm("Are you sure to delete this scheduled event?");
                if (_conf === true) {
                    $.ajax({
                        type: 'POST',
                        url: 'calendar_process.php',
                        data: {
                            "calendar_id": calendar_id
                        },
                        success: function(data){
                            alert(data);
                            location.reload();
                        }
                    });
                }
            } else {
                alert("Event is undefined");
            }
        });
    });
</script>

<!-- Add and Edit calendar event-->
<script type="text/javascript">
$("#add-event-form").submit(function(e){
    e.preventDefault();
    var form = $(this);

    $.ajax({
        type: 'POST',
        url: 'calendar_process.php',
        data: form.serialize(),
        success: function(data){
            alert(data);
            location.reload();
        }
    });
});

$("#edit-event-form").submit(function(e){
    e.preventDefault();
    var form = $(this);

    $.ajax({
        type: 'POST',
        url: 'calendar_process.php',
        data: form.serialize(),
        success: function(data){
            alert(data);
            location.reload();
        }
    });
});
</script>

</body>
</html>