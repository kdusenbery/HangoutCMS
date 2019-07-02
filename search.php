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
                if(isset($_POST['submit'])) {
                    $search = $_POST['search'];
                    $getResults = "SELECT P.*, U.user_username FROM posts P INNER JOIN users U ON P.post_user_id = U.user_id WHERE post_tags LIKE '%$search%' ORDER BY P.post_date DESC";
                    $execute_getResults = mysqli_query($connection, $getResults);

                    if(!$execute_getResults) {
                        die("did not work") . mysqli_error($connection);
                    } else {
                        $count = mysqli_num_rows($execute_getResults);
                        if($count == 0) {
                            echo "<h1>No Results</h1>";
                        } else {
                            while($row = mysqli_fetch_assoc($execute_getResults)) {
                                $post_id = $row['post_id'];
                                $post_user_id = $row['post_user_id'];
                                $post_title = $row['post_title'];
                                $user_username = $row['user_username'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = substr($row['post_content'],0,100);

                                ?>
                                <!-- Page Header -->
                                <h1 class="page-header">
                                    Search results for "<?php echo $search; ?>"
                                </h1>

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
                                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                                <hr>
                                <p><?php echo $post_content ?></p>
                                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                                <hr>
                                <?php
                            }
                        }
                    } 
                } ?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php";?> 
    </div>
    <!-- /.row -->
    <hr>
<!-- Footer -->
<?php include "includes/footer.php";?> 