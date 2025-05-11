<?php
require 'db_connect.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['student_id']);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $class = $_POST['class'];
    $section = $_POST['section'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    $check = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $check->bind_param("i", $student_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $message = "Student ID already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO students (student_id, name, email, password, class, section, gender, date_of_birth) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $student_id, $name, $email, $password, $class, $section, $gender, $dob);
        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 450px;
            background: white;
            padding: 30px;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        input[type=submit] {
            background: #4CAF50;
            color: white;
            border: none;
            font-weight: 500;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background: #45a049;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Sign Up</h2>
    <form method="POST">
        <label>Student ID</label>
        <input type="number" name="student_id" required>

        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email">

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Class</label>
        <input type="text" name="class">

        <label>Section</label>
        <input type="text" name="section">

        <label>Gender</label>
        <select name="gender">
            <option>Male</option>
            <option>Female</option>
        </select>

        <label>Date of Birth</label>
        <input type="date" name="dob">

        <input type="submit" value="Sign Up">
    </form>
    <div class="message"><?php echo $message; ?></div>
    <a href="student_login.php">Already registered? Login for student</a>
    <a href="admin_login.php">Already registered? Login for admin</a>
</div>
</body>
</html>
