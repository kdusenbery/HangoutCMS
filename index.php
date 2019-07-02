<!-- Header -->
<?php include "includes/header.php";?>   
<!-- DB Connection -->
<?php include "includes/db.php";?> 
<!-- Navigation -->
<?php include "includes/navigation.php";?>
<!-- Functions --->
<?php include "functions.php";?> 
<?php create_profile(); login(); logOut(); create_post(); update_post(); delete_post(); add_comment(); contact_us(); ?> 
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- Page Header -->
            <h1 class="page-header">
                Home Page
            </h1>
            <?php
                $getPosts = "SELECT P.*, U.user_username FROM posts P INNER JOIN users U ON P.post_user_id = U.user_id WHERE post_status = 2";
                if(isset($_GET["p_u_id"])) {
                    $p_u_id = $_GET["p_u_id"];
                    $getPosts .= " AND post_user_id = {$p_u_id}";
                }
                $getPosts .= " ORDER BY P.post_date DESC";
                $execute_getPosts = mysqli_query($connection, $getPosts);
                
                while($row = mysqli_fetch_assoc($execute_getPosts)) {
                    $post_id = $row['post_id'];
                    $post_user_id = $row['post_user_id'];
                    $post_title = $row['post_title'];
                    $user_username = $row['user_username'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'],0,250);
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
                        by <a href="index.php?p_u_id=<?php echo $post_user_id; ?>"><?php echo $user_username; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                    <hr>
                    <a href="post.php?id=<?php echo $post_id; ?>">
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content ?>...</p>
                    <a class="btn btn-primary" href="post.php?id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
                    <?php
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