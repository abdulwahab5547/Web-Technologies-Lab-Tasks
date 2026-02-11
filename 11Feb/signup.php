<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST["name"];
    $email    = $_POST["email"];
    $password = $_POST["password"];

    // Check if user already exists
    if (file_exists("users.txt")) {
        $lines = file("users.txt");
        foreach ($lines as $line) {
            $data = explode("|", trim($line));
            if ($data[1] == $email) {
                $error = "This email is already registered!";
            }
        }
    }

    if ($error == "") {
        // Save user to file
        $user = $name . "|" . $email . "|" . $password . "\n";
        file_put_contents("users.txt", $user, FILE_APPEND);
        header("Location: login.php?success=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50 h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border-b-4 border-emerald-600">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-emerald-900">Create Account</h1>
            <p class="text-emerald-600 mt-2">Join us and get started today</p>
        </div>

        <?php if (isset($error) && $error != "") { ?>
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 border border-red-100 text-sm font-medium">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST" action="signup.php" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-emerald-900 mb-1">Full Name</label>
                <input type="text" name="name" required placeholder="Enter your name"
                    class="w-full p-3 border border-emerald-100 rounded-xl bg-emerald-50/30 focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-emerald-900 mb-1">Email Address</label>
                <input type="email" name="email" required placeholder="email@example.com"
                    class="w-full p-3 border border-emerald-100 rounded-xl bg-emerald-50/30 focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-emerald-900 mb-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full p-3 border border-emerald-100 rounded-xl bg-emerald-50/30 focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition shadow-sm">
            </div>

            <button type="submit" 
                class="w-full bg-emerald-600 text-white py-3 mt-2 rounded-xl font-bold text-lg hover:bg-emerald-700 shadow-md hover:shadow-emerald-200 transition-all active:scale-[0.98]">
                Sign Up
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-emerald-50 text-center">
            <p class="text-gray-500 text-sm">
                Already have an account? 
                <a href="login.php" class="text-emerald-600 font-bold hover:text-emerald-700 underline underline-offset-4">Login</a>
            </p>
        </div>
    </div>

</body>
</html>