<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user info
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Profile - SoundWave</title>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com"></script>
<style>
:root { --primary-color: #f9f506; }
body { font-family: 'Spline Sans', 'Noto Sans', sans-serif; }
</style>
</head>
<body class="bg-black text-white">

<header class="flex items-center justify-between px-10 py-4 border-b border-gray-800">
  <h1 class="font-bold text-xl text-[var(--primary-color)]">SoundWave</h1>
  <button onclick="window.location.href='dashboard.php'" class="text-white hover:underline">Back to Dashboard</button>
</header>

<main class="px-10 py-8 max-w-3xl mx-auto">
  <h2 class="text-3xl font-bold mb-6">Your Profile</h2>

  <div class="flex flex-col md:flex-row items-center gap-6 rounded-lg bg-gray-900 p-6">
    <div class="w-32 h-32 rounded-full bg-cover bg-center" style="background-image:url('<?php echo $user['avatar'] ?? 'https://via.placeholder.com/150'; ?>');"></div>
    
    <div class="flex-1 flex flex-col gap-2">
      <p class="text-2xl font-bold"><?php echo htmlspecialchars($user['name'] ?? $user['username']); ?></p>
      <p class="text-gray-400"><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
      <p class="text-gray-400"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
      <p class="text-gray-400"><strong>Country:</strong> <?php echo htmlspecialchars($user['country'] ?? 'Not set'); ?></p>
      <?php if(isset($user['is_premium'])): ?>
        <p class="text-[var(--primary-color)] font-semibold"><?php echo $user['is_premium'] ? "Premium Member" : "Free Member"; ?></p>
      <?php endif; ?>
      <div class="mt-4 flex gap-4">
        <a href="logout.php" class="text-red-500 font-bold hover:underline">Logout</a>
        <a href="dashboard.php" class="text-white font-bold hover:underline">Dashboard</a>
      </div>
    </div>
  </div>

</main>

</body>
</html>
