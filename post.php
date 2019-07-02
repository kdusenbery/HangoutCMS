<!-- DB Connection -->
<?php include "includes/db.php";?>   
<!-- Header -->
<?php include "includes/header.php";?>    
<!-- Navigation -->
<?php include "includes/navigation.php";?>
<!-- Functions --->
<?php include "functions.php";?> 
<style>
    i.fa-thumbs-up:hover {
        cursor:pointer;
    }
</style>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
                if(isset($_GET['id'])) {
                    $post_id = $_GET['id'];
                    
                    $updatePostViews = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = {$post_id}";
                    $execute_updatePostViews = mysqli_query($connection, $updatePostViews);
                    
                    $getPost = "SELECT P.*, U.user_username FROM posts P INNER JOIN users U ON P.post_user_id = U.user_id WHERE post_id = {$post_id}";
                    $execute_getPost = mysqli_query($connection, $getPost);

                    while($row = mysqli_fetch_assoc($execute_getPost)) {
                        $post_id = $row['post_id'];
                        $post_user_id = $row['post_user_id'];
                        $post_title = $row['post_title'];
                        $user_username = $row['user_username'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_view_count = $row['post_view_count'];
                        $post_content = $row['post_content'];
                        ?>
                        <!-- Blog Post -->
                        <h2>
                            <a href="post.php?id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                            <?php
                            if(isset($_SESSION["id"]) && $_SESSION["id"] == $post_user_id) {
                                ?>
                                <a href="update_post.php?p_id=<?php echo $post_id; ?>"><i class="fa fa-fw fa-edit"></i></a>
                                <?php
                            }
                            ?>
                        </h2>
                        <p class="lead">
                            by <a href="index.php?p_u_id=<?php echo $post_user_id; ?>"><?php echo $user_username; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                        <hr>
                        <?php
                        if($post_image !== "") {
                            ?>
                            <a href="post.php?id=<?php echo $post_id ?>">
                                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="image">
                            </a>
                            <?php
                        } else {
                            ?>
                            <span>No Image</span>
                            <?php
                        }
                        ?>
                        
                        <p style="padding-top:20px;">
                            <span style="color:red;">Views: <?php echo $post_view_count; ?></span>&nbsp;
                        </p>
                        
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <hr>
                        <?php
                    }
                    
                    if(isset($_SESSION['id'])) {
                        ?>
                        <!-- Comments Form -->
                        <div class="well">
                            <h4>Leave a Comment:</h4>
                            <form action="index.php" method="post">
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" name="content" placeholder="Comment" required></textarea>
                                </div>
                                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                <button type="submit" class="btn btn-primary" name="addComment">Submit</button>
                            </form>
                        </div>
                        <hr>
                        <?php
                    }
                    
                    $getComments = "SELECT C.*, U.user_username, U.user_image FROM comments C INNER JOIN users U ON C.comment_user_id = U.user_id WHERE comment_post_id = {$post_id} AND comment_status = 2 ORDER BY comment_date ASC"; 
                    $execute_getComments = mysqli_query($connection, $getComments);

                    while($row = mysqli_fetch_assoc($execute_getComments)) {
                        $user_username = $row['user_username'];
                        $user_image = $row['user_image'];
                        $comment_content = $row['comment_content'];
                        $comment_date = $row['comment_date'];
                        ?>
                        <!-- Posted Comments -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="images/<?php echo $user_image; ?>" alt="image" width="40">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $user_username; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>
                        <!-- Nested Comment -->
<!--
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
-->
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