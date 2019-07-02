<?php include "modals.php"; ?>
<!-- Page Header -->
<h1 class="page-header">
    Profile
</h1>
<!-- Profile Form -->
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
        <form action="profile.php" method="post" enctype="multipart/form-data">
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
                if($user_image !== "") {
                    ?>
                    <img src="images/<?php echo $user_image; ?>" alt="image" width="100"><br/><br/>
                    <?php
                }
                ?>
                <input type="file" name="update_image">
            </div>
            <div class="form-group">
                <label for="title">Username</label>
                <input type="text" class="form-control" name="update_username" value="<?php echo $user_username; ?>" style="width:350px;" required>
            </div>
            <div class="form-group">
                <label for="title">Password</label>
                <input type="text" class="form-control" name="update_password" value="<?php echo $user_password; ?>" style="width:350px;" required>
            </div>
            <div class="form-group">
                <label for="title">First Name</label>
                <input type="text" class="form-control" name="update_firstName" value="<?php echo $user_firstName; ?>" style="width:350px;" required>
            </div>
            <div class="form-group">
                <label for="title">Last Name</label>
                <input type="text" class="form-control" name="update_lastName" value="<?php echo $user_lastName; ?>" style="width:350px;" required>
            </div>
            <div class="form-group">
                <label for="title">Email</label>
                <input type="text" class="form-control" name="update_email" value="<?php echo $user_email; ?>" style="width:350px;" required>
            </div>
            <input type="hidden" name="update_role_id" value="<?php echo $user_role_id; ?>">
            <input type="hidden" name="update_id" value="<?php echo $user_id; ?>">
            <div class="form-group">
                <a class="ButtonLink" href="index.php">Cancel</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="Delete Profile" class="btn btn-primary" data-toggle="modal" data-target="#myModal_confirmDelete" onclick="deleteProfile(<?php echo $user_id; ?>)" style="background-color:red;border-color:red;">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Update Profile" class="btn btn-primary" name="updateProfile">
            </div>
        </form>
        <?php
    }
?>
<script>
    function deleteProfile(id) {
        var delete_profile = "profile.php?deleteProfile=" + id;
        $(".confirm_delete").attr("href", delete_profile);
    };
</script>