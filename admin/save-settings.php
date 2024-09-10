<?php
if (isset($_POST['submit'])) {
    include 'config.php';

    if (empty($_FILES['logo']['name'])) {
        $fname = $_POST['old-logo'];
    } else {
        $errors = array();

        $fname = $_FILES['logo']['name'];
        $fsize = $_FILES['logo']['size'];
        $ftmp = $_FILES['logo']['tmp_name'];
        $ftype = $_FILES['logo']['type'];
        $exp = explode('.', $fname);
        $fext = strtolower(end($exp));
        $extensions = array("jpeg", "jpg", "png");

        if (in_array($fext, $extensions) === false) {
            $errors[] = "Extension not allowed, only jpeg, jpg and png";
        }

        if ($fsize > 2097152) {
            $errors[] = "File size greater than 2, must be lower than 2";
        }

        if (empty($errors) == true) {
            move_uploaded_file($ftmp, "images/" . $fname);
        } else {
            print_r($errors);
            die();
        }
    }

    $pre_cat = $_GET['pre-cat-id'];
    $query = "update settings set websitename = '{$_POST['website_name']}', logo = '{$fname}', footerdesc = '{$_POST['footer_desc']}'";

    if (mysqli_multi_query($conn, $query)) {
        header("Location: settings.php");
    }else {
        echo "Query Failed";
    }
}
