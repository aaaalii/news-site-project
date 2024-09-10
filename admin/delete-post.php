<?php
    include "config.php";
    if($_SESSION['user_role'] == 0){
        header("Location: post.php");
    }
    $pid = $_GET['id'];
    $cid = $_GET['catid']; 

    $query1 = "select * from post where post_id = {$pid}";
    $result = mysqli_query($conn, $query1);
    $row = mysqli_fetch_assoc($result);
    // to delete the image from server folder
    unlink("upload/" . $row['post_img']);

    $query = "delete from post where post_id = {$pid};";
    $query .= "update category set post = post - 1 where category_id = {$cid}";

    //echo $query;
    //die();

    if(mysqli_multi_query($conn, $query)){
        header("Location: post.php");
    }else{
        echo "Can't delete user record";
    }

    mysqli_close($conn);
?>