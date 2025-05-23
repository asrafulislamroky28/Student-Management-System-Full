<?php
session_start();
require 'db_connect.php';

// Fetch all students
$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            background-color: #2c3e50;
            padding: 30px 20px;
            color: white;
            position: fixed;
            width: 250px;
        }

        .sidebar h4 {
            margin-bottom: 40px;
            font-weight: 600;
        }

        .sidebar a {
            color: #ecf0f1;
            display: block;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .content {
            margin-left: 270px;
            padding: 40px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            padding: 20px;
            background: white;
        }

        .table thead {
            background-color: #343a40;
            color: white;
        }

        .modal input {
            margin-bottom: 12px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>🎓 Admin Panel</h4>
    <a href="manage_students.php"><i class="fas fa-user-graduate me-2"></i>Manage Students</a>
    <a href="manage_teachers.php"><i class="fas fa-chalkboard-teacher me-2"></i>Manage Teachers</a>
    <a href="manage_class_routine.php"><i class="fas fa-calendar-alt me-2"></i>Manage Class Routine</a>
    <a href="manage_exam_routine.php"><i class="fas fa-calendar-alt me-2"></i>Manage Exam Routine</a>
    <a href="admin_manage_payments.php"><i class="fas fa-money-check-alt me-2"></i>Manage Payment</a>
    <a href="about.php"><i class="fas fa-info-circle me-2"></i>About</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
</div>

<div class="content">
    <div class="card">
        <h3 class="mb-4">Manage Students</h3>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['student_id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['class']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary editBtn" 
                                    data-id="<?= $row['student_id']; ?>" 
                                    data-name="<?= $row['name']; ?>" 
                                    data-email="<?= $row['email']; ?>" 
                                    data-class="<?= $row['class']; ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="delete_student.php?id=<?= $row['student_id']; ?>" 
                               class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Are you sure to delete this student?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="update_student.php">
      <div class="modal-header">
        <h5 class="modal-title">Edit Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="student_id" id="edit_id">
        <input type="text" name="name" id="edit_name" class="form-control" placeholder="Name" required>
        <input type="email" name="email" id="edit_email" class="form-control" placeholder="Email" required>
        <input type="text" name="class" id="edit_class" class="form-control" placeholder="Class" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save Changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const editBtns = document.querySelectorAll('.editBtn');
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('edit_id').value = btn.dataset.id;
            document.getElementById('edit_name').value = btn.dataset.name;
            document.getElementById('edit_email').value = btn.dataset.email;
            document.getElementById('edit_class').value = btn.dataset.class;
            editModal.show();
        });
    });
</script>

</body>
</html>
