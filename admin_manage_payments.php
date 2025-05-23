<?php
session_start();
require 'db_connect.php';

// Admin session check
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

// Handle payment status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_payment'])) {
    $student_id = $_POST['student_id'];
    $new_status = $_POST['new_status'];
    
    $stmt = $conn->prepare("UPDATE students SET status = ? WHERE student_id = ?");
    $stmt->bind_param("si", $new_status, $student_id);
    $stmt->execute();
}

// Handle amount update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_amount'])) {
    $student_id = $_POST['student_id'];
    $new_amount = $_POST['new_amount'];

    // Prepare SQL to update the payment amount
    $stmt = $conn->prepare("UPDATE payments SET amount = ? WHERE student_id = ?");
    $stmt->bind_param("di", $new_amount, $student_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Amount updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating amount.');</script>";
    }
}

// Fetch all payments
$sql = "SELECT s.student_id, s.name, s.class, s.due_ammount, s.status
        FROM students s
        LEFT JOIN payments p ON s.student_id = p.student_id
        ORDER BY s.class, s.student_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: #f4f6f9;
        }
        .navbar {
            background: #2c3e50;
            color: white;
            padding: 15px 25px;
            font-size: 20px;
        }
        .navbar a {
            float: right;
            color: white;
            text-decoration: none;
            font-weight: 500;
        }
        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.08);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px 14px;
            text-align: center;
        }
        table th {
            background-color: #34495e;
            color: white;
        }
        .status-paid {
            background-color: #2ecc71;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
        }
        .status-unpaid {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
        }
        button {
            padding: 8px 14px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-paid {
            background-color: #27ae60;
            color: white;
        }
        .btn-unpaid {
            background-color: #c0392b;
            color: white;
        }
        .btn-pdf {
            background-color: #2980b9;
            color: white;
            margin-bottom: 15px;
            float: right;
        }
        .btn-edit {
            background-color: #f39c12;
            color: white;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
        }
        .modal-content input {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        Admin Panel - Manage Payments
        <a href="admin_dashboard.php">⬅ Back to Dashboard</a>
    </div>

    <div class="container">
        <h2>All Student Payment Records</h2>
        <button class="btn-pdf" onclick="downloadPDF()">📄 Export PDF</button>

        <table id="paymentTable">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Amount (৳)</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['class']); ?></td>
                        <td><?php echo number_format($row['due_ammount'], 2); ?></td>
                        <td>
                            <span class="<?php echo $row['status'] === 'paid' ? 'status-paid' : 'status-unpaid'; ?>">
                                <?php echo $row['status'] ?? 'Unpaid'; ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                                <input type="hidden" name="new_status" value="<?php echo $row['status'] === 'paid' ? 'unpaid' : 'paid'; ?>">
                                <button type="submit" name="update_payment" class="<?php echo $row['status'] === 'Paid' ? 'btn-unpaid' : 'btn-paid'; ?>">
                                    Mark as <?php echo $row['status'] === 'paid' ? 'unpaid' : 'paid'; ?>
                                </button>
                            </form>
                            <button class="btn-edit" onclick="openEditModal(<?php echo $row['student_id']; ?>, <?php echo $row['amount']; ?>)">Edit Amount</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Amount Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3>Edit Payment Amount</h3>
            <form method="POST">
                <input type="hidden" name="student_id" id="student_id">
                <input type="number" name="new_amount" id="new_amount" placeholder="Enter new amount" required>
                <button type="submit" name="update_amount" class="btn-paid">Update Amount</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
    function openEditModal(studentId, currentAmount) {
        document.getElementById("student_id").value = studentId;
        document.getElementById("new_amount").value = currentAmount;
        document.getElementById("editModal").style.display = "flex";
    }

    function closeEditModal() {
        document.getElementById("editModal").style.display = "none";
    }

    function downloadPDF() {
        const table = document.getElementById("paymentTable").cloneNode(true);

        // Remove last column (action buttons)
        for (let row of table.rows) {
            row.deleteCell(-1);
        }

        const win = window.open('', '', 'width=900,height=700');
        win.document.write(`
            <html>
            <head>
                <title>Payment Report</title>
                <style>
                    body { font-family: 'Poppins', sans-serif; padding: 20px; }
                    h2 { text-align: center; color: #2c3e50; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: center; }
                    th { background-color: #2c3e50; color: white; }
                    .status-paid { background-color: #2ecc71; color: white; }
                    .status-unpaid { background-color: #e74c3c; color: white; }
                </style>
            </head>
            <body>
                <h2>Student Payment Report</h2>
                ${table.outerHTML}
                <p style="text-align:center; margin-top:40px;">Generated on ${new Date().toLocaleString()}</p>
            </body>
            </html>
        `);
        win.document.close();
        win.focus();
        win.print();
    }
    </script>
</body>
</html>
