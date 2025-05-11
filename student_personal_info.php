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
    <title>Personal Information</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f0f4f8;
        }
        .navbar {
            background: #2c3e50;
            color: white;
            padding: 15px 25px;
            font-size: 18px;
        }
        .navbar a {
            float: right;
            color: white;
            text-decoration: none;
            font-weight: 500;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #34495e;
        }
        .header-print {
            text-align: center;
            margin-bottom: 10px;
        }
        .header-print small {
            color: #555;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
        }
        th {
            color: #888;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #2980b9;
            font-weight: 500;
        }
        button.download-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
        }

        @media print {
            .download-btn, .back-link, .navbar {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        Student Panel
        <a href="student_dashboard.php">⬅ Back to Dashboard</a>
    </div>

    <div class="container" id="info-section">
        <div class="header-print">
            <strong>IUBAT – International University of Business Agriculture and Technology</strong><br>
            <small>Personal Info • Generated on <?php echo date("F j, Y"); ?></small>
        </div>

        <h2>Personal Information</h2>

        <button class="download-btn" onclick="downloadPDF()">⬇ Download PDF</button>

        <table>
            <tr>
                <th>Student ID</th>
                <td><?php echo htmlspecialchars($student['student_id']); ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($student['name']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($student['email']); ?></td>
            </tr>
            <tr>
                <th>Class</th>
                <td><?php echo htmlspecialchars($student['class']); ?></td>
            </tr>
            <tr>
                <th>Section</th>
                <td><?php echo htmlspecialchars($student['section']); ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo htmlspecialchars($student['gender']); ?></td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td><?php echo htmlspecialchars($student['date_of_birth']); ?></td>
            </tr>
        </table>

        <a class="back-link" href="student_dashboard.php">← Back to Dashboard</a>
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
