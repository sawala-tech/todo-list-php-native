<?php
session_start();

//DB Connection
$host = "localhost";
$username = "root";
$password = "root";
$dbname = "todo_list";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function cleanInput($input)
{
    global $conn;

    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);

    $input = $conn->real_escape_string($input);

    return $input;
}

function signin($username, $password)
{
    global $conn;

    $username = cleanInput($username);
    $password = hash('sha256', cleanInput($password));

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;
        header('Location: ' . url('dashboard'));
    } else {
        echo "<script>alert('Username atau password salah!')</script>";
    }
}

function signup($username, $password)
{
    global $conn;

    $username = cleanInput($username);
    $password = hash('sha256', cleanInput($password));

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    return $conn->query($sql);
}

function checkLogin($path)
{
    if (!isset($_SESSION['user'])) {
        header('Location: ' . url($path));
    }
}

function getTasks()
{
    global $conn;
    $user_id = $_SESSION['user']['id'];

    $sql = "SELECT * FROM tasks WHERE user_id = $user_id";

    $result = $conn->query($sql);

    $tasks = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }

    return $tasks;
}

function deleteFile($file)
{
    $filePath = __DIR__ . "/../../assets/public/" . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

function deleteTask($id)
{
    global $conn;
    $sql = "SELECT attachment FROM tasks WHERE id = $id AND user_id = " . $_SESSION['user']['id'];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $file = $result->fetch_assoc()['attachment'];
        deleteFile($file);
    }

    $sql = "DELETE FROM tasks WHERE id = $id AND user_id = " . $_SESSION['user']['id'];

    return $conn->query($sql);
}

function saveFile($file)
{
    $target_dir = __DIR__ . "/../../assets/public/";
    $baseName = basename(time() . "_" . $file['name']);
    $target_file = $target_dir . $baseName;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $baseName;
    } else {
        return false;
    }
}

function addTask($title, $description, $deadline, $attachment, $status)
{
    global $conn;
    $user_id = $_SESSION['user']['id'];

    $title = cleanInput($title);
    $description = cleanInput($description);
    $deadline = $deadline;
    $attachment = saveFile($attachment);
    $status = cleanInput($status);

    if (!$attachment) {
        return false;
    }

    $sql = "INSERT INTO tasks (title, description, deadline, attachment, status, user_id) VALUES ('$title', '$description', '$deadline', '$attachment', '$status', $user_id)";

    return $conn->query($sql);
}

function updateTask($id, $title, $description, $deadline, $attachment, $status){
    global $conn;

    $sql = "SELECT attachment FROM tasks WHERE id = $id AND user_id = " . $_SESSION['user']['id'];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $file = $result->fetch_assoc()['attachment'];
    }

    $title = cleanInput($title);
    $description = cleanInput($description);
    $deadline = $deadline;
    //change deadline to format yyyy-mm-dd
    $deadline = date('Y-m-d', strtotime($deadline));
    $status = cleanInput($status);

    if ($attachment['name']) {
        $attachment = saveFile($attachment);
        deleteFile($file);
    } else {
        $attachment = $file;
    }

    $sql = "UPDATE tasks SET title = '$title', description = '$description', deadline = '$deadline', attachment = '$attachment', status = '$status' WHERE id = $id AND user_id = " . $_SESSION['user']['id'];
    return $conn->query($sql);
}