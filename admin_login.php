<?php
session_start();
require 'db_connect.php';

$errors = [];
$message = "Welcome to the Admin Login Page"; // Define the message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch admin details from the database
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            // Set session variables upon successful login
            $_SESSION['admin_logged_in'] = true;  // Set login status
            $_SESSION['admin_username'] = $admin['username']; // Store username
            
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $errors[] = "Incorrect password!";
        }
    } else {
        $errors[] = "No such admin found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
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
        .login-form {
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
        .message {
            text-align: center;
            margin-top: 20px;
        }
        .message a {
            color: #3498db;
            text-decoration: none;
        }
        .message a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form class="login-form" method="POST">
        <h2>Admin Login</h2>

        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
        }
        ?>

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <div class="message">
        <p><?php echo $message; ?></p>
        <a href="student_signup.php">Don't have an account? Sign up</a><br>
        <a href="student_login.php">Already registered? Login for student</a>
    </div>
    </form>
</body>
</html>
