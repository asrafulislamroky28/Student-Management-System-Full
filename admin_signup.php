<?php
session_start();
require 'db_connect.php'; // make sure this connects correctly

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_POST['admin_id'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $check = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    if ($check) {
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Username already exists!";
        } else {
            // Insert admin record
            $stmt = $conn->prepare("INSERT INTO admins (admin_id, username, password) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sss", $admin_id, $username, $password);
                if ($stmt->execute()) {
                    $_SESSION['admin_username'] = $username;
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    $errors[] = "Failed to register admin. Try again.";
                }
            } else {
                $errors[] = "Insert statement preparation failed: " . $conn->error;
            }
        }
    } else {
        $errors[] = "Check statement preparation failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .signup-form {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <form class="signup-form" method="POST">
        <h2>Admin Signup</h2>

        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
        }
        ?>

        <input type="text" name="admin_id" placeholder="Admin ID (e.g., admin123)" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
