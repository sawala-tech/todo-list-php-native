<?php
session_start();

//DB Connection
$host = "localhost";
$username = "root";
$password = "";
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
    if (file_exists($file)) {
        unlink($file);
    }
}

function deleteTask($id)
{
    global $conn;
    //get the attachment file path
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

    //i want new name for the file so i will use time() function
    $target_file = $target_dir . basename(time() . "_" . $file['name']);

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $target_file;
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
    $deadline = cleanInput($deadline);
    $attachment = saveFile($attachment);
    $status = cleanInput($status);

    if (!$attachment) {
        return false;
    }

    $sql = "INSERT INTO tasks (title, description, deadline, attachment, status, user_id) VALUES ('$title', '$description', '$deadline', '$attachment', '$status', $user_id)";

    return $conn->query($sql);
}
