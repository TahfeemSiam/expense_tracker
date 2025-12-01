<?php
    session_start();
    include "connection.php";
    if(isset($_SESSION["amount"]) && isset($_SESSION["category"]) && isset($_SESSION["date"]) && isset($_SESSION["total"])){
        $amount = $_SESSION["amount"];
        $category = $_SESSION["category"];
        $date = $_SESSION["date"];
        $total = $_SESSION["total"];
        $user_id = $_SESSION["user_id"];
        $query = mysqli_query($GLOBALS['connection'], "INSERT INTO transactions(user_id, amount, category, date) VALUES ($user_id, $amount, '$category', '$date')");
        if($query){
            echo "<h1>Your Payment Has Been Completed Successfully</h1>";
            header('Location: user-dashboard.php');
        }
    }
    else {
        header("Location: user-profile.php");
    }

