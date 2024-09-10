<?php include "header.php"; 
    if($_SESSION['user_role'] == 0){
        header("Location: post.php");
    }
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <?php
                    include "config.php";

                    $limit = 2;

                    if(isset($_GET['page']))
                        $page = $_GET['page'];
                    else
                        $page = 1;

                    $offset = ($page - 1) * $limit;

                    $query = "select * from category order by category_id desc limit {$offset},{$limit}";

                    $result = mysqli_query($conn, $query) or die("Query Unsuccesfull");
                    if(mysqli_num_rows($result) > 0){
                ?>
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php 
                            while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td class='id'><?php echo $row["category_id"]?></td>
                            <td><?php echo $row["category_name"]?></td>
                            <td><?php echo $row["post"]?></td>

                            <td class='edit'><a href='update-category.php?id=<?php echo $row["category_id"]?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $row["category_id"]?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <?php
                    }else{
                        echo "No records found";
                    }

                    $query1 = "select * from category";
                    $result1 = mysqli_query($conn, $query1) or die("Unsuccessful");

                    if(mysqli_num_rows($result1)){
                        $total_records = mysqli_num_rows($result1);
                        //$limit = 1;
                        $total_pages = ceil($total_records / $limit);
                        
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){
                            echo '<li><a href="category.php?page=' . ($page - 1) . ' ">Prev</a></li>';
                        }
                        for($i = 1; $i <= $total_pages; $i++){
                            // echo $total_pages;
                            // echo $total_records;
                            // echo $limit;
                            if($i == $page){
                                $active = "active";
                            }
                            else
                                $active = "";
                            echo "<li class = '$active'><a href ='category.php?page=". $i . "'>" . $i . "</a></li>";
                        }
                        if($total_pages > $page){
                            echo '<li><a href="category.php?page=' . ($page + 1) . ' ">Next</a></li>';
                        }
                    }
                ?>
                <!-- <ul class='pagination admin-pagination'>
                    <li class="active"><a>1</a></li>
                    <li><a>2</a></li>
                    <li><a>3</a></li>
                </ul> -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
