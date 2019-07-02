<!-- DB Connection -->
<?php include "includes/db.php";?>   
<!-- Header -->
<?php include "includes/header.php";?>    
<!-- Navigation -->
<?php include "includes/navigation.php";?>
<!-- Functions --->
<?php include "functions.php";?> 
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
                if(isset($_GET['catID'])) {
                    $cat_id = $_GET['catID'];
                    
                    $getCategoryTitle = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
                    $execute_getCategoryTitle = mysqli_query($connection, $getCategoryTitle);
                    
                    while($row = mysqli_fetch_assoc($execute_getCategoryTitle)) {
                        $cat_title = $row['cat_title'];
                        
                        echo "<h1 class='page-header'>{$cat_title}</h1>";
                    }
                    
                    $getCategoryPosts = "SELECT P.*, U.user_username FROM posts P INNER JOIN users U ON P.post_user_id = U.user_id WHERE post_category_id = {$cat_id} ORDER BY P.post_date DESC";
                    $execute_getCategoryPosts = mysqli_query($connection, $getCategoryPosts);

                    while($row = mysqli_fetch_assoc($execute_getCategoryPosts)) {
                        $post_id = $row['post_id'];
                        $post_user_id = $row['post_user_id'];
                        $post_title = $row['post_title'];
                        $user_username = $row['user_username'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,100);
                        ?>
                        <!-- Blog Post -->
                        <h2>
                            <a href="post.php?id=<?php echo $post_id ?>"><?php echo $post_title ?></a>&nbsp;
                            <?php
                            if(isset($_SESSION["id"]) && $_SESSION["id"] == $post_user_id) {
                                ?>
                                <a href="update_post.php?p_id=<?php echo $post_id; ?>"><i class="fa fa-fw fa-edit"></i></a>
                                <?php
                            }
                            ?>
                        </h2>
                        <p class="lead">
                            by <a href="index.php?p_u_id=<?php echo $post_user_id; ?>"><?php echo $user_username ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                        <hr>
                        <a href="post.php?id=<?php echo $post_id ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>

                        <?php
                    }
                }
            ?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php";?> 
    </div>
    <!-- /.row -->
    <hr>
<!-- Footer -->
<?php include "includes/footer.php";?> 