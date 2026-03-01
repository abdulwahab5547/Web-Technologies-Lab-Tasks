<?php
session_start();
require "functions.php";
$students = getStudents();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message'] ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h2>Student Portal</h2>

    <div class="button-group">
        <a href="create.php" class="btn">+ Create New Student</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['name'] ?></td>
                <td><?= $student['email'] ?></td>
                <td><?= $student['course'] ?></td>
                <td>
                    <div class="action-links">
                        <a href="edit.php?id=<?= $student['id'] ?>">Edit</a>
                        <a href="delete.php?id=<?= $student['id'] ?>"
                           onclick="return confirm('Delete this student?')">
                           Delete
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>