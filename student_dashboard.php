<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            transition: margin-left 0.3s ease;
        }

        .menu-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 30px;
            height: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
            z-index: 1100;
        }

        .menu-toggle .bar {
            height: 4px;
            width: 100%;
            background-color: #2c3e50;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .menu-toggle:hover .bar {
            background-color: #1abc9c;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            background-color: #2c3e50;
            position: fixed;
            top: 0;
            left: -250px;
            padding-top: 60px;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 25px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            display: block;
            transition: background 0.3s ease;
        }

        .sidebar ul li a:hover {
            background-color: #1abc9c;
            border-radius: 5px;
        }

        .dashboard {
            max-width: 900px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .dashboard h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #34495e;
        }

        .logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <div class="menu-toggle" onclick="toggleSidebar()">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>

    <div class="sidebar" id="sidebar">
        <h2>📚 Dashboard</h2>
        <ul>
            <li><a href="student_personal_info.php">📄 Personal Information</a></li>
            <li><a href="student_class_routine.php">📘 Class Routine</a></li>
            <li><a href="student_exam_routine.php">📝 Exam Routine</a></li>
            <li><a href="student_payment.php">💰 Payment Details</a></li>
            <li><a href="about.php">ℹ️ About</a></li>
        </ul>
    </div>

    <a class="logout-btn" href="logout.php">Logout</a>

    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h2>
        <p style="text-align:center; color:#666;">Use the sidebar menu to navigate your student services.</p>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>

</body>
</html>
