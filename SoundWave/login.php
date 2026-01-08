<?php
session_start();
include 'db.php';
$message = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user securely
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        // Login success
        $_SESSION['user_id']    = $user['id'];       // required for profile.php
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name']  = $user['username'];

        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>Login - SoundWave</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700;900&family=Spline+Sans:wght@400;500;700&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <style>:root { --primary-color: #ad2bee; } body { font-family: 'Spline Sans','Noto Sans',sans-serif; }</style>
</head>
<body class="bg-[#161118] flex items-center justify-center min-h-screen">

<div class="w-full max-w-md bg-gray-900 p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-center text-[var(--primary-color)] mb-6">SoundWave Login</h1>

    <?php if($message != ""): ?>
        <p class="text-red-500 text-center mb-4"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" class="flex flex-col gap-4">
        <input type="email" name="email" placeholder="Email" class="px-4 py-3 rounded bg-gray-800 text-white" required>
        <input type="password" name="password" placeholder="Password" class="px-4 py-3 rounded bg-gray-800 text-white" required>
        <button type="submit" name="login" class="bg-[var(--primary-color)] text-black font-bold py-3 rounded-full">Log In</button>
    </form>

    <p class="text-center text-gray-400 mt-4">Don't have an account? <a href="signup.php" class="text-[var(--primary-color)] underline">Sign Up</a></p>
</div>

</body>
</html>
