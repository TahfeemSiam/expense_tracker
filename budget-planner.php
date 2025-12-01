<?php include "header.php"?>
<?php include "connection.php"?>
<?php session_start() ?>
<?php
    $user_id = $_SESSION['user_id'];
    $income = $_SESSION['income'];
    $foodArray = [];
    $medicalArray = [];
    $electronicsArray = [];
    $billsArray = [];
    $travelArray = [];

    $foodSql = "SELECT AVG(amount) as foodAvg, SUM(amount) as totalFood FROM transactions WHERE user_id = $user_id AND category = 'Food'";
    $food = mysqli_query($GLOBALS['connection'], $foodSql);

    while($foodRow = mysqli_fetch_assoc($food)){
        $foodArray[] = $foodRow;
    }

    $medicalSql = "SELECT AVG(amount) as medicalAvg, SUM(amount) as totalMedical FROM transactions WHERE user_id = $user_id AND category = 'Medical'";
    $medical = mysqli_query($GLOBALS['connection'], $medicalSql);

    while($medicalRow = mysqli_fetch_assoc($medical)){
        $medicalArray[] = $medicalRow;
    }

    $electronicsSql = "SELECT AVG(amount) as electronicsAvg, SUM(amount) as totalElectronics FROM transactions WHERE user_id = 34 AND category = 'Electronics'";
    $electronics = mysqli_query($GLOBALS['connection'], $electronicsSql);

    while($electronicsRow = mysqli_fetch_assoc($electronics)){
        $electronicsArray[] = $electronicsRow;
    }

    $billsSql = "SELECT AVG(amount) as billsAvg, SUM(amount) as totalBills FROM transactions WHERE user_id = $user_id AND category = 'Bills'";
    $bills = mysqli_query($GLOBALS['connection'], $billsSql);

    while($billsRow = mysqli_fetch_assoc($bills)){
        $billsArray[] = $billsRow;
    }

    $travelSql = "SELECT AVG(amount) as travelAvg, SUM(amount) as totalTravel FROM transactions WHERE user_id = $user_id AND category = 'Travel'";
    $travel = mysqli_query($GLOBALS['connection'], $travelSql);

    while ($travelRow = mysqli_fetch_assoc($travel)){
        $travelArray[] = $travelRow;
    }

    echo '<h1 class="food display">' . json_encode($foodArray) . '</h1>';
    echo '<h1 class="medical display">' . json_encode($medicalArray) . '</h1>';
    echo '<h1 class="electronics display">' . json_encode($electronicsArray) . '</h1>';
    echo '<h1 class="travel display">' . json_encode($travelArray) . '</h1>';
    echo '<h1 class="bills display">' . json_encode($billsArray) . '</h1>';
    echo '<h1 class="income display">' . json_encode($income) . '</h1>';
?>
<style>
    /* HTML: <div class="loader"></div> */
    .loader {
        width: 60px;
        aspect-ratio: 2;
        --_g: no-repeat radial-gradient(circle closest-side,#000 90%,#0000);
        background:
                var(--_g) 0%   50%,
                var(--_g) 50%  50%,
                var(--_g) 100% 50%;
        background-size: calc(100%/3) 50%;
        animation: l3 1s infinite linear;
    }
    @keyframes l3 {
        20%{background-position:0%   0%, 50%  50%,100%  50%}
        40%{background-position:0% 100%, 50%   0%,100%  50%}
        60%{background-position:0%  50%, 50% 100%,100%   0%}
        80%{background-position:0%  50%, 50%  50%,100% 100%}
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

<div class="container py-4">

    <h3 class="mb-4 text-center">AI Financial Adviser Agent</h3>

    <!-- Chat Area -->
    <div class="card shadow-lg">
        <p class="mb-4 text-center">Start Asking Questions To Get Financial Advise</p>
        <div class="card-body chat-window" style="height: 350px; overflow-y: auto;">
        </div>
    </div>
    <form class="mt-3">
        <div class="input-group">
            <input id="user_msg" style="height: 66px" type="text" class="form-control form-control-lg" placeholder="Type your message...">
            <button id="send_msg" class="btn btn-primary btn-lg" type="button"><i class="fa-regular fa-message"></i></button>
        </div>
    </form>

</div>

<?php include "footer.php"?>;
