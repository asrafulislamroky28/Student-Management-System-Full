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
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        .modal input {
            margin-bottom: 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <h3 class="mb-4">Manage Students</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
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
                        <button class="btn btn-primary btn-sm editBtn" 
                            data-id="<?= $row['student_id']; ?>" 
                            data-name="<?= $row['name']; ?>" 
                            data-email="<?= $row['email']; ?>" 
                            data-class="<?= $row['class']; ?>">
                            Edit
                        </button>
                        <a href="delete_student.php?id=<?= $row['student_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this student?')">Delete</a>
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
