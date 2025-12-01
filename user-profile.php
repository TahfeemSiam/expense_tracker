<?php session_start() ?>
<?php include "header.php"?>
<?php include 'connection.php'?>
<?php
    if(!isset($_SESSION['fname']) || !isset($_SESSION['user_id'])){
        header("location:login.php");
    }
    if($_SESSION['user_role'] === 'admin'){
        header("location:admin.php");
    }
?>
    <style>
        /* Tablets (≤ 992px) */
        @media (max-width: 992px) {
            .form-container {
                width: 80%;
                margin: 0 auto;
            }
        }

        /* Small tablets / large phones (≤ 768px) */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
                margin: 0 auto;
            }
        }

        /* Mobile phones (≤ 576px) */
        @media (max-width: 576px) {
            .form-container {
                width: 100%;
                margin: 0 auto;
            }
        }

        /* Very small phones (≤ 400px) */
        @media (max-width: 400px) {
            .form-container {
                width: 100%;
                margin: 0 auto;
            }
        }
    </style>
    <nav class="navbar navbar-expand-sm bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="user-dashboard.php">User Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fa-regular fa-house"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transactions.php"><i class="fa-solid fa-file-invoice"></i>Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="budget-planner.php"><i class="fa-solid fa-coins"></i>AI Advisor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user-profile.php"><i class="fa-regular fa-user"></i>User Profile</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-user" data-bs-toggle="dropdown"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="user-profile.php?logout=true"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <br>
    <div class="container">
        <ul class="nav nav-pills flex-row justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="pill" href="#record">Insert Expense Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#home">User Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#menu1">Pay Bills through Stripe</a>
            </li>
        </ul>
    </div>

        <div class="container">
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane container active" id="record">
                    <div class="form-container">
                        <?php echo $_SESSION['income'] == 0 ? '<div class="alert alert-primary"><strong>Set Your Income!</strong> from the user information tab.</div>' :  '<div class="alert alert-success"><strong>Ready To Go!</strong> add your expenses from here</div>' ?>
                        <div class="card">
                            <div class="card-body">
                                <form id="transaction" action="#">
                                    <div class="mb-3 mt-3">
                                        <label for="amount">Amount:</label>
                                        <input type="text" class="form-control p-2" id="amount" placeholder="Enter Amount" name="amount" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="catg">Category:</label>
                                        <select name="catg" id="catg" class="form-select" required>
                                            <option>Food</option>
                                            <option>Electronics</option>
                                            <option>Travel</option>
                                            <option>Bills</option>
                                            <option>Medical</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="date">Select Date:</label>
                                        <input class="form-control p-2" type="date" id="date" name="date" required>
                                    </div>
                                    <?php
                                    if($_SESSION['income'] == 0) {
                                        echo '<input style="width: 100%" disabled type="submit" name="submit" class="btn btn-primary py-3" value="Submit">';
                                    }
                                    else {
                                        echo '<input style="width: 100%" type="submit" name="submit" class="btn btn-primary py-3" value="Submit">';
                                    }
                                    ?>
                                    <div class="alert alert-info mt-2 display tr-success">
                                        <strong>Transaction Added!</strong> Your transaction has been inserted successfully.
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane container active" id="home">
                    <div class="form-container">
                        <div class="card form-card">
                            <?php
                            $user_id = $_SESSION['user_id'];
                            $user_data = mysqli_query($GLOBALS['connection'], "SELECT * FROM users WHERE user_id = $user_id");
                            while ($row = mysqli_fetch_assoc($user_data)) {
                            $fname = $row['fname'];
                            $lname = $row['lname'];
                            $email = $row['email'];
                            $income = $row['income'];
                            $_SESSION['user_image'] = $row['user_image'];
                            $user_image = $row['user_image'];
                            ?>
                            <img alt="user_image" class="card-img-top img-fluid" style="height: 400px"
                                 src="<?php echo $user_image == ''
                                         ? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png'
                                         : 'user_images/' . $user_image; ?>" />
                            <div class="card-body">
                                <form id="profile" method="post" enctype="multipart/form-data" action="process.php">
                                    <div class="mb-3 mt-3">
                                        <label for="fname1">First Name:</label>
                                        <input type="text" class="form-control p-2" id="fname1" placeholder="Enter FirstName" name="fname1" value="<?php echo $fname ?>">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="lname1">Last Name:</label>
                                        <input type="text" class="form-control p-2" id="lname1" placeholder="Enter LastName" name="lname1" value="<?php echo $lname ?>">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="email1">Email:</label>
                                        <input type="email1" class="form-control p-2" id="email1" placeholder="Enter email" name="email1" value="<?php echo $email ?>">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="income">Balance:</label>
                                        <input type="number" class="form-control p-2" id="income" placeholder="Enter Your Balance" name="income" value="<?php echo $income ?>">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="img">User Image:</label>
                                        <input type="file" class="form-control p-2" id="img" name="img">
                                    </div>
                                    <input value="Update" style="width: 100%" name="submit" type="submit" class="btn btn-primary py-3">
                                </form>
                                <?php  } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane container fade" id="menu1">
                    <div class="form-container">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3">Secure Payment with Stripe</h4>
                                <p class="text-muted mb-4">
                                    Paying your bills through <strong>Stripe</strong> is fast, secure, and reliable.
                                    Your payment details are safely encrypted, ensuring complete protection at every step.
                                </p>
                                <button class="btn pay-btn" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <i class="bi bi-credit-card me-2"></i> PAY NOW
                                </button>
                                <!-- The Modal -->
                                <div class="modal fade" id="myModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Insert Payment Details To Continue</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form id="stripe_transaction" method="post" action="process.php">
                                                    <div class="mb-3 mt-3">
                                                        <label for="s_amount">Amount:</label>
                                                        <input type="text" class="form-control p-2" id="s_amount" placeholder="Enter Amount" name="s_amount" required>
                                                    </div>
                                                    <div class="mb-3 mt-3">
                                                        <label for="s_catg">Category:</label>
                                                        <select name="s_catg" id="s_catg" class="form-select" required>
                                                            <option>Food</option>
                                                            <option>Electronics</option>
                                                            <option>Travel</option>
                                                            <option>Bills</option>
                                                            <option>Medical</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 mt-3">
                                                        <label for="qty">Quantity:</label>
                                                        <input type="number" value="1" name="qty" id="qty" class="form-select" required>
                                                    </div>
                                                    <div class="mb-3 mt-3">
                                                        <label for="s_date">Select Date:</label>
                                                        <input class="form-control p-2" type="date" id="s_date" name="s_date" required>
                                                    </div>
                                                    <div class="mb-3 mt-3">
                                                        <input style="width: 100%" type="submit" name="s_submit" class="btn btn-primary py-3" value="Proceed">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
        if(isset($_GET['logout'])){
            session_destroy();
            echo "<script>window.location.href='index.php';</script>";
        }
        echo "<script>
            document.body.style.background = 'linear-gradient(90deg,rgba(42, 123, 155, 1) 0%, rgba(181, 255, 208, 1) 100%, rgba(237, 221, 83, 1) 100%)'
        </script>"
    ?>
<?php include "footer.php"?>
