<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ExpenseTracker — Home</title>

    <!-- Inter font (same vibe as teammate pages) -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            color-scheme: light;
        }
        html,
        body {
            font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto,
            Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji",
            "Segoe UI Symbol";
        }
        .display {
            display: none;
        }
    </style>
</head>
<body class="bg-[#f7f9fc] text-gray-800">
<!-- NAVBAR -->
<header
    class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-gray-200"
>
    <nav
        class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between"
    >
        <a href="home.html" class="text-xl font-semibold tracking-tight"
        >ExpenseTracker</a
        >

        <!-- Desktop menu -->
        <div class="hidden md:flex items-center gap-6">
            <a href="index.php" class="text-gray-700 hover:text-gray-900">Home</a>
            <a href="#" class="text-gray-700 hover:text-gray-900">About</a>
            <a href="#" class="text-gray-700 hover:text-gray-900">Contact</a>
            <a
                href="user-dashboard.php"
                class="text-gray-700 hover:text-gray-900 user-dash">User Dashboard</a
            >
            <a
                href="admin.php"
                class="text-gray-700 hover:text-gray-900 admin-dash">Admin Dashboard</a
            >
            <a
                href="login.php"
                class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 user-log"
            >Log In</a
            >
            <a
                href="signup.php"
                class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white user-reg"
            >Sign Up</a
            >
        </div>

        <!-- Mobile menu button -->
        <button
            id="menuBtn"
            class="md:hidden inline-flex items-center justify-center p-2 rounded-md border border-gray-300"
        >
            <span class="sr-only">Open menu</span>
            <!-- icon -->
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 8h16M4 16h16"
                />
            </svg>
        </button>
    </nav>

    <!-- Mobile dropdown -->
    <div
        id="mobileMenu"
        class="md:hidden hidden border-t border-gray-200 bg-white"
    >
        <div class="mx-auto max-w-6xl px-4 py-3 space-y-2">
            <a
                href="index.php"
                class="block px-3 py-2 rounded-md hover:bg-gray-50"
            >Home</a
            >
            <a
                href="user-dashboard.php"
                class="block px-3 py-2 rounded-md hover:bg-gray-50"
            >User Dashboard</a
            >
            <div class="flex gap-3 pt-2">
                <a
                    href="login.php"
                    class="flex-1 text-center px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 display"
                >Log In</a
                >
                <a
                    href="signup.php"
                    class="flex-1 text-center px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white display"
                >Sign Up</a
                >
            </div>
        </div>
    </div>
</header>

<!-- HERO -->
<section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid md:grid-cols-2 gap-10 items-center">
        <!-- Left: text -->
        <div class="text-center md:text-left">
            <h1 class="text-4xl sm:text-5xl font-bold leading-tight">
                Track your money.<br class="hidden sm:block" />
                Stay in control.
            </h1>
            <p class="mt-4 text-lg text-gray-600">
                Simple expense tracking built for students and small teams — fast,
                clean, and privacy-friendly.
            </p>

            <div
                class="mt-8 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center md:justify-start"
            >
                <a
                    href="signup.php"
                    class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-base font-medium shadow"
                >
                    Get Started
                </a>
                <a
                    href="login.php"
                    class="px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-50 text-base font-medium"
                >
                    Log In
                </a>
            </div>
        </div>

        <!-- Right: demo card placeholder -->
        <div class="flex justify-center md:justify-end">
            <img
                style="height: 300px"
                src="pngtree-expense-tracker-app-rgb-color-icon-app-mobile-illustration-vector-png-image_12647642.png"
                alt="image"
            />
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 pb-16">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-2xl p-6 text-center">
            <div class="text-3xl">💳</div>
            <h3 class="mt-3 font-semibold text-lg">Simple tracking</h3>
            <p class="mt-1 text-gray-600 text-sm">
                Add income & expenses in seconds with clean forms.
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-2xl p-6 text-center">
            <div class="text-3xl">⚡</div>
            <h3 class="mt-3 font-semibold text-lg">Fast & light</h3>
            <p class="mt-1 text-gray-600 text-sm">
                Raw PHP + Tailwind — no heavy frameworks.
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-2xl p-6 text-center">
            <div class="text-3xl">🔒</div>
            <h3 class="mt-3 font-semibold text-lg">Privacy first</h3>
            <p class="mt-1 text-gray-600 text-sm">
                Local database. No tracking scripts.
            </p>
        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 pb-16">
    <div
        class="bg-white rounded-xl shadow-2xl p-6 md:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4"
    >
        <div>
            <h4 class="text-xl font-semibold">Ready to start?</h4>
            <p class="text-gray-600">
                Create an account and add your first expense in under a minute.
            </p>
        </div>
        <a
            href="signup.html"
            class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium text-base"
        >Sign Up</a
        >
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-50 border-t border-gray-200">
    <div
        class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-center"
    >
        <p class="text-sm text-gray-600">
            © 2025 ExpenseTracker •
            <a class="underline hover:no-underline" href="#">About</a> •
            <a class="underline hover:no-underline" href="#">Contact</a>
        </p>
    </div>
</footer>

<!-- tiny script for mobile menu -->
<script>
    const btn = document.getElementById("menuBtn");
    const menu = document.getElementById("mobileMenu");
    btn?.addEventListener("click", () => menu.classList.toggle("hidden"));
</script>
    <?php
        if(isset($_SESSION['fname'])) {
            if($_SESSION['user_role'] == "user") {
                echo "<script>
                    document.querySelector('.user-dash').classList.remove('display');
                    document.querySelector('.user-reg').classList.add('display');
                    document.querySelector('.user-log').classList.add('display');
                    document.querySelector('.admin-dash').classList.add('display');
                </script>";
            }
            else {
                echo "<script>
                    document.querySelector('.admin-dash').classList.remove('display');
                    document.querySelector('.user-dash').classList.add('display');
                    document.querySelector('.user-reg').classList.add('display');
                    document.querySelector('.user-log').classList.add('display');
                </script>";
            }
        }
        else {
            echo "<script>
                    document.querySelector('.user-dash').classList.add('display');
                    document.querySelector('.admin-dash').classList.add('display');
                    document.querySelector('.user-reg').classList.remove('display');
                    document.querySelector('.user-log').classList.remove('display');
                </script>";
        }
    ?>
</body>
</html>

