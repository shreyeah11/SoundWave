<?php
session_start();
include 'db.php'; // your DB connection

// Check login
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Redirect to library if button clicked
if (isset($_POST['library'])) {
    header("Location: library.php");
    exit();
}

// Fetch uploaded songs
$songs = [];
$song_query = "SELECT s.*, a.name AS artist_name, al.title AS album_title 
               FROM songs s 
               LEFT JOIN artists a ON s.artist_id = a.artist_id
               LEFT JOIN albums al ON s.album_id = al.album_id
               ORDER BY s.song_id DESC";

$result = $conn->query($song_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}

// Fetch user info
$email = $_SESSION['user_email'];
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
$user_name = $user['username'];
$user_avatar = $user['avatar'] ?? "https://via.placeholder.com/150";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>SoundWave Dashboard</title>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700;900&family=Spline+Sans:wght@400;500;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style>
:root { --primary-color: #f9f506; }
body { font-family: 'Spline Sans', 'Noto Sans', sans-serif; }
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
    <a href="home.php" class="text-gray-300 hover:text-white">Home</a>
    <a href="upload.php" class="px-4 py-2 bg-yellow-400 text-black rounded-full">Upload Song</a>
    <form method="post">
      <button type="submit" name="library" class="px-4 py-2 bg-[var(--primary-color)] text-black rounded-full">Library</button>
    </form>
  </div>

  <!-- Right Side Header -->
  <div class="flex items-center gap-4">
    <!-- Search -->
    <div class="relative">
      <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
      <input id="searchInput" class="pl-10 pr-4 py-2 rounded-full bg-gray-800 text-white placeholder-gray-400 focus:outline-none" placeholder="Search"/>
    </div>

    <!-- Notifications -->
    <button class="bg-gray-800 hover:bg-gray-700 p-2 rounded-full">
      <span class="material-symbols-outlined text-gray-300">notifications</span>
    </button>

    <!-- Settings -->
    <button onclick="window.location.href='settings.php'" class="bg-gray-800 hover:bg-gray-700 p-2 rounded-full">
      <span class="material-symbols-outlined text-gray-300">settings</span>
    </button>

    <!-- Profile Icon -->
    <button onclick="window.location.href='profile.php'" class="w-10 h-10 rounded-full bg-cover bg-center" 
        style="background-image:url('<?php echo $user_avatar; ?>');">
    </button>
  </div>
</header>

<!-- HERO -->
<div class="px-10 py-10 text-center">
  <h1 class="text-5xl font-black mb-4">Tune in, Turn up</h1>
  <p class="text-gray-300 mb-6">Discover the latest hits and timeless classics. Your music, your way.</p>
  <button class="px-6 py-3 bg-[var(--primary-color)] text-black font-bold rounded-full hover:bg-yellow-400">Explore Now</button>
</div>

<!-- DASHBOARD GRID -->
<div class="px-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  <!-- Now Playing -->
  <div class="bg-gray-900 p-6 rounded-lg flex flex-col gap-4">
    <h3 class="font-bold text-xl">Now Playing</h3>
    <div class="flex gap-4 items-center">
      <img class="w-16 h-16 rounded-md" src="https://via.placeholder.com/150" alt="album"/>
      <div>
        <p class="font-medium">Electric Pulse</p>
        <p class="text-gray-400">DJ Nova</p>
      </div>
    </div>
    <div class="w-full bg-gray-700 h-1.5 rounded-full mt-2">
      <div class="bg-[var(--primary-color)] h-1.5 rounded-full" style="width:45%"></div>
    </div>
    <div class="flex justify-between text-xs text-gray-400">
      <span>1:23</span>
      <span>3:45</span>
    </div>
    <div class="flex justify-center gap-4 mt-4">
      <button><span class="material-symbols-outlined">skip_previous</span></button>
      <button class="bg-[var(--primary-color)] rounded-full w-10 h-10 flex items-center justify-center"><span class="material-symbols-outlined">pause</span></button>
      <button><span class="material-symbols-outlined">skip_next</span></button>
    </div>
  </div>

  <!-- My Playlists -->
  <div class="bg-gray-900 p-6 rounded-lg flex flex-col gap-4">
    <h3 class="font-bold text-xl">My Playlists</h3>
    <ul class="space-y-2">
      <li class="hover:text-white cursor-pointer">Chill Vibes</li>
      <li class="hover:text-white cursor-pointer">Workout Hits</li>
      <li class="hover:text-white cursor-pointer">Late Night Jazz</li>
    </ul>
  </div>

  <!-- Liked Songs -->
  <div class="bg-gray-900 p-6 rounded-lg flex flex-col gap-4">
    <h3 class="font-bold text-xl">Liked Songs</h3>
    <p class="text-4xl font-bold">142</p>
    <p class="text-gray-400">Total liked songs</p>
  </div>
</div>

<!-- Uploaded Songs Section -->
<div class="px-10 mt-10">
    <h2 class="text-2xl font-bold mb-6">Your Uploaded Songs</h2>
    <?php if(!empty($songs)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach($songs as $song): ?>
        <div class="bg-gray-900 p-4 rounded-lg hover:bg-gray-800 transition-colors group">
            <h3 class="font-bold text-lg"><?php echo htmlspecialchars($song['title']); ?></h3>
            <p class="text-sm text-gray-400"><?php echo htmlspecialchars($song['artist_name']); ?></p>

            <!-- Audio Player -->
            <audio controls class="w-full mt-2">
                <source src="<?php echo htmlspecialchars($song['file_path']); ?>" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p class="text-gray-400">You haven't uploaded any songs yet. <a href="upload.php" class="text-yellow-400 underline">Upload one now</a>.</p>
    <?php endif; ?>
</div>


<script>
document.getElementById('searchInput').addEventListener('keydown', function(e) {
  if(e.key === 'Enter'){
    alert('Search for: ' + this.value); // Replace with redirect to search page
  }
});
</script>

</body>
</html>
