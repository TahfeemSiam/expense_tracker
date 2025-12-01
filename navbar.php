<?php session_start() ?>
<?php
if(isset($_SESSION['fname'])) {
    echo "<script>
            window.location.href='index.php';
        </script>";
}
?>
<nav class="navbar navbar-expand-md bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="home.html">ExpenseTracker</a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link display" href="user-dashboard.php">User Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-secondary me-2" href="login.php">Log In</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="signup.php">Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
