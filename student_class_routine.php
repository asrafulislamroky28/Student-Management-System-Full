<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$stmt = $conn->prepare("SELECT class, section FROM students WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$class = $student['class'];
$section = $student['section'];

$routine_stmt = $conn->prepare("SELECT * FROM class_routine WHERE class = ? AND section = ? ORDER BY FIELD(day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), start_time");
$routine_stmt->bind_param("ss", $class, $section);
$routine_stmt->execute();
$routine_result = $routine_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Class Routine</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
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
            max-width: 850px;
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
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #ecf0f1;
            color: #333;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-data {
            text-align: center;
            color: #888;
            padding: 20px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #2980b9;
            font-weight: 500;
        }

        /* Hide these during printing/PDF generation */
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

    <div class="container" id="routine-section">
        <div class="header-print">
           <strong>IUBAT – International University of Business Agriculture and Technology</strong><br>
            <small>Class Routine • Generated on <?php echo date("F j, Y"); ?></small>
        </div>

        <h2>Class <?php echo htmlspecialchars($class); ?> (Section <?php echo htmlspecialchars($section); ?>)</h2>

        <button class="download-btn" onclick="downloadPDF()">⬇ Download PDF</button>

        <?php if ($routine_result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Day</th>
                <th>Subject</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Room</th>
            </tr>
            <?php while ($row = $routine_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['day']); ?></td>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo date("g:i A", strtotime($row['start_time'])); ?></td>
                    <td><?php echo date("g:i A", strtotime($row['end_time'])); ?></td>
                    <td><?php echo htmlspecialchars($row['room']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <div class="no-data">No class routine found for your class and section.</div>
        <?php endif; ?>

        <a class="back-link" href="student_dashboard.php">← Back to Dashboard</a>
    </div>

    <script>
        function downloadPDF() {
            const section = document.getElementById('routine-section');
            const btn = document.querySelector('.download-btn');
            const link = document.querySelector('.back-link');

            // Hide UI elements
            btn.style.display = 'none';
            link.style.display = 'none';

            const opt = {
                margin: 0.5,
                filename: 'class_routine.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(section).save().then(() => {
                // Show UI elements again
                btn.style.display = 'block';
                link.style.display = 'block';
            });
        }
    </script>
</body>
</html>
