<?php include "connection.php"?>
<?php include "header.php"?>
<!-- NAVBAR -->
<?php include "navbar.php"; ?>

<!-- SIGNUP FORM CARD -->
<div class="container my-5">
    <div class="card shadow-lg mx-auto" style="max-width: 500px;">
        <div class="card-body p-4 p-md-5">
            <h1 class="text-center mb-3 fw-bold">User Sign Up</h1>
            <p class="text-center text-muted mb-4">
                Welcome! Fill out the form to create your portal account.
            </p>

            <form id="signupForm" method="post">
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input
                        type="text"
                        id="fname"
                        name="fname"
                        class="form-control p-2"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input
                        type="text"
                        id="lname"
                        name="lname"
                        class="form-control p-2"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control p-2"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control p-2"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label"
                    >Confirm Password</label
                    >
                    <input
                        type="password"
                        id="confirmPassword"
                        name="confirmPassword"
                        class="form-control p-2"
                        required
                    />
                    <div id="confirmPasswordFeedback" class="invalid-feedback">
                        Passwords do not match.
                    </div>
                </div>
                <input type="submit" value="Sign Up" name="submit" class="btn btn-primary w-100 fw-semibold shadow-sm">
                <div class="alert alert-warning email-msg display">
                    <strong>Duplicate Email</strong> user with this email already exists
                </div>
                <div class="alert alert-warning pwd-msg display">
                    <strong>Wrong Password!</strong> your passwords do not match
                </div>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Already have an account?
                <a href="Login.php" class="text-primary text-decoration-none"
                >Log In</a
                >
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
<script>
    document.body.style.backgroundColor = '#f7f9fc'
    document.title = 'User | Sign Up'
</script>
<?php include "footer.php"; ?>
