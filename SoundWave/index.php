<?php
session_start();

// If user already logged in, redirect to dashboard
if (isset($_SESSION['user_email'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Tune In - Landing</title>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?display=swap&family=Noto+Sans:wght@400;500;700;900&family=Spline+Sans:wght@400;500;700" onload="this.rel='stylesheet'" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style type="text/tailwindcss">
  :root {
    --primary-color: #5b13ec;
  }
  body {
    min-height: max(884px, 100dvh);
  }
</style>
</head>
<body class="bg-[#131118] font-sans">
<div class="relative flex min-h-screen flex-col justify-between overflow-hidden text-white">
  <!-- Background gradients -->
  <div class="absolute inset-0 z-0 opacity-70">
    <div class="absolute top-[-20%] left-[-20%] w-[60%] h-[60%] rounded-full bg-gradient-to-r from-[#6366F1]/50 to-[#EC4899]/50 blur-[180px] animate-[pulse_8s_cubic-bezier(0.4,0,0.6,1)_infinite]"></div>
    <div class="absolute bottom-[-20%] right-[-20%] w-[70%] h-[70%] rounded-full bg-gradient-to-l from-[#22D3EE]/50 to-[#A78BFA]/50 blur-[180px] animate-[pulse_10s_cubic-bezier(0.4,0,0.6,1)_infinite_2s]"></div>
    <div class="absolute top-[30%] left-[40%] w-[40%] h-[40%] rounded-full bg-gradient-to-t from-[#FBBF24]/40 to-[#F472B6]/40 blur-[150px] animate-[pulse_12s_cubic-bezier(0.4,0,0.6,1)_infinite_4s]"></div>
  </div>

  <!-- Hero section -->
  <div class="relative z-10 flex flex-col justify-center flex-grow px-6 pt-16 pb-8 text-center">
    <div class="inline-block p-4 mb-6 rounded-full bg-white/10 backdrop-blur-sm">
      <span class="material-symbols-outlined text-5xl text-white">music_note</span>
    </div>
    <h1 class="text-5xl font-bold tracking-tighter mb-2">Tune In, Turn Up</h1>
    <p class="mt-4 text-lg text-white/80">Discover new music and connect with friends.</p>
  </div>

  <!-- Call to action -->
  <div class="relative z-10 px-6 pb-8">
    <div class="space-y-4">
      <a href="login.php" class="flex w-full items-center justify-center gap-3 rounded-full bg-[var(--primary-color)] py-4 text-base font-bold text-white transition-transform duration-200 active:scale-95">
        Log In
      </a>
      <a href="signup.php" class="flex w-full items-center justify-center gap-3 rounded-full bg-white/10 backdrop-blur-sm py-4 text-base font-bold text-white transition-transform duration-200 active:scale-95">
        Sign Up
      </a>
    </div>

    <div class="my-6 flex items-center justify-center">
      <div class="h-px flex-grow bg-white/20"></div>
      <p class="mx-4 text-sm text-[#a69db9]">Or continue with</p>
      <div class="h-px flex-grow bg-white/20"></div>
    </div>

    <div class="flex justify-center gap-6">
      <button class="flex h-14 w-14 items-center justify-center rounded-full bg-white/10 backdrop-blur-sm text-white transition-transform duration-200 active:scale-95">
        <!-- Google Icon -->
        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
          <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
          <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"></path>
          <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"></path>
          <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"></path>
        </svg>
      </button>

      <button class="flex h-14 w-14 items-center justify-center rounded-full bg-white/10 backdrop-blur-sm text-white transition-transform duration-200 active:scale-95">
        <!-- Facebook Icon -->
        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
          <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v7.87c4.12-.99 7.17-4.42 7.17-8.87z"></path>
        </svg>
      </button>

      <button class="flex h-14 w-14 items-center justify-center rounded-full bg-white/10 backdrop-blur-sm text-white transition-transform duration-200 active:scale-95">
        <span class="material-symbols-outlined text-3xl">mail</span>
      </button>
    </div>
  </div>
</div>
</body>
</html>
