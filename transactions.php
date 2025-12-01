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
    <div class="container mt-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-info text-white text-center py-3 rounded-top-4">
                <h4 class="mb-0">Total Tabular View Of Lifetime Transactions</h4>
            </div>

            <div class="card-body p-0">
                <table class="table table-hover table-striped align-middle mb-0 text-center">
                    <thead class="bg-light">
                    <tr>
                        <th><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M104 112C90.7 112 80 122.7 80 136L80 184C80 197.3 90.7 208 104 208L152 208C165.3 208 176 197.3 176 184L176 136C176 122.7 165.3 112 152 112L104 112zM256 128C238.3 128 224 142.3 224 160C224 177.7 238.3 192 256 192L544 192C561.7 192 576 177.7 576 160C576 142.3 561.7 128 544 128L256 128zM256 288C238.3 288 224 302.3 224 320C224 337.7 238.3 352 256 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L256 288zM256 448C238.3 448 224 462.3 224 480C224 497.7 238.3 512 256 512L544 512C561.7 512 576 497.7 576 480C576 462.3 561.7 448 544 448L256 448zM80 296L80 344C80 357.3 90.7 368 104 368L152 368C165.3 368 176 357.3 176 344L176 296C176 282.7 165.3 272 152 272L104 272C90.7 272 80 282.7 80 296zM104 432C90.7 432 80 442.7 80 456L80 504C80 517.3 90.7 528 104 528L152 528C165.3 528 176 517.3 176 504L176 456C176 442.7 165.3 432 152 432L104 432z"/></svg> Category</th>
                        <th><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M128 128C92.7 128 64 156.7 64 192L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 192C576 156.7 547.3 128 512 128L128 128zM320 208C381.9 208 432 258.1 432 320C432 381.9 381.9 432 320 432C258.1 432 208 381.9 208 320C208 258.1 258.1 208 320 208zM128 248L128 200C128 195.6 131.6 192 136 192L184 192C188.4 192 192.1 195.6 191.5 200C187.9 229 164.9 251.9 136 255.5C131.6 256 128 252.4 128 248zM128 392C128 387.6 131.6 383.9 136 384.5C165 388.1 187.9 411.1 191.5 440C192 444.4 188.4 448 184 448L136 448C131.6 448 128 444.4 128 440L128 392zM504 255.5C475 251.9 452.1 228.9 448.5 200C448 195.6 451.6 192 456 192L504 192C508.4 192 512 195.6 512 200L512 248C512 252.4 508.4 256.1 504 255.5zM512 392L512 440C512 444.4 508.4 448 504 448L456 448C451.6 448 447.9 444.4 448.5 440C452.1 411 475.1 388.1 504 384.5C508.4 384 512 387.6 512 392zM304 252C293 252 284 261 284 272C284 281.7 290.9 289.7 300 291.6L300 340L296 340C285 340 276 349 276 360C276 371 285 380 296 380L344 380C355 380 364 371 364 360C364 349 355 340 344 340L340 340L340 272C340 261 331 252 320 252L304 252z"/></svg> Total Money Spent</th>
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
                            <td><p class="fw-bold mb-1">Food</p></td>
                            <td><p class="fw-bold mb-1"><?php echo isset($foodTotalAmount) ? $foodTotalAmount : 0 ?> BDT</p></td>
                        </tr>
                    <?php } ?>

                    <?php
                    while($row = mysqli_fetch_assoc($queryElectronics)){
                        $electronicsTotalAmount = $row['totalAmount'];
                        ?>
                        <tr>
                            <td><p class="fw-bold mb-1">Electronics</p></td>
                            <td><p class="fw-bold mb-1"><?php echo isset($electronicsTotalAmount) ? $electronicsTotalAmount : 0 ?> BDT</p></td>
                        </tr>
                    <?php } ?>

                    <?php
                    while($row = mysqli_fetch_assoc($queryTravel)){
                        $travelTotalAmount = $row['totalAmount'];
                        ?>
                        <tr>
                            <td><p class="fw-bold mb-1">Travel</p></td>
                            <td><p class="fw-bold mb-1"><?php echo isset($travelTotalAmount) ? $travelTotalAmount : 0 ?> BDT</p></td>
                        </tr>
                    <?php } ?>

                    <?php
                    while($row = mysqli_fetch_assoc($queryMedical)){
                        $medicalTotalAmount = $row['totalAmount'];
                        ?>
                        <tr>
                            <td><p class="fw-bold mb-1">Medical</p></td>
                            <td><p class="fw-bold mb-1"><?php echo isset($medicalTotalAmount) ? $medicalTotalAmount : 0 ?> BDT</p></td>
                        </tr>
                    <?php } ?>

                    <?php
                    while($row = mysqli_fetch_assoc($queryBills)){
                        $billsTotalAmount = $row['totalAmount'];
                        ?>
                        <tr>
                            <td><p class="fw-bold mb-1">Bills</p></td>
                            <td><p class="fw-bold mb-1"><?php echo isset($billsTotalAmount) ? $billsTotalAmount : 0 ?> BDT</p></td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php include "footer.php"?>