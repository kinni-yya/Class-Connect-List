<?php

function dbConnect()
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "todo";

    $conn = mysqli_connect($hostname, $username, $password, $database) or die("Database Connection Failed.");
    return $conn;
}
$conn = dbConnect();

/* Check if email is valid or not */

function emailIsValid($email)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email ='$email'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

/* Check if login credential is valid or not */

function checkLoginDetails($email, $password)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email ='$email' AND password ='$password'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

function createUser($email, $password)
{
    $conn = dbConnect();
    $sql = "INSERT into users (email, password) VALUES ('$email', '$password')";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getHead()
{
    $output =  '
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Class Connect: List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">';
    echo $output;
}

function getHeader()
{
    $output = '    
    <header class="py-3 mb-4 border-bottom bg-white">
        <div class="d-flex flex-wrap justify-content-center container">
            <a href="home.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-4">&#128221; Class Connect: List</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="calendar.php" class="nav-link text-dark">Calendar</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-dark">Classes</a></li>
                <li class="nav-item"><a href="group.php" class="nav-link text-dark">Groups</a></li>
                <li class="nav-item"><a href="resources.php" class="nav-link text-dark">Resources</a></li>
                <li class="nav-item"><a href="todos.php" class="nav-link text-dark">My List</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link bg-danger text-white">Profile</a></li>
            </ul>
        </div>
    </header>';
    echo $output;
}

function textLimit($string, $limit)
{
    if (strlen($string) > $limit) {
        return substr($string, 0, $limit) . "...";
    } else {
        return $string;
    }
}

function getTodo($todo)
{
    $output = '
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title">' . textLimit($todo['title'], 30) . '</h3>
            <p class="card-text text-justify">' . textLimit($todo['description'], 27)    . '</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="view-todo.php?id=' . $todo['id'] . '" type="button" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="edit-todo.php?id=' . $todo['id'] . '" type="button" class="btn btn-sm btn-outline-secondary">Edit</a>
                </div>
                <small class="text-muted">' . $todo['date'] . '</small>
            </div>
        </div>
    </div>';
    echo $output;
}

function getClassTodo($todo)
{
    $output = '
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title">' . textLimit($todo['note_title'], 30) . '</h3>
            <p class="card-text text-justify">' . textLimit($todo['note_description'], 27)    . '</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="view-ctodo.php?id=' . $todo['id'] . '" type="button" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="edit-class-todo.php?id=' . $todo['id'] . '" type="button" class="btn btn-sm btn-outline-secondary">Edit</a>
                </div>
                <small class="text-muted">' . $todo['date'] . '</small>
            </div>
        </div>
    </div>';
    echo $output;
}
