<?php
session_start();
require "functions.php";

if (isset($_POST['submit'])) {
    addStudent($_POST['name'], $_POST['email'], $_POST['course']);
    $_SESSION['message'] = "Student added successfully!";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Add New Student</h2>

    <form method="POST">
        <div class="form-group">
            <label for="name">Student Name</label>
            <input type="text" id="name" name="name" placeholder="Enter student name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter email address" required>
        </div>
        
        <div class="form-group">
            <label for="course">Course</label>
            <input type="text" id="course" name="course" placeholder="Enter course name" required>
        </div>
        
        <button type="submit" name="submit">Save Student</button>
    </form>

    <a href="index.php" class="btn back">← Back to Portal</a>
</div>

</body>
</html>