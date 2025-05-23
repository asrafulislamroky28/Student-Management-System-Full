<?php
require 'db_connect.php';

// Handle course assignment
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_name = $_POST['course_name'];
    $teacher_id = $_POST['teacher_id'];

    $stmt = $conn->prepare("INSERT INTO courses (course_name, teacher_id) VALUES (?, ?)");
    $stmt->bind_param("si", $course_name, $teacher_id);
    $stmt->execute();
    $success = "✅ Course assigned successfully!";
}

// Fetch all teachers for the dropdown
$teachers = $conn->query("SELECT id, name FROM teachers");

// Fetch all courses with teacher names
$courses = $conn->query("
    SELECT c.course_id, c.course_name, t.name
    FROM courses c
    JOIN teachers t ON c.teacher_id = t.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Course to Teacher</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
        .container { background: white; padding: 25px; max-width: 700px; margin: auto; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; }
        label { margin-top: 15px; display: block; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; }
        input[type=submit] { margin-top: 20px; background: green; color: white; border: none; cursor: pointer; }
        input[type=submit]:hover { background: darkgreen; }
        .success { margin-top: 15px; background: #d4edda; padding: 10px; color: #155724; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: center; }
        th { background: #007bff; color: white; }
    </style>
</head>
<body>
<div class="container">
    <h2>Assign Course</h2>

    <?php if (!empty($success)) echo "<div class='success'>$success</div>"; ?>

    <form method="POST">
        <label>Course Name</label>
        <input type="text" name="course_name" required>

        <label>Assign Teacher</label>
        <select name="teacher_id" required>
            <option value="">-- Select Teacher --</option>
            <?php while ($row = $teachers->fetch_assoc()): ?>
                <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Assign Course">
    </form>

    <!-- <?php if ($courses->num_rows > 0): ?>
        <h3>Assigned Courses</h3>
        <table>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Teacher Name</th>
            </tr>
            <?php while ($row = $courses->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['course_id']; ?></td>
                    <td><?= $row['course_name']; ?></td>
                    <td><?= $row['name']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?> -->
</div>
</body>
</html>
