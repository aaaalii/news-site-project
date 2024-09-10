<?php
    include "config.php";
    $page = basename($_SERVER['PHP_SELF']);
    switch($page){
        case "single.php":
            if(isset($_GET['id'])){
                $sql = "select * from post where post_id = {$_GET['id']}";
                $res = mysqli_query($conn, $sql) or die("Query Failed loading title");
                $roww = mysqli_fetch_assoc($res);
                $ptitle = $roww['title'];
            }else {
                $ptitle = "No Post Found";
            }
            break;
        case "category.php":
            if(isset($_GET['cid'])){
                $sql = "select * from category where category_id = {$_GET['cid']}";
                $res = mysqli_query($conn, $sql) or die("Query Failed loading title");
                $roww = mysqli_fetch_assoc($res);
                $ptitle = $roww['category_name'];
            }else {
                $ptitle = "No Category Found";
            }
            break;
        case "author.php":
            if(isset($_GET['aid'])){
                $sql = "select * from user where user_id = {$_GET['aid']}";
                $res = mysqli_query($conn, $sql) or die("Query Failed loading title");
                $roww = mysqli_fetch_assoc($res);
                $ptitle = $roww['username'];
            }else {
                $ptitle = "No User Found";
            }
            break;
        case "search.php":
            if(isset($_GET['search'])){
                $ptitle = $_GET['search'];
            }else {
                $ptitle = "No Search Result";
            }
            break;
        default:
            $ptitle = "News Site";
            break;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $ptitle; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                <?php
                  include "config.php";

                  $sql = "SELECT * FROM settings";

                  $result = mysqli_query($conn, $sql) or die("Query Failed.");
                  if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)) {
                        if($row['logo'] == ""){
                            echo '<a href="index.php" id="logo">' . $row['webistename'] . '</a>';
                        }else {
                            echo '<a href="index.php" id="logo"><img src="admin/images/' . $row['logo'] . '"></a>';
                        }
                    }}
                ?>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    include "config.php";
                    if(isset($_GET['cid']))
                        $cid = $_GET['cid'];
                    $query = "select * from category where post > 0";

                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $active = "";
                    ?>
                            <ul class='menu'>
                            <li><a class = '{$active}' href='index.php'>Home</a></li>
                                <?php while ($row = mysqli_fetch_assoc($result)) {
                                     if(isset($_GET['cid'])){
                                    if($row['category_id'] == $cid){
                                        $active = "active";
                                    }else {
                                        $active = "";
                                    }
                                }
                                echo "<li><a class = '{$active}' href='category.php?cid={$row['category_id']}'> {$row['category_name']}</a></li>";
                            } ?>
                            </ul>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->