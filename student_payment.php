<?php
session_start();
require 'db_connect.php';

// Ensure the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Handle payment update if Pay Now is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
    $update = $conn->prepare("UPDATE payments SET status = 'Paid' WHERE student_id = ?");
    $update->bind_param("i", $student_id);
    $update->execute();
}

// Fetch payment info for this student
$stmt = $conn->prepare("SELECT class, amount, status FROM payments WHERE student_id = ?");
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
        .Unpaid {
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
                <strong>Amount:</strong> ৳<?php echo number_format($payment['amount'], 2); ?><br>
                <strong>Status:</strong>
                <span class="status <?php echo $payment['status']; ?>">
                    <?php echo $payment['status']; ?>
                </span>
            </div>

            <?php if ($payment['status'] !== 'Paid'): ?>
                <form method="POST">
                    <div class="pay-btn">
                        <button type="submit" name="pay_now">Pay Now</button>
                    </div>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <p>No payment record found for your account.</p>
        <?php endif; ?>

        <a class="back-link" href="student_dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
