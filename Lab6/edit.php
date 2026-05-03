<?php
require "functions.php";

$id = $_GET['id'];
$students = getStudents();
$currentStudent = null;

foreach ($students as $student) {
    if ($student['id'] == $id) {
        $currentStudent = $student;
        break;
    }
}

if (isset($_POST['submit'])) {
    updateStudent($id, $_POST['name'], $_POST['email'], $_POST['course']);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Edit Student</h2>

    <form method="POST">
        <div class="form-group">
            <label for="name">Student Name</label>
            <input type="text" id="name" name="name" value="<?= $currentStudent['name'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?= $currentStudent['email'] ?>" required>
        </div>
        
        <div class="form-group">
            <label for="course">Course</label>
            <input type="text" id="course" name="course" value="<?= $currentStudent['course'] ?>" required>
        </div>
        
        <button type="submit" name="submit">Update Student</button>
    </form>

    <a href="index.php" class="btn back">← Back to Portal</a>
</div>

</body>
</html>