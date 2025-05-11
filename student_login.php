<?php
require 'db_connect.php';
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['student_id']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['student_id'] = $student_id;
            $_SESSION['name'] = $row['name'];
            header("Location: student_dashboard.php");
            exit();
        } else {
            $message = "Incorrect password!";
        }
    } else {
        $message = "Student ID not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #e0f7fa;
            margin: 0;
        }
        .container {
            width: 400px;
            background: white;
            padding: 30px;
            margin: 70px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        input[type=submit] {
            background: #2196F3;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background: #1976D2;
        }
        .message {
            text-align: center;
            color: red;
        }
        a {
            display: block;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            margin-top: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Login</h2>
    <form method="POST">
        <label>Student ID</label>
        <input type="number" name="student_id" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <input type="submit" value="Login">
    </form>
    <div class="message"><?php echo $message; ?></div>
    <a href="student_signup.php">Don't have an account? Sign up</a> <a href="admin_login.php">Already registered? Login admin</a>
</div>
</body>
</html>
