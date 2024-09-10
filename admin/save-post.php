<?php
    include "config.php";

    if(isset($_FILES['fileToUpload'])){
        $errors = array();

        $fname = $_FILES['fileToUpload']['name'];
        $fsize = $_FILES['fileToUpload']['size'];
        $ftmp = $_FILES['fileToUpload']['tmp_name'];
        $ftype = $_FILES['fileToUpload']['type'];
        $fext = strtolower(end(explode('.', $fname)));
        $extensions = array("jpeg", "jpg", "png");

        if(in_array($fext, $extensions) === false){
            $errors[] = "Extension not allowed, only jpeg, jpg and png";
        }

        if($fsize > 2097152){
            $errors[] = "File size greater than 2, must be lower than 2";
        }

        $new_name =  time(). "-" . basename($fname);
        $target = "upload/" . $new_name;
        $image_name = $new_name;

        if(empty($errors) == true){
            move_uploaded_file($ftmp, $target);
        }else{
            print_r($errors);
            die();
        }
    }
    $ptitle = mysqli_real_escape_string($conn, $_POST['post_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = date("d M, Y");
    // get author id from session
    session_start();
    $author = $_SESSION['user_id']; 

    $query = "insert into post(title, description, category, post_date, author, post_img)
                values('$ptitle', '$desc', '$category', '$date', '$author', '$image_name');";

    $query .= "update category set post = post + 1 where category_id = $category";

    if(mysqli_multi_query($conn, $query)){
        header("Location: post.php");
    }else{
        echo "Query failed";
    }
?>