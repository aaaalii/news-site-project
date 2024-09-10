<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <?php
                  //php code to get users from db
                    include "config.php";
                    $limit = 2;

                    if(isset($_GET['page']))
                        $page = $_GET['page'];
                    else
                        $page = 1;

                    $offset = ($page - 1) * $limit;

                    if($_SESSION['user_role'] == '1'){
                        $query = "select post.post_id, post.title, post.description, post.post_date,
                        category.category_name, user.username, post.category from post
                        left join category on post.category = category.category_id
                        left join user on post.author = user.user_id
                        order by post.post_id desc limit {$offset},{$limit}";
                    }else if($_SESSION["user_role"] == '0'){
                        $query = "select post.post_id, post.title, post.description, post.post_date,
                        category.category_name, user.username, post.category from post
                        left join category on post.category = category.category_id
                        left join user on post.author = user.user_id
                        where post.author = {$_SESSION['user_id']}
                        order by post.post_id desc limit {$offset},{$limit}";
                    }

                    //$query = "select * from user order by user_id desc";

                    $result = mysqli_query($conn, $query) or die("Query Unsuccesfull");
                    if(mysqli_num_rows($result) > 0){
                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php
                            while($row = mysqli_fetch_assoc($result)){
                        ?>
                          <tr>
                              <td class='id'><?php echo $row['post_id']?></td>
                              <td><?php echo $row['title']?></td>
                              <td><?php echo $row['category_name']?></td>
                              <td><?php echo $row['post_date']?></td>
                              <td><?php echo $row['username']?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id']?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id']?>&catid=<?php echo $row['category']?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>            
                          <?php }?>
                      </tbody>
                  </table>
                  <?php
                }
                else{
                    echo "No records found";
                }

                if($_SESSION['user_role'] == 1){
                    $query1 = "select * from post";
                }else{
                    $query1 = "select * from post where author = {$_SESSION['user_id']}";
                }
                    $result1 = mysqli_query($conn, $query1) or die("Unsuccessful");

                    if(mysqli_num_rows($result1)){
                        $total_records = mysqli_num_rows($result1);
                        //$limit = 1;
                        $total_pages = ceil($total_records / $limit);
                        //echo $total_records;
                        
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){
                            echo '<li><a href="post.php?page=' . ($page - 1) . ' ">Prev</a></li>';
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
                            echo "<li class = '$active'><a href ='post.php?page=". $i . "'>" . $i . "</a></li>";
                        }
                        if($total_pages > $page){
                            echo '<li><a href="post.php?page=' . ($page + 1) . ' ">Next</a></li>';
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
