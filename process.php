<?php include "connection.php"?>
<?php session_start(); ?>
<?php require_once 'vendor/autoload.php' ?>
<?php
//    User Sign Up
    if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $checkEmail = mysqli_query($GLOBALS['connection'], "SELECT * FROM users WHERE email = '$email' LIMIT 1");
        if(mysqli_num_rows($checkEmail) == 0){
            $query = mysqli_query($GLOBALS['connection'], "INSERT INTO users (fname, lname, email, income, user_image, user_role, password) VALUES ('$fname', '$lname', '$email', 0, '', 'user', '$hashed_password')");
            $fetch_user = mysqli_query($GLOBALS['connection'], "SELECT * FROM users WHERE email = '$email' LIMIT 1");
            while($row = mysqli_fetch_assoc($fetch_user)){
                $_SESSION["fname"] = $row["fname"];
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["income"] = $row["income"];
                $_SESSION["user_role"] = $row["user_role"];
                $_SESSION["user_image"] = $row["user_image"];
            }
        }
        else {
            echo "<script>
                document.querySelector('.email-msg').classList.remove('display')
                setTimeout(() => {
                    document.querySelector('.email-msg').classList.add('display')
                }, 2000)
            </script>";
        }
    }

    //user login
    if(isset($_POST["login_email"]) && isset($_POST["login_password"])){
        $login_email = $_POST["login_email"];
        $login_password = $_POST["login_password"];
        $fname = '';
        $user_id = 0;
        $income = 0;
        $user_image = '';
        $user_role = '';
        $query = mysqli_query($GLOBALS['connection'], "SELECT * FROM users WHERE email = '$login_email' LIMIT 1");
        if(mysqli_num_rows($query) == 1){
            while ($row = mysqli_fetch_assoc($query)) {
                $fname = $row["fname"];
                $user_id = $row["user_id"];
                $income = $row["income"];
                $user_image = $row["user_image"];
                $user_role = $row["user_role"];
                $verify_password = password_verify($login_password, $row["password"]);
            }
            if($verify_password){
                $_SESSION["fname"] = $fname;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["income"] = $income;
                $_SESSION['user_image'] = $user_image;
                $_SESSION['user_role'] = $user_role;
            }
            else if(!$verify_password) {
                echo "<script>
                    document.querySelector('.login-pass-error').classList.remove('display')
                    setTimeout(() => {
                        document.querySelector('.login-pass-error').classList.add('display')
                    }, 2000)
                </script>";
            }
            else {
                echo "<script>
                    document.querySelector('.login-email-error').classList.remove('display')
                    setTimeout(() => {
                        document.querySelector('.login-email-error').classList.add('display')
                    }, 2000)
                </script>";
            }
        }
    }

    // Create New Transaction
    if(isset($_POST["amount"]) && isset($_POST["category"]) && isset($_POST["date"]) && isset($_SESSION["user_id"])){
        $user_id = $_SESSION["user_id"];
        $amount = $_POST["amount"];
        $category = $_POST["category"];
        $date = $_POST["date"];
        $query = mysqli_query($GLOBALS['connection'], "INSERT INTO transactions (user_id, amount, category, date) VALUES ($user_id, '$amount', '$category', '$date')");
    }

    // User profile information
    if(isset($_POST['submit'])) {
        $fname = $_POST["fname1"];
        $lname = $_POST["lname1"];
        $email = $_POST["email1"];
        $income = $_POST["income"];
        $user_id = $_SESSION['user_id'];
        $user_image = $_SESSION['user_image'];

        $img_name = $_FILES['img']['name'];
        $tmp_name = $_FILES['img']['tmp_name'];
        $upload_dir = 'user_images/';
        move_uploaded_file($tmp_name, $upload_dir.$img_name);

        if($img_name != "") {
            $query = mysqli_query($GLOBALS['connection'], "UPDATE users SET fname = '$fname', lname = '$lname', email = '$email', income = $income, user_image = '$img_name'  WHERE user_id = $user_id");
        }
        else {
            $query = mysqli_query($GLOBALS['connection'], "UPDATE users SET fname = '$fname', lname = '$lname', email = '$email', income = $income, user_image = '$user_image'  WHERE user_id = $user_id");
        }

        if(!$query){
            echo "<script>console.log('Something went wrong')</script>";
        }
        $_SESSION['income'] = $income;
        echo "<script>window.location.href='user-profile.php';</script>";
    }

    // Stripe Payment Integration
    if(isset($_POST["s_amount"]) && isset($_POST["s_catg"]) && isset($_POST["s_date"]) && isset($_POST["qty"]) && isset($_SESSION["user_id"])) {
        $s_amount = $_POST["s_amount"];
        $s_category = $_POST["s_catg"];
        $s_date = $_POST["s_date"];
        $quantity = $_POST["qty"];
        $total = intval($s_amount) * intval($quantity);

        // Session Values
        $_SESSION["amount"] = $s_amount;
        $_SESSION["category"] = $s_category;
        $_SESSION["date"] = $s_date;
        $_SESSION["total"] = $total;

        $secret_key = 'sk_test_51NPlrWDD1NVJPDTvAMdKy8Fxiq7F8I4kC2gVZFHcA3JszTS0lozpgNdwbsgnOIT7VyNhSjDSCAU1BHKm40CnpTws00uQcSneIh';
        \Stripe\Stripe::setApiKey($secret_key);

        $checkoutSession = \Stripe\Checkout\Session::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'success_url'=> 'http://localhost/Expense%20Tracker/success.php',
            'line_items' => [[
                'quantity' => $quantity,
                'price_data' => [
                    'currency' => 'bdt',
                    'unit_amount' => $s_amount * 100,
                    'product_data' => [
                        'name' => $s_category,
                    ]
                ]
            ]]
        ]);

        header('Location: ' . $checkoutSession->url);
    }
?>