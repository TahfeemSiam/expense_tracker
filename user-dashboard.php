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
        .custom-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.25);
        }

        .top-image {
            width: 100%;
            height: 230px;
            object-fit: cover;
            display: block;
        }

        .custom-body {
            background: linear-gradient(135deg, #6a79ff, #4954d8);
            color: white;
            padding: 25px;
        }

        .btn-profile {
            background: white !important;
            color: #4d5be0 !important;
            border-radius: 30px;
            padding: 8px 25px;
            font-weight: 600;
            transition: 0.3s;
            border: none;
        }

        .btn-profile:hover {
            background: #e4e6ff !important;
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
                        <li><a class="dropdown-item" href="user-dashboard.php?logout=true"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="d-flex align-items-center">
            <?php
                $user_image = $_SESSION['user_image'];
            ?>
            <img alt="user_image" class="card-img-top img-fluid rounded-circle" style="height: 80px; width: 80px"
                 src="<?php echo $user_image == ''
                         ? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png'
                         : 'user_images/' . $user_image; ?>" />
            <h3><?php echo "Welcome" . " " . $_SESSION['fname']?></h3>
        </div>
        <br>
        <?php echo $_SESSION['income'] == 0 ? '<div class="alert alert-primary"><strong>Set Your Income!</strong> from the user profile page.</div>' :  '<div class="alert alert-success"><strong>Ready To Go!</strong> Apply filters to show transactions for different dates</div>' ?>
        <div class="row">
            <div class="col-md-4">
                <label for="date">Filter By Day</label>
                <input type="number" class="form-control" id="date" placeholder="Insert Time Interval" value="1">
            </div>
            <div class="col-md-4">
                <label for="category">Filter By Category</label>
                <select name="category" id="category" class="form-select">
                    <option>All</option>
                    <option>Food</option>
                    <option>Electronics</option>
                    <option>Travel</option>
                    <option>Bills</option>
                    <option>Medical</option>
                </select>
            </div>
            <div class="col-md-4">
                <?php
                    if($_SESSION['income'] == 0) {
                        echo '<input disabled type="submit" class="btn btn-info filter-btn" value="Apply Filters">';
                    }
                    else {
                        echo '<input type="submit" class="btn btn-info filter-btn" value="Apply Filters">';
                    }
                ?>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-total-bg">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white"><svg style="fill: white;" class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M192 96C156.7 96 128 124.7 128 160L128 384C128 419.3 156.7 448 192 448L544 448C579.3 448 608 419.3 608 384L608 160C608 124.7 579.3 96 544 96L192 96zM368 192C412.2 192 448 227.8 448 272C448 316.2 412.2 352 368 352C323.8 352 288 316.2 288 272C288 227.8 323.8 192 368 192zM192 216L192 168C192 163.6 195.6 160 200 160L248 160C252.4 160 256.1 163.6 255.5 168C251.9 197 228.9 219.9 200 223.5C195.6 224 192 220.4 192 216zM192 328C192 323.6 195.6 319.9 200 320.5C229 324.1 251.9 347.1 255.5 376C256 380.4 252.4 384 248 384L200 384C195.6 384 192 380.4 192 376L192 328zM536 223.5C507 219.9 484.1 196.9 480.5 168C480 163.6 483.6 160 488 160L536 160C540.4 160 544 163.6 544 168L544 216C544 220.4 540.4 224.1 536 223.5zM544 328L544 376C544 380.4 540.4 384 536 384L488 384C483.6 384 479.9 380.4 480.5 376C484.1 347 507.1 324.1 536 320.5C540.4 320 544 323.6 544 328zM80 216C80 202.7 69.3 192 56 192C42.7 192 32 202.7 32 216L32 480C32 515.3 60.7 544 96 544L488 544C501.3 544 512 533.3 512 520C512 506.7 501.3 496 488 496L96 496C87.2 496 80 488.8 80 480L80 216z"/></svg>Money Spent</h5>
                        <?php
                            $user_id = $_SESSION['user_id'];
                           if(isset($_GET['num']) && isset($_GET['category'])){
                               $dayNum = $_GET['num'];
                               if($_GET['category'] == 'All') {
                                   $query = mysqli_query($GLOBALS['connection'], "SELECT SUM(amount) AS total FROM transactions WHERE date = CURDATE() - Interval $dayNum Day AND user_id = $user_id");
                                   while ($row = mysqli_fetch_assoc($query)) {
                                       $total = $row['total'];
                                   }
                               }
                               else {
                                   $category = $_GET['category'];
                                   $query = mysqli_query($GLOBALS['connection'], "SELECT SUM(amount) AS total FROM transactions WHERE date = CURDATE() - Interval $dayNum Day AND user_id = $user_id AND category = '$category'");
                                   while ($row = mysqli_fetch_assoc($query)) {
                                       $total = $row['total'];
                                   }
                               }
                           }
                           else {
                               $query = mysqli_query($GLOBALS['connection'], "SELECT SUM(amount) AS total FROM transactions WHERE date = CURDATE() AND user_id = $user_id");
                               while ($row = mysqli_fetch_assoc($query)) {
                                   $total = $row['total'];
                               }
                           }
                        ?>
                        <p class="card-text"><?php echo !isset($total) ? 0 : $total ?>BDT</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-rm-bg">
                    <div class="card-body">
                        <h5 style="color: white" class="card-title"><svg style="fill: white" class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M128 128C92.7 128 64 156.7 64 192L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 192C576 156.7 547.3 128 512 128L128 128zM320 224C373 224 416 267 416 320C416 373 373 416 320 416C267 416 224 373 224 320C224 267 267 224 320 224zM512 248C512 252.4 508.4 256.1 504 255.5C475 251.9 452.1 228.9 448.5 200C448 195.6 451.6 192 456 192L504 192C508.4 192 512 195.6 512 200L512 248zM128 392C128 387.6 131.6 383.9 136 384.5C165 388.1 187.9 411.1 191.5 440C192 444.4 188.4 448 184 448L136 448C131.6 448 128 444.4 128 440L128 392zM136 255.5C131.6 256 128 252.4 128 248L128 200C128 195.6 131.6 192 136 192L184 192C188.4 192 192.1 195.6 191.5 200C187.9 229 164.9 251.9 136 255.5zM504 384.5C508.4 384 512 387.6 512 392L512 440C512 444.4 508.4 448 504 448L456 448C451.6 448 447.9 444.4 448.5 440C452.1 411 475.1 388.1 504 384.5z"/></svg>Remaining</h5>
                        <?php
                            $total = 0;
                            $remaining = 0;
                            $user_id = $_SESSION['user_id'];
                            if (!isset($_GET['num']) && !isset($_GET['category'])) {
                                $query = mysqli_query($GLOBALS['connection'], "SELECT SUM(amount) AS total FROM transactions WHERE date = CURDATE() AND user_id = $user_id");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $total = $row['total'];
                                }
                                $income = $_SESSION['income'];
                                $remaining = $income - $total;
                            } else {
                                if($_GET['category'] == 'All') {
                                    $dayNum = $_GET['num'];
                                    $category = $_GET['category'];
                                    $query = mysqli_query($GLOBALS['connection'], "SELECT SUM(amount) AS total FROM transactions WHERE date = CURDATE() - Interval $dayNum Day AND user_id = $user_id");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $total = $row['total'];
                                    }
                                    $income = $_SESSION['income'];
                                    $remaining = $income - $total;
                                }
                                else {
                                    $dayNum = $_GET['num'];
                                    $category = $_GET['category'];
                                    $query = mysqli_query($GLOBALS['connection'], "SELECT SUM(amount) AS total FROM transactions WHERE date = CURDATE() - Interval $dayNum Day AND category = '$category' AND user_id = $user_id");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $total = $row['total'];
                                    }
                                    $income = $_SESSION['income'];
                                    $remaining = $income - $total;
                                }
                            }
                        ?>
                        <p class="card-text"><?php echo $total == 0 ? 0 : $remaining ?>BDT</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-tr-bg">
                    <div class="card-body">
                        <h5 style="color: white" class="card-title"><svg style="fill: white" class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M31 169C21.6 159.6 21.6 144.4 31 135.1L103 63C112.4 53.6 127.6 53.6 136.9 63C146.2 72.4 146.3 87.6 136.9 96.9L105.9 127.9L173.6 127.9L173.6 127.9L511.9 127.9C547.2 127.9 575.9 156.6 575.9 191.9L575.9 370.1L570.8 365C542.7 336.9 497.1 336.9 469 365C441.8 392.2 440.9 435.6 466.2 463.9L533.9 463.9L502.9 432.9C493.5 423.5 493.5 408.3 502.9 399C512.3 389.7 527.5 389.6 536.8 399L608.8 471C618.2 480.4 618.2 495.6 608.8 504.9L536.8 576.9C527.4 586.3 512.2 586.3 502.9 576.9C493.6 567.5 493.5 552.3 502.9 543L533.9 512L127.8 512C92.5 512 63.8 483.3 63.8 448L63.8 269.8L68.9 274.9C97 303 142.6 303 170.7 274.9C197.9 247.7 198.8 204.3 173.5 176L105.8 176L136.8 207C146.2 216.4 146.2 231.6 136.8 240.9C127.4 250.2 112.2 250.3 102.9 240.9L31 169zM416 320C416 267 373 224 320 224C267 224 224 267 224 320C224 373 267 416 320 416C373 416 416 373 416 320zM504 255.5C508.4 256 512 252.4 512 248L512 200C512 195.6 508.4 192 504 192L456 192C451.6 192 447.9 195.6 448.5 200C452.1 229 475.1 251.9 504 255.5zM136 384.5C131.6 384 128 387.6 128 392L128 440C128 444.4 131.6 448 136 448L184 448C188.4 448 192.1 444.4 191.5 440C187.9 411 164.9 388.1 136 384.5z"/></svg>Number Of Transactions</h5>
                        <?php
                            if(isset($_GET['num']) || isset($_GET['category'])) {
                                if ($_GET['category'] == 'All') {
                                    $user_id = $_SESSION['user_id'];
                                    $dayNum = $_GET['num'];
                                    $query = mysqli_query($GLOBALS['connection'], "SELECT COUNT(amount) AS transactions FROM transactions WHERE date = CURDATE() - Interval $dayNum Day AND user_id = $user_id");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $transactions = $row['transactions'];
                                    }
                                }
                                else {
                                    $user_id = $_SESSION['user_id'];
                                    $dayNum = $_GET['num'];
                                    $category = $_GET['category'];
                                    $query = mysqli_query($GLOBALS['connection'], "SELECT COUNT(amount) AS transactions FROM transactions WHERE date = CURDATE() - Interval $dayNum Day AND category = '$category' AND user_id = $user_id");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $transactions = $row['transactions'];
                                    }
                                }
                            }
                            else {
                                $query = mysqli_query($GLOBALS['connection'], "SELECT COUNT(amount) AS transactions FROM transactions WHERE date = CURDATE() AND user_id = $user_id");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $transactions = $row['transactions'];
                                }
                            }
                        ?>
                        <p class="card-text"><?php echo isset($transactions) ? $transactions : 0?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="container mt-4">
        <div class="card custom-card">
            <img class="card-img-top top-image"
                 src="https://img.freepik.com/premium-vector/personal-finance-saving-management-investment-budget-wealth-illustration_1278800-9250.jpg"
                 alt="Budget Planner Image">
            <div class="card-body custom-body">
                <h4 class="card-title mb-2">AI Powered Budget Planner</h4>
                <p class="card-text">Click Below To Get AI Response On The Basis Of Your Average Monthly Cost How You Can Save Based On A Specific Saving Target</p>
                <a class="btn btn-profile" href="budget-planner.php">Get Started</a>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="container">
        <div class="col-md-12 col-lg-12 text-center display">
            <img id="no-tran" class="img-fluid" src="no-transactions.png" alt="no-transactions">
        </div>
        <div class="row">
            <?php
            $data = [];
            if(isset($_GET['num']) && isset($_GET['category'])) {
                if($_GET['category'] == 'All') {
                    $user_id = $_SESSION['user_id'];
                    $dayNum = $_GET['num'];
                    $category = $_GET['category'];
                    $query = mysqli_query($GLOBALS['connection'], "SELECT amount, category FROM transactions WHERE date = CURDATE() - Interval $dayNum Day AND user_id = $user_id");
                    while ($row = mysqli_fetch_assoc($query)) {
                        $data[] = $row;
                    }
                }
                else {
                    $user_id = $_SESSION['user_id'];
                    $dayNum = $_GET['num'];
                    $category = $_GET['category'];
                    $query = mysqli_query($GLOBALS['connection'], "SELECT amount, category FROM transactions WHERE date = CURDATE() - Interval $dayNum Day AND category = '$category' AND user_id = $user_id");
                    while ($row = mysqli_fetch_assoc($query)) {
                        $data[] = $row;
                    }
                }
            }
            else {
                $query = mysqli_query($GLOBALS['connection'], "SELECT amount, category FROM transactions WHERE user_id = $user_id AND date = CURDATE()");
                while ($row = mysqli_fetch_assoc($query)) {
                    $data[] = $row;
                }
            }
            echo '<h1 class="display json">' . json_encode($data) . '</h1>';
            ?>
            <div class="col-md-12 col-lg-12 display">
                <canvas id="myChart2"></canvas>
            </div>
            <div class="col-md-12 col-lg-12 display">
                <canvas id="myChart3"></canvas>
            </div>

        </div>
    <br>
    <?php
        if(isset($_GET['logout'])){
            session_destroy();
            echo "<script>window.location.href='index.php';</script>";
        }
    ?>
<?php include "footer.php"?>
