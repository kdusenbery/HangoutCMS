<h1 class="page-header">
    Update User
    <small><?PHP echo $_SESSION['username']; ?></small>
</h1>
<?php
    if(isset($_GET["updateUser"])) {
        $user_id = $_GET["updateUser"];
        $getUser = "SELECT * FROM users WHERE user_id = {$user_id}";
        $execute_getUser = mysqli_query($connection, $getUser);

        while($row = mysqli_fetch_assoc($execute_getUser)) {
            $user_id = $row['user_id'];
            $user_image = $row['user_image'];
            $user_username = $row['user_username'];
            $user_password = $row['user_password'];
            $user_firstName = $row['user_firstName'];
            $user_lastName = $row['user_lastName'];
            $user_email = $row['user_email'];
            $user_role_id = $row['user_role_id'];
            
            ?>
            <form action="./users.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">User Image</label><br/>
                    <?php
                    if($user_image !== "") {
                        ?>
                        <img src="../images/<?php echo $user_image; ?>" alt="image" width="100"><br/><br/>
                        <?php
                    }
                    ?>
                    <input type="file" name="update_image">
                </div>
                <div class="form-group">
                    <label for="title">Username</label>
                    <input type="text" class="form-control" name="update_username" value="<?php echo $user_username; ?>" required>
                </div>
                <div class="form-group">
                    <label for="title">Password</label>
                    <input type="text" class="form-control" name="update_password" value="<?php echo $user_password; ?>" required>
                </div>
                <div class="form-group">
                    <label for="title">First Name</label>
                    <input type="text" class="form-control" name="update_firstName" value="<?php echo $user_firstName; ?>" required>
                </div>
                <div class="form-group">
                    <label for="title">Last Name</label>
                    <input type="text" class="form-control" name="update_lastName" value="<?php echo $user_lastName; ?>" required>
                </div>
                <div class="form-group">
                    <label for="title">Email</label>
                    <input type="text" class="form-control" name="update_email" value="<?php echo $user_email; ?>" required>
                </div>
                <div class="form-group">
                    <label for="title">Role</label>
                    <select name="update_role_id" class="form-control">
                        <?php
                            $getRoles = "SELECT * FROM roles";
                            $execute_getRoles = mysqli_query($connection, $getRoles); 
                            
                            while($row = mysqli_fetch_assoc($execute_getRoles)) {
                                $role_id = $row['role_id'];
                                $role_title = $row['role_title'];
                                
                                ?>
                                <option value="<?php echo $role_id; ?>" <?php if($role_id == $user_role_id) {echo "selected";} ?>><?php echo $role_title; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="update_id" value="<?php echo $user_id; ?>">
                <div class="form-group">
                    <a class="ButtonLink" href="./users.php">Cancel</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="Update User" class="btn btn-primary" name="updateUser">
                </div>
            </form>
            <?php
        }
    }
?>