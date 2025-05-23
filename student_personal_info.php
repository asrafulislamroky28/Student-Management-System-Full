<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Personal Info</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            margin: 0; padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
        }

        .navbar {
            width: 100%;
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px 25px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
        }

        .navbar a {
            color: #ecf0f1;
            text-decoration: none;
            font-weight: 500;
        }

        .wrapper {
            display: flex;
            margin-top: 60px;
        }

        .sidebar {
            width: 240px;
            background-color: #34495e;
            padding: 25px 20px;
            height: calc(100vh - 55px);
            position: fixed;
            top: 55px;
            left: 0;
            overflow-y: auto;
            color: white;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #ecf0f1;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: #2c3e50;
        }

        .main {
            margin-left: 260px;
            padding: 30px;
            width: calc(100% - 260px);
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .header-print {
            text-align: center;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header-print small {
            color: #7f8c8d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        th {
            width: 30%;
            color: #7f8c8d;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .back-link {
            display: block;
            margin-top: 25px;
            text-align: center;
            text-decoration: none;
            color: #2980b9;
            font-weight: 500;
        }

        .download-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 25px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .download-btn:hover {
            background-color: #219150;
        }

        @media print {
            .navbar, .sidebar, .download-btn, .back-link {
                display: none !important;
            }

            .main {
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>📚 Student Panel</div>
    <a href="student_dashboard.php">⬅ Dashboard</a>
</div>

<div class="wrapper">
    <div class="sidebar">
        <ul>
            <li><a href="student_personal_info.php" class="active">📄 Personal Info</a></li>
            <li><a href="student_class_routine.php">📘 Class Routine</a></li>
            <li><a href="student_exam_routine.php">📝 Exam Routine</a></li>
            <li><a href="student_payment.php">💰 Payment</a></li>
            <li><a href="about.php">ℹ️ About</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="container" id="info-section">
            <div class="header-print">
                IUBAT – International University of Business Agriculture and Technology<br>
                <small>Personal Info • Generated on <?php echo date("F j, Y"); ?></small>
            </div>

            <h2>Personal Information</h2>

            <button class="download-btn" onclick="downloadPDF()">⬇ Download PDF</button>

            <table>
                <tr><th>Student ID</th><td><?php echo htmlspecialchars($student['student_id']); ?></td></tr>
                <tr><th>Name</th><td><?php echo htmlspecialchars($student['name']); ?></td></tr>
                <tr><th>Email</th><td><?php echo htmlspecialchars($student['email']); ?></td></tr>
                <tr><th>Class</th><td><?php echo htmlspecialchars($student['class']); ?></td></tr>
                <tr><th>Section</th><td><?php echo htmlspecialchars($student['section']); ?></td></tr>
                <tr><th>Gender</th><td><?php echo htmlspecialchars($student['gender']); ?></td></tr>
                <tr><th>Date of Birth</th><td><?php echo htmlspecialchars($student['date_of_birth']); ?></td></tr>
            </table>

            <a class="back-link" href="student_dashboard.php">← Back to Dashboard</a>
        </div>
    </div>
</div>

<script>
    function downloadPDF() {
        const section = document.getElementById('info-section');
        const btn = document.querySelector('.download-btn');
        const link = document.querySelector('.back-link');

        btn.style.display = 'none';
        link.style.display = 'none';

        const opt = {
            margin: 0.5,
            filename: 'personal_info.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(section).save().then(() => {
            btn.style.display = 'block';
            link.style.display = 'block';
        });
    }
</script>

</body>
</html>
