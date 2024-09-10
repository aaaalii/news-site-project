<?php
if (isset($_POST['submit'])) {
    include 'config.php';

    if (empty($_FILES['new-image']['name'])) {
        $new_name = $_POST['old-image'];
    } else {
        $errors = array();

        $fname = $_FILES['new-image']['name'];
        $fsize = $_FILES['new-image']['size'];
        $ftmp = $_FILES['new-image']['tmp_name'];
        $ftype = $_FILES['new-image']['type'];
        $fext = strtolower(end(explode('.', $fname)));
        $extensions = array("jpeg", "jpg", "png");

        if (in_array($fext, $extensions) === false) {
            $errors[] = "Extension not allowed, only jpeg, jpg and png";
        }

        if ($fsize > 2097152) {
            $errors[] = "File size greater than 2, must be lower than 2";
        }

        $new_name =  time(). "-" . basename($fname);
        $target = "upload/" . $new_name;

        if (empty($errors) == true) {
            move_uploaded_file($ftmp, $target);
        } else {
            print_r($errors);
            die();
        }
    }

    $pre_cat = $_GET['pre-cat-id'];
    $query = "update post set title = '{$_POST['post_title']}', description = '{$_POST['postdesc']}', category = {$_POST['category']}, post_img = '{$new_name}'
                where post_id = '{$_POST['post_id']}';";

    $query .= "update category set post = post - 1 where category_id = {$pre_cat};";
    $query .= "update category set post = post + 1 where category_id = {$_POST['category']}";
    //echo $_POST['post_id'];
    //echo $query;
    //die();
    if (mysqli_multi_query($conn, $query)) {
        header("Location: post.php");
    }
}
