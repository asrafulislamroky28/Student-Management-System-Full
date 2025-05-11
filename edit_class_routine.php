<?php
require 'db_connect.php';
$id = $_GET['id'];

// Fetch record
$result = $conn->query("SELECT * FROM class_routine WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class = $_POST['class'];
    $section = $_POST['section'];
    $day = $_POST['day'];
    $subject = $_POST['subject'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $room = $_POST['room'];

    $conn->query("UPDATE class_routine SET class='$class', section='$section', day='$day', subject='$subject', start_time='$start_time', end_time='$end_time', room='$room' WHERE id=$id");
    header("Location: manage_class_routine.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Class Routine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Edit Class Routine</h3>
    <form method="POST">
        <div class="mb-2"><input type="text" name="class" value="<?= $row['class'] ?>" class="form-control" required></div>
        <div class="mb-2"><input type="text" name="section" value="<?= $row['section'] ?>" class="form-control" required></div>
        <div class="mb-2"><input type="text" name="day" value="<?= $row['day'] ?>" class="form-control" required></div>
        <div class="mb-2"><input type="text" name="subject" value="<?= $row['subject'] ?>" class="form-control" required></div>
        <div class="mb-2"><input type="time" name="start_time" value="<?= $row['start_time'] ?>" class="form-control" required></div>
        <div class="mb-2"><input type="time" name="end_time" value="<?= $row['end_time'] ?>" class="form-control" required></div>
        <div class="mb-2"><input type="text" name="room" value="<?= $row['room'] ?>" class="form-control" required></div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="manage_class_routine.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
