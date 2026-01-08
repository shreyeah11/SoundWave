<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$message = "";
if (isset($_POST['upload'])) {

    $title = $_POST['title'] ?? '';
    $artist_name = $_POST['artist'] ?? '';
    $album_id = $_POST['album_id'] ?? null;
    $album_id = ($album_id === '' ? null : $album_id);

    $duration = $_POST['duration'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $release_date = $_POST['release_date'] ?? '';

    // Check required fields
    if (!$title || !$artist_name) {
        $message = "❌ Title and Artist are required!";
    } else {
        // Get artist_id from DB
        $stmt = $conn->prepare("SELECT artist_id FROM artists WHERE name = ?");
        $stmt->bind_param("s", $artist_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $artist_id = $row['artist_id'];
        } else {
            // Artist not exist, insert new
            $stmt2 = $conn->prepare("INSERT INTO artists (name) VALUES (?)");
            $stmt2->bind_param("s", $artist_name);
            $stmt2->execute();
            $artist_id = $stmt2->insert_id;
            $stmt2->close();
        }
        $stmt->close();

        // Handle file upload
        if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === 0) {
            $file = $_FILES['audio_file'];
            $filename = time() . "_" . basename($file['name']);
            $target = "uploads/" . $filename;

            if (move_uploaded_file($file['tmp_name'], $target)) {
                // Insert song with file_path
                $stmt3 = $conn->prepare("INSERT INTO songs 
                    (album_id, artist_id, title, duration, genre, release_date, file_path) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt3->bind_param("iisssss", $album_id, $artist_id, $title, $duration, $genre, $release_date, $target);

                if ($stmt3->execute()) {
                    $message = "✅ Song uploaded successfully!";
                } else {
                    $message = "❌ Database error: " . $conn->error;
                }
                $stmt3->close();
            } else {
                $message = "❌ Failed to upload file!";
            }
        } else {
            $message = "❌ No audio file selected!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Upload Song - SoundWave</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white flex items-center justify-center min-h-screen">

<div class="w-full max-w-lg bg-gray-900 p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-4 text-yellow-400">Upload Your Song</h1>

    <?php if($message != ""): ?>
        <p class="mb-4 text-center <?php echo (strpos($message, '✅') !== false) ? 'text-green-400' : 'text-red-400'; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="flex flex-col gap-4">
        <input type="text" name="title" placeholder="Song Title" required class="p-3 rounded bg-gray-800 text-white border border-gray-700"/>
        <input type="text" name="artist" placeholder="Artist Name" required class="p-3 rounded bg-gray-800 text-white border border-gray-700"/>
        <input type="text" name="album_id" placeholder="Album ID (optional)" class="p-3 rounded bg-gray-800 text-white border border-gray-700"/>
        <input type="text" name="duration" placeholder="Duration (e.g., 03:45)" class="p-3 rounded bg-gray-800 text-white border border-gray-700"/>
        <input type="text" name="genre" placeholder="Genre" class="p-3 rounded bg-gray-800 text-white border border-gray-700"/>
        <input type="date" name="release_date" placeholder="Release Date" class="p-3 rounded bg-gray-800 text-white border border-gray-700"/>
        <input type="file" name="audio_file" accept="audio/*" required class="p-3 rounded bg-gray-800 text-white border border-gray-700"/>
        <button type="submit" name="upload" class="w-full py-3 bg-yellow-400 text-black font-bold rounded-lg hover:bg-yellow-300 transition">
            Upload Song
        </button>
    </form>

    <div class="text-center mt-6">
        <a href="dashboard.php" class="text-gray-400 hover:text-yellow-400">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
