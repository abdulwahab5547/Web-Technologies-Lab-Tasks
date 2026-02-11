<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST["name"];
    $email   = $_POST["email"];
    $message = $_POST["message"];

    echo "<h2>Form Submitted Successfully! ✅</h2>";
    echo "<p><b>Name:</b> $name</p>";
    echo "<p><b>Email:</b> $email</p>";
    echo "<p><b>Message:</b> $message</p>";
    echo '<br><a href="index.php">Go Back to Form</a>';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Form</title>
</head>
<body>
    <h1>Contact Form</h1>

    <form method="POST" action="index.php">
        <label>Name:</label><br>
        <input type="text" name="name"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>Message:</label><br>
        <textarea name="message"></textarea><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
