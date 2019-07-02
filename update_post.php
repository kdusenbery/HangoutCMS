<!-- DB Connection -->
<?php include "includes/db.php";?>   
<!-- Header -->
<?php include "includes/header.php";?>    
<!-- Navigation -->
<?php include "includes/navigation.php";?>
<!-- Functions --->
<?php include "functions.php";?>
<!-- Modals --> 
<?php include "includes/modals.php"; ?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Page Header -->
            <h1 class="page-header">
                Update Post
            </h1>
            <!-- Post Form -->
            <?php
                $post_id = $_GET["p_id"];
                $getPost = "SELECT P.*, U.user_username FROM posts P INNER JOIN users U ON P.post_user_id = U.user_id WHERE post_id = {$post_id}";
                $execute_getPost = mysqli_query($connection, $getPost);

                while($row = mysqli_fetch_assoc($execute_getPost)) {
                    $post_id = $row['post_id'];
                    $post_user_id = $row['post_user_id'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $user_username = $row['user_username'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];

                    ?>
                    <form action="index.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Post Title</label>
                            <input type="text" class="form-control" name="update_title" value="<?php echo $post_title; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Post Category</label><br/>
                            <select name="update_category_id" class="form-control" style="width:150px;">
                                <?php
                                    $getCategories = "SELECT * FROM categories";
                                    $execute_getCategories = mysqli_query($connection, $getCategories); 

                                    while($row = mysqli_fetch_assoc($execute_getCategories)) {
                                        $cat_id = $row['cat_id'];
                                        $cat_title = $row['cat_title'];

                                        ?>
                                        <option value="<?php echo $cat_id; ?>" <?php if($cat_id == $post_category_id) {echo "selected";}?>><?php echo $cat_title; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Post Author</label>
                            <input type="text" class="form-control"  value="<?php echo $user_username; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="title">Post Image</label><br/>
                            <?php
                            if($post_image !== "") {
                                ?>
                                <img src="images/<?php echo $post_image; ?>" alt="image" width="100"><br/><br/>
                                <?php
                            }
                            ?>
                            <input type="file" name="update_image">
                        </div>
                        <div class="form-group">
                            <label for="title">Post Tags</label>
                            <input type="text" class="form-control" name="update_tags" value="<?php echo $post_tags; ?>">
                        </div>
                        <div class="form-group">
                            <label for="title">Post Content</label>
                            <textarea class="form-control" rows="10" cols="30" name="update_content" id="ckeditor"><?php echo $post_content; ?></textarea>
                        </div>
                        <input type="hidden" name="update_id" value="<?php echo $post_id; ?>">
                        <div class="form-group">
                            <a class="ButtonLink" href="index.php">Cancel</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" value="Delete Post" class="btn btn-primary" data-toggle="modal" data-target="#myModal_confirmDelete" onclick="deletePost(<?php echo $post_id; ?>,<?php echo $post_user_id; ?>)" style="background-color:red;border-color:red;">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="submit" value="Update Post" class="btn btn-primary" name="updatePost">
                        </div>
                    </form>
                    <?php
                }
            ?>
        </div>
    </div>
    <!-- /.row -->
    <hr>
<!-- Footer -->
<?php include "includes/footer.php";?>
<script>
    function deletePost(id,u_id) {
        var delete_post = "index.php?deletePost=" + id + "&u_id=" +u_id;
        $(".confirm_delete").attr("href", delete_post);
    };
</script>