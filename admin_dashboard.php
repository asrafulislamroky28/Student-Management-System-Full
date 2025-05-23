<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

// Get total students
$total_students_result = $conn->query("SELECT COUNT(*) FROM students");
$total_students = ($total_students_result && $row = $total_students_result->fetch_row()) ? $row[0] : 0;

// Get total teachers
$total_teachers_result = $conn->query("SELECT COUNT(*) FROM teachers");
$total_teachers = ($total_teachers_result && $row = $total_teachers_result->fetch_row()) ? $row[0] : 0;

// Get total payments
$payment_result = $conn->query("SELECT SUM(due_ammount) FROM students WHERE status='paid'");
$total_payments = ($payment_result && $row = $payment_result->fetch_row()) ? ($row[0] ?? 0.00) : 0.00;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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

        .stat-card {
            border-radius: 12px;
            padding: 25px;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            font-size: 35px;
            opacity: 0.7;
        }

        .bg-student { background: linear-gradient(135deg, #2980b9, #3498db); }
        .bg-teacher { background: linear-gradient(135deg, #27ae60, #2ecc71); }
        .bg-payment { background: linear-gradient(135deg, #f39c12, #f1c40f); }

        .stat-text h5 {
            margin: 0;
            font-size: 18px;
        }

        .stat-text h2 {
            margin: 0;
            font-size: 30px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>🎓 Admin Panel</h4>
    <a href="manage_students.php"><i class="fas fa-user-graduate me-2"></i>Manage Students</a>
    <a href="manage_teachers.php"><i class="fas fa-chalkboard-teacher me-2"></i>Manage Teachers</a>
    <a href="manage_class_routine.php"><i class="fas fa-calendar-alt me-2"></i>Manage Class Routine</a>
    <a href="manage_exam_routine.php"><i class="fas fa-calendar-alt me-2"></i>Manage Exam Routine</a>
    <a href="admin_manage_payments.php"><i class="fas fa-money-check-alt me-2"></i>Manage Payment</a>
    <a href="about.php"><i class="fas fa-info-circle me-2"></i>About</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
</div>

<div class="content">
    <div class="mb-5">
        <h2 class="fw-bold">Welcome, <?= htmlspecialchars($_SESSION['admin_username']); ?> 👋</h2>
        <p class="text-muted">Here’s a quick overview of the system status.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card bg-student">
                <i class="fas fa-user-graduate stat-icon"></i>
                <div class="stat-text">
                    <h5>Total Students</h5>
                    <h2><?= $total_students; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-teacher">
                <i class="fas fa-chalkboard-teacher stat-icon"></i>
                <div class="stat-text">
                    <h5>Total Teachers</h5>
                    <h2><?= $total_teachers; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-payment">
                <i class="fas fa-money-bill-wave stat-icon"></i>
                <div class="stat-text">
                    <h5>Total Payments Received</h5>
                    <h2>৳ <?= number_format($total_payments, 2); ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
