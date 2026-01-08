<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Fetch user info
$email = $_SESSION['user_email'];
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$user_name = $user['username'];
$user_avatar = $user['avatar'] ?? "https://via.placeholder.com/150";

// Fetch uploaded songs
$songs = [];
$song_query = "SELECT s.*, a.name AS artist_name, al.title AS album_title 
               FROM songs s 
               LEFT JOIN artists a ON s.artist_id = a.artist_id
               LEFT JOIN albums al ON s.album_id = al.album_id
               ORDER BY s.song_id DESC"; // latest first

$result = $conn->query($song_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Dashboard - SoundWave</title>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style>
:root { --primary-color: #7311d4; }
body { font-family: 'Spline Sans', 'Noto Sans', sans-serif; }
.material-symbols-outlined {
    font-variation-settings:
    'FILL' 0,
    'wght' 400,
    'GRAD' 0,
    'opsz' 24;
}
</style>
</head>
<body class="bg-[#121212]">
<div class="relative flex min-h-screen text-white font-sans">

<!-- Sidebar -->
<aside class="w-64 bg-black p-6 flex flex-col justify-between">
    <div>
        <div class="flex items-center gap-2 mb-10">
            <div class="p-2 bg-[var(--primary-color)] rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 48 48">
                    <path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"/>
                </svg>
            </div>
            <h2 class="text-white text-xl font-bold">SoundWave</h2>
        </div>
        <nav class="flex flex-col gap-4">
            <a class="flex items-center gap-4 text-white font-semibold hover:bg-zinc-800 px-4 py-2 rounded-lg" href="home.php">
                <span class="material-symbols-outlined">home</span>Home
            </a>
            <a class="flex items-center gap-4 text-white font-semibold bg-zinc-800 px-4 py-2 rounded-lg" href="#">
                <span class="material-symbols-outlined">search</span>Search
            </a>
            <a class="flex items-center gap-4 text-zinc-400 hover:text-white" href="#">
                <span class="material-symbols-outlined">library_music</span>Your Library
            </a>
        </nav>
        <div class="mt-10">
            <h3 class="text-zinc-400 font-semibold mb-4">Playlists</h3>
            <nav class="flex flex-col gap-2">
                <a class="text-zinc-400 hover:text-white" href="#">Liked Songs</a>
                <a class="text-zinc-400 hover:text-white" href="#">Chill Mix</a>
                <a class="text-zinc-400 hover:text-white" href="#">Workout</a>
                <a class="text-zinc-400 hover:text-white" href="#">Rock Classics</a>
            </nav>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10 h-10" style="background-image: url('<?php echo $user_avatar; ?>');"></div>
        <p class="font-semibold"><?php echo $user_name; ?></p>
        <a href="logout.php" class="ml-auto text-sm text-red-500 hover:underline">Logout</a>
    </div>
</aside>

<!-- Main content -->
<main class="flex-1 p-8 bg-gradient-to-b from-[#222] to-[#121212]">
    <div class="max-w-4xl mx-auto">
        <!-- Search bar -->
        <div class="relative mb-8">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400">search</span>
            <input class="form-input w-full rounded-full bg-[#2a2a2a] border-none text-white placeholder-zinc-400 pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" placeholder="Search for songs, artists..." type="text"/>
        </div>

        <!-- Browse Songs -->
        <h2 class="text-2xl font-bold mb-6">Your Uploaded Songs</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if(!empty($songs)): ?>
                <?php foreach($songs as $song): ?>
                    <div class="bg-[#181818] p-4 rounded-lg hover:bg-[#282828] transition-colors">
                        <div class="mb-4">
                            <img class="w-full h-40 object-cover rounded-md mb-2" 
                                 src="<?php echo $song['cover'] ?? 'https://via.placeholder.com/150'; ?>" 
                                 alt="Cover"/>
                            <?php if (!empty($song['file_path']) && file_exists($song['file_path'])): ?>
                                <audio controls class="w-full">
                                    <source src="<?php echo htmlspecialchars($song['file_path']); ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            <?php else: ?>
                                <p class="text-red-400">⚠ File missing or path not set</p>
                            <?php endif; ?>
                        </div>
                        <h3 class="font-bold"><?php echo htmlspecialchars($song['title']); ?></h3>
                        <p class="text-sm text-zinc-400"><?php echo $song['artist_name'] ?? 'Unknown Artist'; ?></p>
                        <p class="text-sm text-zinc-500"><?php echo $song['album_title'] ?? 'Single'; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-400">No songs uploaded yet.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
</div>
</body>
</html>
