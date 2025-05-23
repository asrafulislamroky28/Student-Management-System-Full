<?php
session_start();
require 'db_connect.php';

// Ensure the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'] ?? 'Student';

// // Handle payment update if Pay Now is clicked
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
//     $update = $conn->prepare("UPDATE students SET status = 'paid' WHERE student_id = ?");
//     $update->bind_param("i", $student_id);
//     $update->execute();
// }

// Fetch payment info for this student
$stmt = $conn->prepare("SELECT class, due_ammount, status FROM students WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Status</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
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
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #34495e;
        }
        .info {
            font-size: 18px;
            margin: 20px 0;
        }
        .status {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }
        .Paid {
            background-color: #2ecc71;
            color: white;
        }
        .unpaid, .Unpaid {
            background-color: #e74c3c;
            color: white;
        }
        .pay-btn {
            margin-top: 30px;
        }
        button {
            padding: 12px 24px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background-color: #2980b9;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #2980b9;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="navbar">
        Student Panel
        <a href="student_dashboard.php">⬅ Back to Dashboard</a>
    </div>

    <div class="container">
        <h2>Payment Information</h2>
        <?php if ($payment): ?>
            <div class="info">
                <strong>Class:</strong> <?php echo htmlspecialchars($payment['class']); ?><br>
                <strong>Amount:</strong> ৳<?php echo number_format($payment['due_ammount'], 2); ?><br>
                <strong>Status:</strong>
                <span class="status <?php echo htmlspecialchars($payment['status']); ?>">
                    <?php echo htmlspecialchars($payment['status']); ?>
                </span>
            </div>

            <!-- <?php if (strtolower($payment['status']) === 'unpaid'): ?>
                <form method="POST" class="pay-btn">
                    <button type="submit" name="pay_now">💳 Pay Now</button>
                </form>
            <?php endif; ?> -->

            <?php if (strtolower($payment['status']) === 'paid'): ?>
                <button onclick="printPDF()">🧾 Download Receipt</button>
            <?php endif; ?>
        <?php endif; ?>

        <a class="back-link" href="student_dashboard.php">← Back to Dashboard</a>
    </div>

    <script>
    function printPDF() {
        const now = new Date();
        const formattedDate = now.toLocaleDateString();
        const formattedTime = now.toLocaleTimeString();

        const studentName = "<?php echo addslashes($student_name); ?>";
        const studentID = "<?php echo $student_id; ?>";
        const studentClass = "<?php echo addslashes($payment['class']); ?>";
        const paymentAmount = "<?php echo number_format($payment['due_ammount'], 2); ?>";

        const htmlContent = `
            <html>
            <head>
                <title>Payment Receipt</title>
                <style>
                    body {
                        font-family: 'Poppins', sans-serif;
                        padding: 40px;
                        color: #2c3e50;
                    }
                    h1 {
                        text-align: center;
                        color: #27ae60;
                        margin-bottom: 10px;
                    }
                    h3 {
                        text-align: center;
                        margin-top: 0;
                    }
                    .receipt-box {
                        max-width: 700px;
                        margin: auto;
                        border: 1px solid #ccc;
                        padding: 30px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    }
                    table {
                        width: 100%;
                        font-size: 16px;
                        margin-top: 20px;
                    }
                    table td {
                        padding: 8px 0;
                    }
                    .footer {
                        margin-top: 40px;
                        text-align: center;
                        font-size: 14px;
                        color: #888;
                    }
                    .status {
                        color: green;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class="receipt-box">
                    <h1>Payment Receipt</h1>
                    <h3>IUBAT Student Management System</h3>
                    <table>
                        <tr><td><strong>Student Name:</strong></td><td>${studentName}</td></tr>
                        <tr><td><strong>Student ID:</strong></td><td>${studentID}</td></tr>
                        <tr><td><strong>Class:</strong></td><td>${studentClass}</td></tr>
                        <tr><td><strong>Amount Paid:</strong></td><td>৳${paymentAmount}</td></tr>
                        <tr><td><strong>Status:</strong></td><td class="status">✅ Payment Completed</td></tr>
                        <tr><td><strong>Date:</strong></td><td>${formattedDate}</td></tr>
                        <tr><td><strong>Time:</strong></td><td>${formattedTime}</td></tr>
                    </table>
                    <div class="footer">
                        This is a system-generated receipt. No signature required.
                    </div>
                </div>
            </body>
            </html>
        `;

        const newWin = window.open('', '', 'width=800,height=700');
        newWin.document.write(htmlContent);
        newWin.document.close();
        newWin.focus();
        newWin.print();
    }
    </script>
</body>
</html>
