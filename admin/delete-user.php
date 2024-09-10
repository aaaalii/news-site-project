<?php
    include "config.php";
    if($_SESSION['user_role'] == 0){
        header("Location: post.php");
    }
    $id = $_GET['id'];

    $query = "delete from user where user_id = {$id}";

    if(mysqli_query($conn, $query)){
        header("Location: users.php");
    }else{
        echo "Can't delete user record";
    }

    mysqli_close($conn);
?>