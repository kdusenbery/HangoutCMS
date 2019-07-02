<?php include "includes/header.php" ?>
<?php update_user(); ?>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Profile
                            <small><?PHP echo $_SESSION['username']; ?></small>
                        </h1>
                        <?php
                            $user_id = $_SESSION["id"];
                            $getProfile = "SELECT * FROM users WHERE user_id = {$user_id}";
                            $execute_getProfile = mysqli_query($connection, $getProfile);

                            while($row = mysqli_fetch_assoc($execute_getProfile)) {
                                $user_id = $row['user_id'];
                                $user_image = $row['user_image'];
                                $user_username = $row['user_username'];
                                $user_password = $row['user_password'];
                                $user_firstName = $row['user_firstName'];
                                $user_lastName = $row['user_lastName'];
                                $user_email = $row['user_email'];
                                $user_role_id = $row['user_role_id'];

                                ?>
                                <form action="profile.php?profile=1" method="post" enctype="multipart/form-data">
                                    <?php
                                    if(isset($_GET['profile']) && $_GET['profile'] == '1') {
                                        ?>
                                        <div class="form-group">
                                            <span style='color:green;padding-bottom:20px;'>Profile updated successfully</span>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label for="title">User Image</label><br/>
                                        <?php
                                            if($row['user_image'] == "" || empty($row['user_image'])) {
                                                echo "No Image";
                                            } else {
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
                                    <input type="hidden" name="update_role_id" value="<?php echo $user_role_id; ?>">
                                    <input type="hidden" name="update_id" value="<?php echo $user_id; ?>">
                                    <div class="form-group">
                                        <input type="submit" value="Update Profile" class="btn btn-primary" name="updateUser">
                                    </div>
                                </form>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>