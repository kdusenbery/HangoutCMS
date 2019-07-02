<?php include "modals.php"; ?>
<h1 class="page-header">
    View All Comments
    <small><?PHP echo $_SESSION['username']; ?></small>
</h1>
<div class="col-xs-6" style="padding-left:0;">
    <?php
        $getApproval = "SELECT comment_approval FROM approval WHERE approval_id = 1";
        $execute_getApproval = mysqli_query($connection, $getApproval);
            
        while($row = mysqli_fetch_assoc($execute_getApproval)) {
            $comment_approval = $row["comment_approval"];
        }
    ?>
    <div class="form-group" style="float:left;margin-right:50px">
        <label for="comment_approval">Approval Required:</label><br/>
        <select name="comment_approval" id="comment_approval" class="form-control" style="width:150px;display:inline;">
            <option value="1" <?php if($comment_approval == 1){echo "selected";} ?>>Yes</option>
            <option value="0" <?php if($comment_approval == 0){echo "selected";} ?>>No</option>
        </select>
    </div>
    <?php
        if(isset($_POST["status"]) && $_POST["status"] !== "") {
            $status = $_POST["status"]; 
        } else {
            $status = '';
        }
    ?>
    <form action="./comments.php" method="post">
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
<div class="col-xs-6" style="padding-right:0;padding-top:20px;">
    <?php
        if(isset($_GET['updateCommentSuccess']) && $_GET['updateCommentSuccess'] =='1') {
            ?>
            <span style='color:green;'>Comment Updated successfully</span>
            <?php
        } elseif(isset($_GET['deleteCommentSuccess']) && $_GET['deleteCommentSuccess'] =='1') {
            ?>
            <span style='color:green;'>Comment Deleted successfully</span>
            <?php
        }
    ?>
    <span id="approvalChange" style='color:green;'></span>
</div>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Post Title</th>
            <th>Author</th>
            <th>Email</th>
            <th>Content</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $getComments = "SELECT C.*, P.post_title, U.user_username, U.user_email FROM comments C INNER JOIN posts P ON C.comment_post_id = P.post_id INNER JOIN users U ON C.comment_user_id = U.user_id"; 
            if(isset($_POST["status"]) && $_POST["status"] !== "") {
                $getComments .= " AND C.comment_status = {$status}";
            }
            $getComments .= " ORDER BY C.comment_id";
            $execute_getComments = mysqli_query($connection, $getComments);
        
            while($row = mysqli_fetch_assoc($execute_getComments)) {
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $post_title = $row['post_title'];
                $user_username = $row['user_username'];
                $user_email = $row['user_email'];
                $comment_content = $row['comment_content'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];
                
                if($comment_status == 2) {
                    $comment_status = "Approved";
                } elseif($comment_status == 1) {
                    $comment_status = "Pending";
                } else {
                    $comment_status = "Denied";
                }

                ?>
                <tr>
                    <td><?php echo $comment_id; ?></td>
                    <td><a href="../post.php?id=<?php echo $comment_post_id; ?>"><?php echo $post_title; ?></a></td>
                    <td><?php echo $user_username; ?></td>
                    <td><?php echo $user_email; ?></td>
                    <td><?php echo $comment_content; ?></td>
                    <td><?php echo $comment_status; ?></td>
                    <td><?php echo $comment_date; ?></td>
                    <td>
                        <?php
                             if($comment_status == "Pending") {
                                ?>
                                    <a href="comments.php?c_id=<?php echo $comment_id; ?>&p_id=<?php echo $comment_post_id; ?>&c_status=2" style="color:green;">Approve</a>&nbsp
                                    <a href="comments.php?c_id=<?php echo $comment_id; ?>&p_id=<?php echo $comment_post_id; ?>&c_status=0" style="color:orange;">Deny</a>&nbsp
                                <?php 
                             }
                        ?>
                        <a href="comments.php?source=update_comment&updateComment=<?php echo $comment_id; ?>" style="color:blue;">Update</a>&nbsp
                        <a href="" data-toggle="modal" data-target="#myModal_confirmDelete" onclick="deleteComment(<?php echo $comment_id; ?>)" style="color:red;">Delete</a>
                    </td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>
<script>
    function deleteComment(id) {
        var delete_comment = "comments.php?page=comments&deleteComment=" + id;
        $(".confirm_delete").attr("href", delete_comment);
    };
    
    $("#comment_approval").change(function() {
        var option = $(this).val();
        var url = ("functions.php?commentApprovalOption=" + option);
        $.get(url, function(data) {
            if(option == 1) {
                $("#approvalChange").html("Comments will now require approval before being displayed.");
            } else {
                $("#approvalChange").html("Comments will now be displayed without requiring approval.")
            }
        });
    });
</script>