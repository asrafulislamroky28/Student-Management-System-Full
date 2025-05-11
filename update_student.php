<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $class = $_POST['class'];

    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, class=? WHERE student_id=?");
    $stmt->bind_param("sssi", $name, $email, $class, $id);
    $stmt->execute();

    header("Location: manage_students.php");
    exit();
}
?>
