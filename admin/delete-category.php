<?php
    include "config.php";
    if($_SESSION['user_role'] == 0){
        header("Location: post.php");
    }
    $id = $_GET['id'];

    $query = "delete from category where category_id = {$id}";

    if(mysqli_query($conn, $query)){
        header("Location: category.php");
    }else{
        echo "Can't delete user record";
    }

    mysqli_close($conn);
?>