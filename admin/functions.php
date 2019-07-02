<?php
    function checkQuery($query) {
        global $connection;
        if(!$query) {
            die('Query Failed' . mysqli_error($connection));
        }
    }

    // USER FUNCTIONS

    function add_user() {
        global $connection;
        if(isset($_POST['addUser'])) {
            $user_image = $_FILES['image']['name'];
                $user_image_temp = $_FILES['image']['tmp_name'];
                move_uploaded_file($user_image_temp, "../images/$user_image");
            $user_username = $_POST['username'];
            $user_password = $_POST['password'];
                $hash = "$2y$10$";
                $salt = "thisiswhatencryptionlookslike87";
                $hash_salt = $hash . $salt;
                $var_encrypted = crypt($user_password, $hash_salt);
            $user_firstName = $_POST['firstName'];
            $user_lastName = $_POST['lastName'];
            $user_email = $_POST['email'];
            $user_role_id = $_POST['role_id'];
            
            $insertUser = 
                "INSERT INTO users(user_image,user_username,user_password,user_firstName,user_lastName,user_email,user_role_id,user_randSalt,user_date) VALUE('{$user_image}','{$user_username}','{$user_password}','{$user_firstName}','{$user_lastName}','{$user_email}','{$user_role_id}','{$var_encrypted}',now())";
            $execute_insertUser = mysqli_query($connection, $insertUser);

            checkQuery($execute_insertUser);
            
            header("Location: users.php?page=users&addUserSuccess=1");
        }
    }

    function update_user() {
        global $connection;
        if (isset($_POST["updateUser"])) {
            $user_id = $_POST['update_id'];
            $user_image = $_FILES['update_image']['name'];
                $user_image_temp = $_FILES['update_image']['tmp_name'];
                move_uploaded_file($user_image_temp, "../images/$user_image");

                if(empty($user_image)) {
                    $getImage = "SELECT user_image FROM users WHERE user_id = {$user_id}";
                    $execute_getImage = mysqli_query($connection, $getImage);

                    while($row = mysqli_fetch_assoc($execute_getImage)) {
                         $user_image = $row['user_image'];  
                    }
                }
            $user_username = $_POST['update_username'];
            $user_password = $_POST['update_password'];
                $hash = "$2y$10$";
                $salt = "thisiswhatencryptionlookslike87";
                $hash_salt = $hash . $salt;
                $var_encrypted = crypt($user_password, $hash_salt);
            $user_firstName = $_POST['update_firstName'];
            $user_lastName = $_POST['update_lastName'];
            $user_email = $_POST['update_email'];
            $user_role_id = $_POST['update_role_id'];
            
            $updateUser = "UPDATE users SET user_image = '{$user_image}',user_username = '{$user_username}',user_password = '{$user_password}',user_firstName = '{$user_firstName}',user_lastName = '{$user_lastName}',user_email = '{$user_email}',user_role_id = '{$user_role_id}',user_randSalt = '{$var_encrypted}' WHERE user_id = {$user_id}";
            $execute_updateUser = mysqli_query($connection, $updateUser);

            checkQuery($execute_updateUser);
            
            if(isset($_GET['profile']) && $_GET['profile'] == '1') {
                header("Location: profile.php?page=profile&profile=1");
            } else {
                header("Location: users.php?page=users&updateUserSuccess=1");
            }
        }
    }

    function delete_user() {
        global $connection;
        if (isset($_GET['deleteUser'])) {
            $delete_user_id = $_GET['deleteUser'];
            
            $deleteUserComments = "DELETE FROM comments WHERE comment_user_id = {$delete_user_id}";
            $execute_deleteComments = mysqli_query($connection, $deleteUserComments);
            
            $deleteUserPosts = "DELETE FROM posts WHERE post_user_id = {$delete_user_id}";
            $execute_deleteUserPosts = mysqli_query($connection, $deleteUserPosts);
            
            $deleteUser = "DELETE FROM users WHERE user_id = {$delete_user_id}";
            $execute_deleteUser = mysqli_query($connection, $deleteUser);
            
            header("Location: users.php?page=users&deleteUserSuccess=1");
        }
    }

    // CATEGORY FUNCTIONS

    function findAllCategories() {
        global $connection;
        $getCategories = "SELECT * FROM categories";
        $execute_getCategories = mysqli_query($connection, $getCategories);

        while($row = mysqli_fetch_assoc($execute_getCategories)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            ?>
            <tr>
                <td><?php echo $cat_id; ?></td>
                <td><?php echo $cat_title; ?></td>
                <td>
                    <a href="categories.php?updateCat=<?php echo $cat_id; ?>" style="color:blue;">Update</a>&nbsp
                    <a href="categories.php?deleteCat=<?php echo $cat_id; ?>" style="color:red;">Delete</a>
                </td>
            </tr>
            <?php
        }
    }

    function insert_category() {
        global $connection;
        if(isset($_POST["addCat"])) {
            $cat_title = $_POST["cat_title"];

            if($cat_title == "" || empty($cat_title)) {
                echo "Please insert a category name";   
            } else {
                $insertCategory = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
                $execute_insertCategory = mysqli_query($connection, $insertCategory);

                checkQuery($execute_insertCategory);
            }
        } 
    }

    function updateCategorySection() {
        global $connection;
        if(isset($_GET['updateCat'])) {
            $selected_cat_id = $_GET['updateCat'];
            
            $getSelectedCategory = "SELECT * FROM categories WHERE cat_id = {$selected_cat_id}";
            $execute_getSelectedCategory = mysqli_query($connection, $getSelectedCategory);
            
            while($row = mysqli_fetch_assoc($execute_getSelectedCategory)) {
                $cat_id_update = $row['cat_id'];
                $cat_title_update = $row['cat_title'];

                ?>
                <form action="categories.php" method="post">
                    <div class="form-group">
                        <label for="cat_title">Update Category</label><br />
                        <input type="text" name="update_cat_title" value="<?php echo $cat_title_update; ?>" class="form-control" style="width:150px;display:inline;">
                        <input type="hidden" name="update_cat_id" value="<?php echo $cat_id_update; ?>">
                        <input type="submit" name="updateCat" value="Update" class="btn btn-primary">
                    </div>
                </form>
                <?php
            }
        }
    }

    function update_category() {
        global $connection;
        if(isset($_POST["updateCat"])) {
            $cat_id = $_POST["update_cat_id"];
            $cat_title = $_POST["update_cat_title"];

            if($cat_title == "" || empty($cat_title)) {
                echo "The new category name cannot be empty";   
            } else {
                $updateCategory = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$cat_id}";
                $execute_updateCategory = mysqli_query($connection, $updateCategory);

                checkQuery($execute_updateCategory);
            }
        }
    }

    function delete_category() {
        global $connection;
        if(isset($_GET['deleteCat'])) {
            $delete_cat_id = $_GET['deleteCat'];
            
            $deleteCategories = "DELETE FROM categories WHERE cat_id = {$delete_cat_id}";
            $execute_deleteCategories = mysqli_query($connection, $deleteCategories);
            
            header("Location: categories.php?page=categories");
        }
    }
    
    // POST FUNCTIONS

    function post_status() {
        global $connection;
        if (isset($_GET["p_status"])) {
            $post_id = $_GET["p_id"];
            $post_status = $_GET["p_status"];

            $updatePost = "UPDATE posts SET post_status = {$post_status} WHERE post_id = {$post_id}";
            $execute_updatePost = mysqli_query($connection, $updatePost);

            checkQuery($execute_updatePost);
            
            header("Location: posts.php?page=posts");
        }
    }

    function post_approval() {
        if (isset($_GET["postApprovalOption"])) {
            include("../includes/db.php");
            
            $post_approval = $_GET["postApprovalOption"];

            $updateApproval = "UPDATE approval SET post_approval = {$post_approval} WHERE approval_id = 1";
            $execute_updateApproval = mysqli_query($connection, $updateApproval);

            checkQuery($execute_updateApproval);
        }
    }

    post_approval();

    function update_post() {
        global $connection;
        if (isset($_POST["updatePost"])) {
            $post_id = $_POST['update_id'];
            $post_title = $_POST['update_title'];
            $post_category_id = $_POST['update_category_id'];
            $post_status = $_POST['update_status'];
            $post_image = $_FILES['update_image']['name'];
                $post_image_temp = $_FILES['update_image']['tmp_name'];
                move_uploaded_file($post_image_temp, "../images/$post_image");
                if(empty($post_image)) {
                    $getImage = "SELECT post_image FROM posts WHERE post_id = {$post_id}";
                    $execute_getImage = mysqli_query($connection, $getImage);

                    while($row = mysqli_fetch_assoc($execute_getImage)) {
                         $post_image = $row['post_image'];  
                    }
                }
            $post_tags = $_POST['update_tags'];
            $post_content = $_POST['update_content'];

            $updatePost = "UPDATE posts SET post_title = '{$post_title}', post_category_id = '{$post_category_id}', post_status = {$post_status}, post_image = '{$post_image}', post_tags = '{$post_tags}', post_content = '{$post_content}' WHERE post_id = {$post_id}";
            $execute_updatePost = mysqli_query($connection, $updatePost);

            checkQuery($execute_updatePost);
            
            header("Location: posts.php?page=posts&updatePostSuccess=1");
        }
    }

    function delete_post() {
        global $connection;
        if (isset($_GET['deletePost'])) {
            $delete_post_id = $_GET['deletePost'];
            
            $deleteComments = "DELETE FROM comments WHERE comment_post_id = {$delete_post_id}";
            $execute_deleteComments = mysqli_query($connection, $deleteComments);
            
            $deletePost = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
            $execute_deletePost = mysqli_query($connection, $deletePost);
            
            header("Location: posts.php?page=posts&deletePostSuccess=1");
        }
    }

    // COMMENT FUNCTIONS

    function comment_status() {
        global $connection;
        if (isset($_GET["c_status"])) {
            $comment_id = $_GET["c_id"];
            $comment_post_id = $_GET["p_id"];
            $comment_status = $_GET["c_status"];
            
            if($comment_status == 2) {
                $updatePost = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = {$comment_post_id}";
                $execute_updatePost = mysqli_query($connection, $updatePost);

                checkQuery($execute_updatePost);
            }

            $updateComment = "UPDATE comments SET comment_status = {$comment_status} WHERE comment_id = {$comment_id}";
            $execute_updateComment = mysqli_query($connection, $updateComment);

            checkQuery($execute_updateComment);
            
            header("Location: comments.php?page=comments");
        }
    }

    function comment_approval() {
        if (isset($_GET["commentApprovalOption"])) {
            include("../includes/db.php");
            
            $comment_approval = $_GET["commentApprovalOption"];

            $updateApproval = "UPDATE approval SET comment_approval = {$comment_approval} WHERE approval_id = 1";
            $execute_updateApproval = mysqli_query($connection, $updateApproval);

            checkQuery($execute_updateApproval);
        }
    }

    comment_approval();

    function update_comment() {
        global $connection;
        if (isset($_POST["updateComment"])) {
            $comment_id = $_POST['update_id'];
            $comment_post_id = $_POST['update_post_id'];
            $comment_content = $_POST['update_content'];
            $comment_status = $_POST['update_status'];
            
            $getCommentStatus = "SELECT comment_status FROM comments WHERE comment_id = {$comment_id}";
            $execute_getCommentStatus = mysqli_query($connection, $getCommentStatus);

            while($row = mysqli_fetch_assoc($execute_getCommentStatus)) {
                $getComment_status = $row['comment_status'];

                if($getComment_status !== '2' && $comment_status == 2) {
                    $updatePost = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = {$comment_post_id}";
                    $execute_updatePost = mysqli_query($connection, $updatePost);

                    checkQuery($execute_updatePost);
                } elseif($getComment_status == 2 && $comment_status !== '2') {
                    $updatePost = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = {$comment_post_id}";
                    $execute_updatePost = mysqli_query($connection, $updatePost);

                    checkQuery($execute_updatePost);
                }
            }
            
            $updateComment = "UPDATE comments SET comment_content = '{$comment_content}',comment_status = {$comment_status} WHERE comment_id = {$comment_id}";
            $execute_updateComment = mysqli_query($connection, $updateComment);

            checkQuery($execute_updateComment);
            
            header("Location: comments.php?page=comments&updateCommentSuccess=1");
        }
    }

    function delete_comment() {
        global $connection;
        if (isset($_GET['deleteComment'])) {
            $delete_comment_id = $_GET['deleteComment'];
            
            $getCommentStatus = "SELECT comment_post_id,comment_status FROM comments WHERE comment_id = {$delete_comment_id}";
            $execute_getCommentStatus = mysqli_query($connection, $getCommentStatus);

            while($row = mysqli_fetch_assoc($execute_getCommentStatus)) {
                $getComment_post_id = $row['comment_post_id'];
                $getComment_status = $row['comment_status'];

                if($getComment_status == 2) {
                    $updatePost = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = {$getComment_post_id}";
                    $execute_updatePost = mysqli_query($connection, $updatePost);

                    checkQuery($execute_updatePost);
                }
            }
            
            $deleteComment = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
            $execute_deleteComment = mysqli_query($connection, $deleteComment);
            
            header("Location: comments.php?page=comments&deleteCommentSuccess=1");
        }
    }
?>