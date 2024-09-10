<?php include "header.php";
if ($_SESSION['user_role'] == 0) {
    include "config.php";
    $query2 = "select author from post where post_id = {$_GET['id']}";

    $result2 = mysqli_query($conn, $query2) or die("Query Unsuccesfull");
    $row2 = mysqli_fetch_assoc($result2);

    if($row2['author'] != $_SESSION['user_id']){
        header("Location: post.php");
    }
}
?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <?php

                $query = "select post.post_id, post.title, post.description, post.post_img,
                category.category_name, post.category from post
                left join category on post.category = category.category_id
                left join user on post.author = user.user_id
                where post_id = {$_GET['id']}";

                $result = mysqli_query($conn, $query) or die("Query Unsuccesfull");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <!-- Form for show edit-->
                        <form action="save-update-post.php?pre-cat-id=<?php echo $row['category']?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <input type="hidden" name="post_id" class="form-control" value="<?php echo $_GET['id']?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputTile">Title</label>
                                <input type="text" name="post_title" class="form-control" id="exampleInputUsername" value="<?php echo $row['title']?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"> Description</label>
                                <textarea name="postdesc" class="form-control" required rows="5">
                                <?php echo $row['description']?>                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCategory">Category</label>
                                <select class="form-control" name="category" value = "<?php echo $row['category']?>">
                                <option disabled> Select Category</option>
                              <?php
                                    $query1 = "select * from category";
                                    $result1 = mysqli_query($conn, $query1) or die("Query failed");
                                
                                    if(mysqli_num_rows($result1) > 0){
                                        while($row1 = mysqli_fetch_assoc($result1)){
                                            if($row['category'] == $row1['category_id']){
                                                $select = "selected";
                                            }else{
                                                $select = "";
                                            }
                                            echo "<option {$select} value = {$row1['category_id']}>{$row1['category_name']}</option>";
                                        }
                                    }
                              ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Post image</label>
                                <input type="file" name="new-image">
                                <img src="upload/<?php echo $row['post_img']?>" height="150px">
                                <input type="hidden" name="old-image" value="<?php echo $row['post_img']?>">
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </form>
                <?php }
                }else{
                    echo "Result not found";
                } ?>
                <!-- Form End -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>