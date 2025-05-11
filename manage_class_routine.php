<?php
session_start();
require 'db_connect.php';

// Redirect if not logged in as admin
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all class routine records
$result = $conn->query("SELECT * FROM class_routine");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Class Routine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Manage Class Routine</h2>
    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">⬅ Back to Dashboard</a>
    <table class="table table-bordered bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Class</th>
                <th>Section</th>
                <th>Day</th>
                <th>Subject</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Room</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['class'] ?></td>
                <td><?= $row['section'] ?></td>
                <td><?= $row['day'] ?></td>
                <td><?= $row['subject'] ?></td>
                <td><?= $row['start_time'] ?></td>
                <td><?= $row['end_time'] ?></td>
                <td><?= $row['room'] ?></td>
                <td><a href="edit_class_routine.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
