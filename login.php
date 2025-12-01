<?php include "header.php"?>
<!-- NAVBAR -->
<?php include "navbar.php"?>
<!-- LOGIN CARD -->
<div class="container my-5">
    <div class="card shadow-lg mx-auto" style="max-width: 400px;">
        <div class="card-body p-4">
            <h2 class="text-center fw-bold mb-3">User Login</h2>
            <p class="text-center text-muted mb-4">
                Sign in to access your dashboard.
            </p>

            <form id="loginForm" method="post">
                <!-- Email -->
                <div class="mb-3">
                    <label for="login_email" class="form-label">Email address</label>
                    <input
                        type="email"
                        class="form-control p-2"
                        id="login_email"
                        name="login_email"
                        required
                        placeholder="Enter your email"
                    />
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                        <label for="login_password" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control p-2"
                            id="login_password"
                            name="login_password"
                            required
                            minlength="8"
                            placeholder="Enter your password"
                        />
                    <div class="invalid-feedback">
                        Please enter your password (minimum 8 characters).
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-semibold shadow-sm">
                    Log In
                </button>
                <div class="alert alert-warning display login-pass-error">
                    <strong>Incorrect Password!</strong> make sure your password is correct
                </div>
                <div class="alert alert-warning display login-email-error">
                    <strong>Invalid Email!</strong> make sure your email is correct
                </div>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Don't have an account?
                <a href="signup.php" class="text-primary fw-semibold">Sign Up</a>
            </p>
        </div>
    </div>
</div>
<?php
    if(isset($_SESSION['fname'])) {
        echo "<script>
                    window.location.href='index.php';
             </script>";
    }
?>
<?php include "footer.php"?>