<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50 h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-lg border-b-4 border-emerald-600">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">Dashboard</h1>
                <p class="text-emerald-600">Account Overview</p>
            </div>
            <div class="h-12 w-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-bold text-xl">
                <?php echo strtoupper(substr($_SESSION["user"], 0, 1)); ?>
            </div>
        </div>

        <div class="bg-emerald-50/50 rounded-2xl p-6 border border-emerald-100 mb-8">
            <div class="space-y-4">
                <div class="flex justify-between items-center border-b border-emerald-100 pb-3">
                    <span class="text-emerald-800 font-semibold">Username</span>
                    <span class="text-gray-700"><?php echo htmlspecialchars($_SESSION["user"]); ?></span>
                </div>
                <div class="flex justify-between items-center pt-1">
                    <span class="text-emerald-800 font-semibold">Email Address</span>
                    <span class="text-gray-700"><?php echo htmlspecialchars($_SESSION["email"]); ?></span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <!-- <button class="flex-1 bg-emerald-600 text-white py-3 rounded-xl font-bold hover:bg-emerald-700 transition shadow-md">
                Edit Profile
            </button> -->
            <a href="logout.php" class="flex-1">
                <button class="w-full bg-white text-red-600 border-2 border-red-100 py-3 rounded-xl font-bold hover:bg-red-50 transition">
                    Logout
                </button>
            </a>
        </div>
    </div>

</body>
</html>