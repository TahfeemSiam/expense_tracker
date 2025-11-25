<?php session_start() ?>
<?php include "header.php"?>
<?php include 'connection.php'?>
<?php
    if(!isset($_SESSION['fname']) || !isset($_SESSION['user_id'])){
        header("location:login.php");
    }
?>
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
    <div class="container">
        <div class="col-md-12 col-lg-12 text-center display">
            <img id="no-tran" class="img-fluid" src="no-transactions.png" alt="no-transactions">
        </div>
        <div style="max-height: 400px; overflow-y: auto; overflow-x: hidden;">
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
    </div>
    <br>
    <div class="container">
        <h3>Tabular View Of Total Lifetime Transactions: </h3>
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
            <tr>
                <th><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M104 112C90.7 112 80 122.7 80 136L80 184C80 197.3 90.7 208 104 208L152 208C165.3 208 176 197.3 176 184L176 136C176 122.7 165.3 112 152 112L104 112zM256 128C238.3 128 224 142.3 224 160C224 177.7 238.3 192 256 192L544 192C561.7 192 576 177.7 576 160C576 142.3 561.7 128 544 128L256 128zM256 288C238.3 288 224 302.3 224 320C224 337.7 238.3 352 256 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L256 288zM256 448C238.3 448 224 462.3 224 480C224 497.7 238.3 512 256 512L544 512C561.7 512 576 497.7 576 480C576 462.3 561.7 448 544 448L256 448zM80 296L80 344C80 357.3 90.7 368 104 368L152 368C165.3 368 176 357.3 176 344L176 296C176 282.7 165.3 272 152 272L104 272C90.7 272 80 282.7 80 296zM104 432C90.7 432 80 442.7 80 456L80 504C80 517.3 90.7 528 104 528L152 528C165.3 528 176 517.3 176 504L176 456C176 442.7 165.3 432 152 432L104 432z"/></svg>Category</th>
                <th><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M128 128C92.7 128 64 156.7 64 192L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 192C576 156.7 547.3 128 512 128L128 128zM320 208C381.9 208 432 258.1 432 320C432 381.9 381.9 432 320 432C258.1 432 208 381.9 208 320C208 258.1 258.1 208 320 208zM128 248L128 200C128 195.6 131.6 192 136 192L184 192C188.4 192 192.1 195.6 191.5 200C187.9 229 164.9 251.9 136 255.5C131.6 256 128 252.4 128 248zM128 392C128 387.6 131.6 383.9 136 384.5C165 388.1 187.9 411.1 191.5 440C192 444.4 188.4 448 184 448L136 448C131.6 448 128 444.4 128 440L128 392zM504 255.5C475 251.9 452.1 228.9 448.5 200C448 195.6 451.6 192 456 192L504 192C508.4 192 512 195.6 512 200L512 248C512 252.4 508.4 256.1 504 255.5zM512 392L512 440C512 444.4 508.4 448 504 448L456 448C451.6 448 447.9 444.4 448.5 440C452.1 411 475.1 388.1 504 384.5C508.4 384 512 387.6 512 392zM304 252C293 252 284 261 284 272C284 281.7 290.9 289.7 300 291.6L300 340L296 340C285 340 276 349 276 360C276 371 285 380 296 380L344 380C355 380 364 371 364 360C364 349 355 340 344 340L340 340L340 272C340 261 331 252 320 252L304 252z"/></svg>Total Money Spent</th>
                <th><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z"/></svg>Remove</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $queryFood = mysqli_query($GLOBALS['connection'], "SELECT category, SUM(amount) as totalAmount FROM transactions WHERE user_id = $_SESSION[user_id] AND category = 'Food'");
                $queryElectronics = mysqli_query($GLOBALS['connection'], "SELECT category, SUM(amount) as totalAmount FROM transactions WHERE user_id = $_SESSION[user_id] AND category = 'Electronics'");
                $queryTravel = mysqli_query($GLOBALS['connection'], "SELECT category, SUM(amount) as totalAmount FROM transactions WHERE user_id = $_SESSION[user_id] AND category = 'Travel'");
                $queryMedical = mysqli_query($GLOBALS['connection'], "SELECT category, SUM(amount) as totalAmount FROM transactions WHERE user_id = $_SESSION[user_id] AND category = 'Medical'");
                $queryBills = mysqli_query($GLOBALS['connection'], "SELECT category, SUM(amount) as totalAmount FROM transactions WHERE user_id = $_SESSION[user_id] AND category = 'Bills'");
                while($row = mysqli_fetch_assoc($queryFood)){
                    $foodTotalAmount = $row['totalAmount'];
                ?>
                    <tr>
                        <td>
                            <p class="fw-bold mb-1">Food</p>
                        </td>
                        <td>
                            <p class="fw-bold mb-1"><?php echo isset($foodTotalAmount) ? $foodTotalAmount : 0 ?>BDT</p>
                        </td>
                        <td>
                            <button style="fill: white" type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z"/></svg>
                            </button>
                            <!-- The Modal -->
                            <div class="modal fade" id="deleteModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Are You Sure?</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Click "Yes" to delete or click "Close" to close the modal
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <a href="user-dashboard.php?delete=Food" class="btn btn-success">Yes</a>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php
                    while($row = mysqli_fetch_assoc($queryElectronics)){
                            $electronicsCategory = $row['category'];
                            $electronicsTotalAmount = $row['totalAmount'];
                        ?>
                        <tr>
                            <td>
                                <p class="fw-bold mb-1">Electronics</p>
                            </td>
                            <td>
                                <p class="fw-bold mb-1"><?php echo isset($electronicsTotalAmount) ? $electronicsTotalAmount : 0 ?>BDT</p>
                            </td>
                            <td>
                                <button style="fill: white" type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModal2">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z"/></svg>
                                </button>
                                <!-- The Modal -->
                                <div class="modal fade" id="deleteModal2">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Are You Sure?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                Click "Yes" to delete or click "Close" to close the modal
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <a href="user-dashboard.php?delete=Electronics" class="btn btn-success">Yes</a>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                <?php
                    while($row = mysqli_fetch_assoc($queryTravel)){
                            $travelTotalAmount = $row['totalAmount'];
                        ?>
                        <tr>
                            <td>
                                <p class="fw-bold mb-1">Travel</p>
                            </td>
                            <td>
                                <p class="fw-bold mb-1"><?php echo isset($travelTotalAmount) ? $travelTotalAmount : 0 ?>BDT</p>
                            </td>
                            <td>
                                <button style="fill: white" type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModal3">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z"/></svg>
                                </button>
                                <!-- The Modal -->
                                <div class="modal fade" id="deleteModal3">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Are You Sure?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                Click "Yes" to delete or click "Close" to close the modal
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <a href="user-dashboard.php?delete=Travel" class="btn btn-success">Yes</a>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php
                        while($row = mysqli_fetch_assoc($queryMedical)){
                                $medicalTotalAmount = $row['totalAmount'];
                            ?>
                            <tr>
                                <td>
                                    <p class="fw-bold mb-1">Medical</p>
                                </td>
                                <td>
                                    <p class="fw-bold mb-1"><?php echo isset($medicalTotalAmount) ? $medicalTotalAmount : 0 ?>BDT</p>
                                </td>
                                <td>
                                    <button style="fill: white" type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModal4">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z"/></svg>
                                    </button>
                                    <!-- The Modal -->
                                    <div class="modal fade" id="deleteModal4">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Are You Sure?</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    Click "Yes" to delete or click "Close" to close the modal
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <a href="user-dashboard.php?delete=Medical" class="btn btn-success">Yes</a>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php
                            while($row = mysqli_fetch_assoc($queryBills)){
                                    $billsTotalAmount = $row['totalAmount'];
                                ?>
                                <tr>
                                    <td>
                                        <p class="fw-bold mb-1">Bills</p>
                                    </td>
                                    <td>
                                        <p class="fw-bold mb-1"><?php echo isset($billsTotalAmount) ? $billsTotalAmount : 0; ?>BDT</p>
                                    </td>
                                    <td>
                                        <button style="fill: white" type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModal5">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z"/></svg>
                                        </button>
                                        <!-- The Modal -->
                                        <div class="modal fade" id="deleteModal5">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Are You Sure?</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Click "Yes" to delete or click "Close" to close the modal
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <a href="user-dashboard.php?delete=Bills" class="btn btn-success">Yes</a>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                </tbody>
            </table>
        </div>
    <?php
        if(isset($_GET['delete'])){
            $category = $_GET['delete'];
            $user_id = $_SESSION['user_id'];
            $query = mysqli_query($GLOBALS['connection'], "DELETE FROM transactions WHERE category='$category' AND user_id = $user_id");
            if($query){
                echo "<script>window.location.href = 'user-dashboard.php'</script>";
            }
        }
        if(isset($_GET['logout'])){
            session_destroy();
            echo "<script>window.location.href='index.php';</script>";
        }
    ?>
<?php include "footer.php"?>
