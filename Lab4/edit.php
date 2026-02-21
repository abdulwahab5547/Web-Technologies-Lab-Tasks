<?php
require_once 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$pdo = getPDO();
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    header('Location: index.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first  = trim($_POST['first_name'] ?? '');
    $last   = trim($_POST['last_name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $dob    = trim($_POST['dob'] ?? null);
    $course = trim($_POST['course'] ?? '');

    if ($first === '' || $last === '') $errors[] = 'First and last name are required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';

    if (empty($errors)) {
        try {
            $upd = $pdo->prepare('UPDATE students SET first_name=?, last_name=?, email=?, dob=?, course=? WHERE id=?');
            $upd->execute([$first, $last, $email, $dob, $course, $id]);
            header('Location: index.php?msg=updated');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Update failed: " . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit Profile | <?php echo htmlspecialchars($student['first_name']); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<nav class="navbar">
    <div class="container nav-content">
        <span class="brand">Student<strong>Records</strong></span>
        <div class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="create.php">Add New</a>
        </div>
    </div>
</nav>

<main class="container">
    <div class="form-wrapper">
        <div class="form-card">
            <div class="form-header">
                <h2>Edit Student Profile</h2>
                <p>Modify the information for <strong><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></strong>.</p>
            </div>

            <?php if ($errors): ?>
                <div class="error-box">
                    <ul>
                        <?php foreach ($errors as $e) echo '<li>' . htmlspecialchars($e) . '</li>'; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" class="styled-form">
                <div class="form-row">
                    <div class="input-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" 
                               value="<?php echo htmlspecialchars($_POST['first_name'] ?? $student['first_name']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" 
                               value="<?php echo htmlspecialchars($_POST['last_name'] ?? $student['last_name']); ?>">
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? $student['email']); ?>">
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" 
                               value="<?php echo htmlspecialchars($_POST['dob'] ?? $student['dob']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="course">Assigned Course</label>
                        <input type="text" id="course" name="course" 
                               value="<?php echo htmlspecialchars($_POST['course'] ?? $student['course']); ?>">
                    </div>
                </div>

                <div class="form-footer">
                    <a href="index.php" class="btn-secondary">Back to List</a>
                    <button type="submit" class="btn-primary">Update Records</button>
                </div>
            </form>
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