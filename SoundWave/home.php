<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>SoundWave - Home</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
:root { --primary-color: #f9f506; }
body { font-family: 'Spline Sans', 'Noto Sans', sans-serif; }
.scrollbar-hide::-webkit-scrollbar { display: none; }
</style>
</head>
<body class="bg-black text-white">

<!-- HEADER -->
<header class="flex items-center justify-between px-10 py-4 border-b border-gray-800">
  <div class="flex items-center gap-6">
    <div class="flex items-center gap-2 text-[var(--primary-color)]">
      <svg fill="currentColor" viewBox="0 0 48 48" class="w-8 h-8"><path d="M24 45.81C19.68 45.81 15.47 44.53 11.88 42.13 8.29 39.73 5.5 36.33 3.85 32.35 2.2 28.36 1.77 23.97 2.61 19.74 3.45 15.52 5.53 11.63 8.58 8.58 11.63 5.53 15.51 3.45 19.74 2.61 23.97 1.77 28.36 2.2 32.35 3.85 36.33 5.5 39.73 8.29 42.13 11.88 44.53 15.47 45.81 19.68 45.81 24L24 24 24 45.81Z"/></svg>
      <h1 class="font-bold text-xl">SoundWave</h1>
    </div>
    <a href="home.php" class="text-yellow-400 font-bold hover:text-white">Home</a>
    <a href="dashboard.php" class="text-gray-300 hover:text-white">Dashboard</a>
    <a href="library.php" class="text-gray-300 hover:text-white">Library</a>
  </div>
  <div>
    <?php if(isset($_SESSION['user_id'])): ?>
      <a href="logout.php" class="px-4 py-2 bg-yellow-400 text-black rounded-full hover:bg-yellow-300">Logout</a>
    <?php else: ?>
      <a href="login.php" class="px-4 py-2 bg-yellow-400 text-black rounded-full hover:bg-yellow-300">Login</a>
    <?php endif; ?>
  </div>
</header>

<!-- HERO SECTION -->
<section class="text-center px-10 py-16 bg-gradient-to-b from-black to-gray-900">
  <h1 class="text-6xl font-black mb-4">Welcome to <span class="text-yellow-400">SoundWave</span></h1>
  <p class="text-gray-400 text-lg mb-6">Stream, upload, and enjoy your favorite music anytime, anywhere.</p>
  <div class="flex justify-center gap-4">
    <a href="dashboard.php" class="px-6 py-3 bg-yellow-400 text-black font-bold rounded-full hover:bg-yellow-300">Get Started</a>
    <a href="library.php" class="px-6 py-3 border border-gray-600 rounded-full hover:border-yellow-400">Your Library</a>
  </div>
</section>

<!-- FEATURE CARDS -->
<div class="px-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-16">
  <div class="bg-gray-900 p-6 rounded-lg hover:scale-105 transform transition">
    <h3 class="text-xl font-bold mb-2">🎵 Explore Music</h3>
    <p class="text-gray-400">Browse trending songs and discover new artists.</p>
    <a href="dashboard.php" class="mt-3 inline-block text-yellow-400 hover:underline">Explore</a>
  </div>
  <div class="bg-gray-900 p-6 rounded-lg hover:scale-105 transform transition">
    <h3 class="text-xl font-bold mb-2">📂 Your Library</h3>
    <p class="text-gray-400">Access all your saved songs and playlists in one place.</p>
    <a href="library.php" class="mt-3 inline-block text-yellow-400 hover:underline">Open Library</a>
  </div>
  <div class="bg-gray-900 p-6 rounded-lg hover:scale-105 transform transition">
    <h3 class="text-xl font-bold mb-2">⬆ Upload Songs</h3>
    <p class="text-gray-400">Share your own music with the community.</p>
    <a href="upload.php" class="mt-3 inline-block text-yellow-400 hover:underline">Upload Now</a>
  </div>
</div>

<!-- TRENDING PLAYLISTS (Spotify-style cards) -->
<section class="px-10 pb-16">
  <h2 class="text-2xl font-bold mb-6">🔥 Trending Playlists</h2>
  <div class="flex gap-6 overflow-x-auto scrollbar-hide">
    <?php
    // Example playlists (replace with DB data if available)
    $playlists = [
        ["name"=>"Chill Vibes", "img"=>"https://via.placeholder.com/150"],
        ["name"=>"Top Hits 2025", "img"=>"https://via.placeholder.com/150"],
        ["name"=>"Workout Mix", "img"=>"https://via.placeholder.com/150"],
        ["name"=>"Indie Discovery", "img"=>"https://via.placeholder.com/150"]
    ];
    foreach($playlists as $pl): ?>
      <div class="bg-gray-800 rounded-lg p-4 w-48 flex-shrink-0 hover:scale-105 transform transition">
        <img src="<?php echo $pl['img']; ?>" class="rounded mb-3 w-full h-32 object-cover">
        <h3 class="font-bold"><?php echo $pl['name']; ?></h3>
        <button class="mt-2 w-full bg-yellow-400 text-black rounded py-1 hover:bg-yellow-300">Play</button>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- FOOTER -->
<footer class="text-center text-gray-500 py-6 border-t border-gray-800">
  &copy; <?php echo date("Y"); ?> SoundWave. All rights reserved.
</footer>

</body>
</html>
