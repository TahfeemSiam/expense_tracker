<?php
    $connection = mysqli_connect("localhost", "root", "", 'expense_tracker');
    if (!$connection) {
        mysqli_error($connection);
    }
