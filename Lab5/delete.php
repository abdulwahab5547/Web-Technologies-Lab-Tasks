<?php
session_start();
require "functions.php";

if (isset($_GET['id'])) {
    deleteStudent($_GET['id']);
    $_SESSION['message'] = "Student deleted successfully!";
}

header("Location: index.php");
exit;