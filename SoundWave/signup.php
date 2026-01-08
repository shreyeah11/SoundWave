<?php
include 'db.php'; // your database connection
session_start(); // START SESSION
$message = "";

if (isset($_POST['signup'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure hash

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Email already registered!";
    } else {
        $stmt_insert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("sss", $name, $email, $password);
        if ($stmt_insert->execute()) {
            // ✅ Set session to auto-login
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name']  = $name; // optional, for dashboard display
            header("Location: dashboard.php"); // go straight to dashboard
            exit(); // stop execution
        } else {
            $message = "Error: " . $conn->error;
        }
        $stmt_insert->close();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<title>SoundWave - Sign Up</title>
<style>
:root { --primary-color: #ad2bee; }
body { min-height: max(884px, 100dvh); }
</style>
</head>
<body class="bg-[#161118] flex justify-center items-center min-h-screen">
<div class="w-full max-w-md p-6 bg-[#1e1b2b] rounded-xl">
<h1 class="text-white text-3xl font-bold text-center mb-4">SoundWave</h1>
<p class="text-white/80 text-center mb-6">Sign up to start streaming music</p>

<?php if($message != "") { echo "<p class='text-red-500 mb-4'>$message</p>"; } ?>

<form method="post" action="">
    <input type="text" name="name" placeholder="Full Name" required class="w-full mb-4 p-3 rounded bg-[#2a2a2a] text-white border-none"/>
    <input type="email" name="email" placeholder="Email" required class="w-full mb-4 p-3 rounded bg-[#2a2a2a] text-white border-none"/>
    <input type="password" name="password" placeholder="Password" required class="w-full mb-4 p-3 rounded bg-[#2a2a2a] text-white border-none"/>
    <button type="submit" name="signup" class="w-full bg-[var(--primary-color)] text-white font-bold py-3 rounded hover:scale-105 transition-transform">Sign Up</button>
</form>

<p class="text-white/70 text-center mt-4 text-sm">Already have an account? <a href="login.php" class="underline">Log In</a></p>
</div>
</body>
</html>
