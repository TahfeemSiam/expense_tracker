<?php
if(isset($_POST['submit'])) {
    echo "<pre>";
        var_dump($_FILES);
    echo "</pre>";
    echo "<br/>";
    $file_name = $_FILES['img']['name'];
    $tmp_name = $_FILES['img']['tmp_name'];
    $upload_dir = 'user_images/';
    move_uploaded_file($tmp_name, $upload_dir.$file_name);
}
