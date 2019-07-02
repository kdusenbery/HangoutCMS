<?php
    function escape($string) {
        global $connection;
        return mysqli_real_escape_string($connections, trim($string));
    }

    function checkQuery($query) {
        global $connection;
        if(!$query) {
            die('Query Failed' . mysqli_error($connection));
        }
    }

    // USER FUNCTIONS

    function login() {
        global $connection;
        if(isset($_POST["login"])) {
            $user_username = $_POST["username"];
            $user_password = $_POST["password"];
            
            $user_username = mysqli_real_escape_string($connection, $user_username);
            $user_password = mysqli_real_escape_string($connection, $user_password);

            $getUser = "SELECT * FROM users WHERE user_username = '{$user_username}' AND user_password = '{$user_password}'";
            $execute_getUser = mysqli_query($connection, $getUser);

            checkQuery($execute_getUser);

            $num_rows = mysqli_num_rows($execute_getUser);

            if($num_rows > 0) {
               while($row = mysqli_fetch_assoc($execute_getUser)) {
                   $user_id = $row['user_id'];
                   $user_image = $row['user_image'];
                   $user_username = $row['user_username'];
                   $user_password = $row['user_password'];
                   $user_firstName = $row['user_firstName'];
                   $user_lastName = $row['user_lastName'];
                   $user_email = $row['user_email'];
                   $user_role_id = $row['user_role_id'];

                   $_SESSION['id'] = $user_id;
                   $_SESSION['username'] = $user_username;
                   $_SESSION['firstName'] = $user_firstName;
                   $_SESSION['lastName'] = $user_lastName;
                   $_SESSION['email'] = $user_email;
                   $_SESSION['role_id'] = $user_role_id;
                   
                   if($_SESSION['role_id'] == '1') {
                       header("Location: admin/index.php");
                   } else {
                       header("Location: index.php?login=1");
                   }
                   
               }
            } else {
               header("Location: index.php?login=0");
            }
        }
    }

    function logOut() {
        if(isset($_GET['logout']) && $_GET['logout'] == '1') {
            session_destroy();
            header("Location: index.php");
        }
    }

    function create_profile() {
        global $connection;
        if(isset($_POST["createProfile"])) {
            $user_username = $_POST["username"];
            $user_password = $_POST["password"];
            $user_image = $_FILES['image']['name'];
            $user_image_temp = $_FILES['image']['tmp_name'];
            move_uploaded_file($user_image_temp, "images/$user_image");
            $user_firstName = $_POST['firstName'];
            $user_lastName = $_POST['lastName'];
            $user_email = $_POST['email'];
            $user_role_id = 2;
            
            $hash = "$2y$10$";
            $salt = "thisiswhatencryptionlookslike87";
            $hash_salt = $hash . $salt;
            $var_encrypted = crypt($user_password, $hash_salt);

            $getUsername = "SELECT user_username FROM users WHERE user_username = '{$user_username}'";
            $execute_getUsername = mysqli_query($connection, $getUsername);
            $username_count = mysqli_num_rows($execute_getUsername);

            if($username_count > 0) {
                header("Location: profile.php?source=create_profile&username={$user_username}&firstName={$user_firstName}&lastName={$user_lastName}&email={$user_email}");
            } else {
                $createProfile = 
                    "INSERT INTO users(user_image,user_username,user_password,user_firstName,user_lastName,user_email,user_role_id,user_randSalt,user_date) VALUE('{$user_image}','{$user_username}','{$user_password}','{$user_firstName}','{$user_lastName}','{$user_email}','{$user_role_id}','{$var_encrypted}',now())";
                $execute_createProfile = mysqli_query($connection, $createProfile);

                checkQuery($execute_createProfile);

                $getUser = "SELECT user_id FROM users WHERE user_username = '{$user_username}' AND user_password = '{$user_password}'";
                $execute_getUser = mysqli_query($connection, $getUser);

                checkQuery($execute_getUser);

                $num_rows = mysqli_num_rows($execute_getUser);

                if($num_rows > 0) {
                   while($row = mysqli_fetch_assoc($execute_getUser)) {
                       $user_id = $row['user_id'];

                       $_SESSION['id'] = $user_id;
                       $_SESSION['username'] = $user_username;
                       $_SESSION['firstName'] = $user_firstName;
                       $_SESSION['lastName'] = $user_lastName;
                       $_SESSION['email'] = $user_email;
                       $_SESSION['role_id'] = $user_role_id;

                       header("Location: index.php?login=1");
                   }
                }
            }
        }
    }

    function update_profile() {
        global $connection;
        if (isset($_POST["updateProfile"])) {
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
            
            header("Location: profile.php?source=update_profile&profile=1");
        } elseif(isset($_GET['deleteProfile']) && $_GET['deleteProfile'] == $_SESSION['id']) {
            $delete_user_id = $_GET['deleteProfile'];
            
            $deleteUserComments = "DELETE FROM comments WHERE comment_user_id = {$delete_user_id}";
            $execute_deleteComments = mysqli_query($connection, $deleteUserComments);
            
            $deleteUserPosts = "DELETE FROM posts WHERE post_user_id = {$delete_user_id}";
            $execute_deleteUserPosts = mysqli_query($connection, $deleteUserPosts);
            
            $deleteUser = "DELETE FROM users WHERE user_id = {$delete_user_id}";
            $execute_deleteUser = mysqli_query($connection, $deleteUser);
            
            session_destroy();
            
            header("Location: index.php?deleteProfile=1");
        }
    }

    // POST FUNCTIONS

    function create_post() {
        global $connection;
        if(isset($_POST['createPost'])) {
            $post_title = $_POST['title'];
            $post_user_id = $_SESSION['id'];
            $post_category_id = $_POST['category_id'];
            $post_image = $_FILES['image']['name'];
                $post_image_temp = $_FILES['image']['tmp_name'];
                move_uploaded_file($post_image_temp, "images/$post_image");
            $post_tags = $_POST['tags'];
            $post_content = $_POST['content'];
            $post_comment_count = 0;
            
            $getApproval = "SELECT post_approval FROM approval WHERE approval_id = 1";
            $execute_getApproval = mysqli_query($connection, $getApproval);
            
            while($row = mysqli_fetch_assoc($execute_getApproval)) {
                $post_approval = $row["post_approval"];
                
                if($post_approval == 0) {
                    $post_status = 2;
                } else {
                    $post_status = 1;
                }
            }
            
            $insertPost = 
                "INSERT INTO posts(post_title,post_user_id,post_category_id,post_status,post_image,post_tags,post_content,post_date,post_comment_count) VALUE('{$post_title}','{$post_user_id}','{$post_category_id}',{$post_status},'{$post_image}','{$post_tags}','{$post_content}',now(),{$post_comment_count})";
            $execute_insertPost = mysqli_query($connection, $insertPost);

            checkQuery($execute_insertPost);

            header("Location: index.php");
        }
    }

    function update_post() {
        global $connection;
        if (isset($_POST["updatePost"])) {
            $post_id = $_POST['update_id'];
            $post_title = $_POST['update_title'];
            $post_category_id = $_POST['update_category_id'];
            
            $getApproval = "SELECT post_approval FROM approval WHERE approval_id = 1";
            $execute_getApproval = mysqli_query($connection, $getApproval);
            
            while($row = mysqli_fetch_assoc($execute_getApproval)) {
                $post_approval = $row["post_approval"];
                
                if($post_approval == 0) {
                    $post_status = 2;
                } else {
                    $post_status = 1;
                }
            }
            
            $post_image = $_FILES['update_image']['name'];
                $post_image_temp = $_FILES['update_image']['tmp_name'];
                move_uploaded_file($post_image_temp, "images/$post_image");
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
            
            header("Location: index.php");
        }
    }

    function delete_post() {
        global $connection;
        if (isset($_GET['deletePost']) && isset($_GET['u_id']) && $_GET['u_id'] == $_SESSION['id']) {
            $delete_post_id = $_GET['deletePost'];
            
            $deleteComments = "DELETE FROM comments WHERE comment_post_id = {$delete_post_id}";
            $execute_deleteComments = mysqli_query($connection, $deleteComments);
            
            $deletePost = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
            $execute_deletePost = mysqli_query($connection, $deletePost);
            
            header("Location: index.php");
        }
    }
    
    // COMMENT FUNCTIONS

    function add_comment() {
        global $connection;
        if(isset($_POST['addComment'])) {
            $comment_user_id = $_SESSION['id'];
            $comment_post_id = $_POST['post_id'];
            $comment_content = $_POST['content'];
            
            $getApproval = "SELECT comment_approval FROM approval WHERE approval_id = 1";
            $execute_getApproval = mysqli_query($connection, $getApproval);
            
            while($row = mysqli_fetch_assoc($execute_getApproval)) {
                $comment_approval = $row["comment_approval"];
                
                if($comment_approval == 0) {
                    $comment_status = 2;
                } else {
                    $comment_status = 1;
                }
            }
            
            $insertComment = 
                "INSERT INTO comments(comment_user_id,comment_post_id,comment_content,comment_status,comment_date) VALUE('$comment_user_id','{$comment_post_id}','{$comment_content}',{$comment_status},Now())";
            $execute_insertComment = mysqli_query($connection, $insertComment);

            checkQuery($execute_insertComment);
            
            header("Location: post.php?id={$comment_post_id}");
        }
    }

    // CONTACT US

    function contact_us() {
        global $connection;
        if(isset($_POST['contactUs'])) {
            $from = $_SESSION["email"];
            $to = "kohl.dusenbery@gmail.com";
            $subject = wordwrap($_POST["subject"],70);
            $content = strip_tags($_POST["content"]);
            
            mail($to,$subject,$content,$from);
            
            header("Location: index.php");
        }
    }
?>
