<h1 class="page-header">
    Update Post
    <small><?PHP echo $_SESSION['username']; ?></small>
</h1>
<?php
    if(isset($_GET["updatePost"])) {
        $post_id = $_GET["updatePost"];
        $getPost = "SELECT P.*, U.user_username FROM posts P INNER JOIN users U ON P.post_user_id = U.user_id WHERE post_id = {$post_id}";
        $execute_getPost = mysqli_query($connection, $getPost);

        while($row = mysqli_fetch_assoc($execute_getPost)) {
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $user_username = $row['user_username'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_content = $row['post_content'];

            ?>
            <form action="./posts.php" method="post" enctype="multipart/form-data">
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
                    <label for="title">Post Status</label>
                    <select name="update_status" class="form-control">
                        <option value="2" <?php if($post_status == 2) {echo "selected";}?>>Approved</option>
                        <option value="1" <?php if($post_status == 1) {echo "selected";}?>>Pending</option>
                        <option value="0" <?php if($post_status == 0) {echo "selected";}?>>Denied</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Post Image</label><br/>
                    <?php
                    if($post_image !== "") {
                        ?>
                        <img src="../images/<?php echo $post_image; ?>" alt="image" width="100"><br/><br/>
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
                    <a class="ButtonLink" href="./posts.php">Cancel</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="Update Post" class="btn btn-primary" name="updatePost">
                </div>
            </form>
            <?php
        }
    }
?>