<?php include "header.php"; 
    if($_SESSION['user_role'] == 0){
        header("Location: post.php");
    }
?>

<?php
if (isset($_POST['submit'])) {
    include 'config.php';

    // to validate input data, used in-built function of mysqli, and for password hashing used md5()
    $cat_id = $_POST['cat_id'];
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);

    $query = "select category_name from category where category_name = '{$cat_name}'";
    $result = mysqli_query($conn, $query) or die("Query failed");

    if(mysqli_num_rows($result) > 0){
        echo "<p>Category already exists. </p>";
    }
    else{
        $query1 = "update category set category_name = '{$cat_name}' where category_id = '{$cat_id}'";
        // echo $query1;
        // die();
        if(mysqli_query($conn, $query1)){
            header("Location: category.php");
        }
        else{
            echo "update failed";
        }
    }
    //header("Location: users.php");
}else{
    echo "Button not set";
}
?>

  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
              <?php
                include "config.php";

                $query = "select category_name, category_id from category where category_id = {$_GET['id']}";

                $result = mysqli_query($conn, $query) or die("Query Unsuccesfull");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                  <form action="<?php $_SERVER['PHP_SELF']?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['category_id']?>">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <?php }}?>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
