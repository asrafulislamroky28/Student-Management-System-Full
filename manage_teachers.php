<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

require 'db_connect.php';

// Fetch the list of teachers from the database
$teachers_result = $conn->query("SELECT * FROM teachers");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }

        .sidebar {
            height: 100vh;
            background-color: #2c3e50;
            padding: 30px 20px;
            color: white;
            position: fixed;
            width: 250px;
        }

        .sidebar h4 {
            margin-bottom: 40px;
            font-weight: 600;
        }

        .sidebar a {
            color: #ecf0f1;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #34495e;
            text-decoration: none;
        }

        .content {
            margin-left: 270px;
            padding: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .header-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header-buttons .btn {
            margin-left: 10px;
        }

    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>🎓 Admin Panel</h4>
    <a href="admin_dashboard.php"><i class="fas fa-home me-2"></i>Dashboard</a>
    <a href="manage_students.php"><i class="fas fa-user-graduate me-2"></i>Manage Students</a>
    <a href="manage_teachers.php"><i class="fas fa-chalkboard-teacher me-2"></i>Manage Teachers</a>
    <a href="manage_exam_routine.php"><i class="fas fa-calendar-alt me-2"></i>Manage Exam Routine</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
</div>

<!-- Content -->
<div class="content">
    <div class="mb-5">
        <h2 class="fw-bold">Manage Teachers</h2>
        <p class="text-muted">Here’s a list of all the teachers in the system.</p>
    </div>

    <!-- Header buttons for Add Teacher and PDF Download -->
    <div class="header-buttons">
        <a href="add_teacher.php" class="btn btn-success"><i class="fas fa-plus-circle me-2"></i>Add Teacher</a>
        <a href="generate_teacher_pdf.php" class="btn btn-danger"><i class="fas fa-file-pdf me-2"></i>Download PDF</a>
    </div>

    <!-- Teachers Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($teachers_result->num_rows > 0) {
                while ($teacher = $teachers_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $teacher['id'] . "</td>";
                    echo "<td>" . $teacher['name'] . "</td>";
                    echo "<td>" . $teacher['email'] . "</td>";
                    echo "<td><a href='edit_teacher.php?id=" . $teacher['id'] . "' class='btn btn-primary'>Edit</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No teachers found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
