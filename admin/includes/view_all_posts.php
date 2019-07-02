<?php include "modals.php"; ?>
<h1 class="page-header">
    View All Posts
    <small><?PHP echo $_SESSION['username']; ?></small>
</h1>
<div class="col-xs-6" style="padding-left:0;">
    <?php
        $getApproval = "SELECT post_approval FROM approval WHERE approval_id = 1";
        $execute_getApproval = mysqli_query($connection, $getApproval);
            
        while($row = mysqli_fetch_assoc($execute_getApproval)) {
            $post_approval = $row["post_approval"];
        }
    ?>
    <div class="form-group" style="float:left;margin-right:50px">
        <label for="post_approval">Approval Required:</label><br/>
        <select name="post_approval" id="post_approval" class="form-control" style="width:150px;display:inline;">
            <option value="1" <?php if($post_approval == 1){echo "selected";} ?>>Yes</option>
            <option value="0" <?php if($post_approval == 0){echo "selected";} ?>>No</option>
        </select>
    </div>
    <?php
        if(isset($_POST["status"]) && $_POST["status"] !== "") {
            $status = $_POST["status"]; 
        } else {
            $status = '';
        }
    ?>
    <form action="./posts.php" method="post">
        <div class="form-group">
            <label for="status">Status:</label><br/>
            <select name="status" id="status" class="form-control" style="width:150px;display:inline;">
                <option value="" <?php if($status == ''){echo "selected";} ?>>All</option>
                <option value="2" <?php if($status == '2'){echo "selected";} ?>>Approved</option>
                <option value="1" <?php if($status == '1'){echo "selected";} ?>>Pending</option>
                <option value="0" <?php if($status == '0'){echo "selected";} ?>>Denied</option>
            </select>
            <input type="submit" value="Filter" class="btn btn-primary">
        </div>
    </form>
</div>
<div class="col-xs-6" style="padding-top:20px;">
    <?php
        if(isset($_GET['updatePostSuccess']) && $_GET['updatePostSuccess'] =='1') {
            ?>
            <span style='color:green;'>Post Updated successfully</span>
            <?php
        } elseif(isset($_GET['deletePostSuccess']) && $_GET['deletePostSuccess'] =='1') {
            ?>
            <span style='color:green;'>Post Deleted successfully</span>
            <?php
        }
    ?>
    <span id="approvalChange" style='color:green;'></span>
</div>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Author</th>
            <th>Image</th>
            <th>Category</th>
            <th>Tags</th>
            <th>Views</th>
            <th>Comments</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $getPosts = "SELECT P.*, C.cat_title, U.user_username FROM posts P INNER JOIN categories C ON P.post_category_id = C.cat_id INNER JOIN users U ON P.post_user_id = U.user_id";
            if(isset($_POST["status"]) && $_POST["status"] !== "") {
                $getPosts .= " AND P.post_status = {$status}";
            }
            $getPosts .= " ORDER BY P.post_id";
            $execute_getPosts = mysqli_query($connection, $getPosts);
            
            while($row = mysqli_fetch_assoc($execute_getPosts)) {
                $post_id = $row['post_id'];
                $user_username = $row['user_username'];
                $post_title = $row['post_title'];
                $cat_title = $row['cat_title'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_view_count = $row['post_view_count'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];
                
                if($post_status == 2) {
                    $post_status = "Approved";
                } elseif($post_status == 1) {
                    $post_status = "Pending";
                } else {
                    $post_status = "Denied";
                }

                ?>
                <tr>
                    <td><?php echo $post_id; ?></td>
                    <td><a href="../post.php?id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></td>
                    <td><?php echo $user_username; ?></td>
                    <td>
                    <?php
                        if($row['post_image'] == "" || empty($row['post_image'])) {
                            echo "No Image";
                        } else {
                            ?>
                            <img src="../images/<?php echo $post_image; ?>" alt="image" width="100">
                            <?php
                        }
                    ?>
                    </td>
                    <td><?php echo $cat_title; ?></td>
                    <td><?php echo $post_tags; ?></td>
                    <td><?php echo $post_view_count; ?></td>
                    <td><?php echo $post_comment_count; ?></td>
                    <td><?php echo $post_status; ?></td>
                    <td><?php echo $post_date; ?></td>
                    <td>
                       <?php
                             if($post_status == "Pending") {
                                ?>
                                    <a href="posts.php?p_id=<?php echo $post_id; ?>&p_status=2" style="color:green;">Approve</a>&nbsp
                                    <a href="posts.php?p_id=<?php echo $post_id; ?>&p_status=0" style="color:orange;">Deny</a>&nbsp
                                <?php 
                             }
                        ?>
                        <a href="posts.php?source=update_post&updatePost=<?php echo $post_id; ?>" style="color:blue;">Update</a>&nbsp
                        <a href="" data-toggle="modal" data-target="#myModal_confirmDelete" onclick="deletePost(<?php echo $post_id; ?>)" style="color:red;">Delete</a>
                    </td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>
<script>
    function deletePost(id) {
        var delete_post = "posts.php?page=posts&deletePost=" + id;
        $(".confirm_delete").attr("href", delete_post);
    };
    
    $("#post_approval").change(function() {
        var option = $(this).val();
        var url = ("functions.php?postApprovalOption=" + option);
        $.get(url, function(data) {
            if(option == 1) {
                $("#approvalChange").html("Posts will now require approval before being displayed.");
            } else {
                $("#approvalChange").html("Posts will now be displayed without requiring approval.")
            }
        });
    });
</script>