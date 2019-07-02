<h1 class="page-header">
    Update Comment
    <small><?PHP echo $_SESSION['username']; ?></small>
</h1>
<?php
    if(isset($_GET["updateComment"])) {
        $comment_id = $_GET["updateComment"];
        $getComment = "SELECT C.*, P.post_title, U.user_username, U.user_email FROM comments C INNER JOIN posts P ON C.comment_post_id = P.post_id INNER JOIN users U ON C.comment_user_id = U.user_id WHERE C.comment_id = {$comment_id}";
        $execute_getComment = mysqli_query($connection, $getComment);

        while($row = mysqli_fetch_assoc($execute_getComment)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $post_title = $row['post_title'];
            $user_username = $row['user_username'];
            $user_email = $row['user_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            ?>
            <form action="./comments.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Post</label>
                    <input type="text" class="form-control" value="<?php echo $post_title; ?>" readonly>
                    <input type="hidden" name="update_post_id" value="<?php echo $comment_post_id; ?>">
                </div>
                <div class="form-group">
                    <label for="title">Comment Author</label>
                    <input type="text" class="form-control" value="<?php echo $user_username; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="title">Author's Email</label>
                    <input type="text" class="form-control" value="<?php echo $user_email; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="title">Comment Status</label>
                    <select name="update_status" class="form-control">
                        <option value="2" <?php if($comment_status == 2) {echo "selected";}?>>Approved</option>
                        <option value="1" <?php if($comment_status == 1) {echo "selected";}?>>Pending</option>
                        <option value="0" <?php if($comment_status == 0) {echo "selected";}?>>Denied</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Comment Content</label>
                    <textarea class="form-control" rows="10" cols="30" name="update_content" required><?php echo $comment_content; ?></textarea>
                </div>
                <input type="hidden" name="update_id" value="<?php echo $comment_id ?>">
                <div class="form-group">
                    <a class="ButtonLink" href="./comments.php">Cancel</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="Update Comment" class="btn btn-primary" name="updateComment">
                </div>
            </form>
            <?php
        }
    }
?>