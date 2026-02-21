<?php
require_once 'db.php';

$pdo = getPDO();
$stmt = $pdo->query('SELECT * FROM students ORDER BY id DESC');
$students = $stmt->fetchAll();

// Check for success messages from edit.php or delete.php
$message = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'updated') $message = "Student record updated successfully!";
    if ($_GET['msg'] === 'deleted') $message = "Student has been removed.";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard | Student Records</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<nav class="navbar">
    <div class="container nav-content">
        <span class="brand">Student<strong>Records</strong></span>
        <div class="nav-links">
            <a href="index.php" class="active">Dashboard</a>
            <a href="create.php">Add New</a>
        </div>
    </div>
</nav>

<main class="container">
    <div class="list-wrapper">
        
        <div class="list-header">
            <div>
                <h2>Student Directory</h2>
                <p>Manage and monitor all registered students.</p>
            </div>
            <a href="create.php" class="btn-primary">Enroll New Student</a>
        </div>

        <?php if ($message): ?>
            <div class="success-toast"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="table-container">
            <?php if (count($students) === 0): ?>
                <div class="empty-state">
                    <p>No students found in the database.</p>
                    <a href="create.php" class="btn-secondary">Add your first student</a>
                </div>
            <?php else: ?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Email Address</th>
                            <th>Course</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $s): ?>
                            <tr>
                                <td class="id-col">#<?php echo $s['id']; ?></td>
                                <td class="name-col">
                                    <strong><?php echo htmlspecialchars($s['first_name'] . ' ' . $s['last_name']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($s['email']); ?></td>
                                <td><span class="badge"><?php echo htmlspecialchars($s['course'] ?: 'Unassigned'); ?></span></td>
                                <td class="text-right">
                                    <div class="action-group">
                                        <a class="action-btn edit" href="edit.php?id=<?php echo $s['id']; ?>">Edit</a>
                                        <a class="action-btn delete" href="delete.php?id=<?php echo $s['id']; ?>" 
                                           onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>

<footer class="main-footer">
    <div class="container">
        &copy; <?php echo date('Y'); ?> • Student Management System
    </div>
</footer>

</body>
</html>