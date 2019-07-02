<h1 class="page-header">
    Add User
    <small><?PHP echo $_SESSION['username']; ?></small>
</h1>
<form action="./users.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">User Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name="username" required>
    </div>
    <div class="form-group">
        <label for="title">Password</label>
        <input type="text" class="form-control" name="password" required>
    </div>
    <div class="form-group">
        <label for="title">First Name</label>
        <input type="text" class="form-control" name="firstName" required>
    </div>
    <div class="form-group">
        <label for="title">Last Name</label>
        <input type="text" class="form-control" name="lastName" required>
    </div>
    <div class="form-group">
        <label for="title">Email</label>
        <input type="text" class="form-control" name="email" required>
    </div>
    <div class="form-group">
        <label for="title">Role</label>
        <select name="role_id" class="form-control">
            <?php
                $getRoles = "SELECT * FROM roles";
                $execute_getRoles = mysqli_query($connection, $getRoles); 

                while($row = mysqli_fetch_assoc($execute_getRoles)) {
                    $role_id = $row['role_id'];
                    $role_title = $row['role_title'];

                    ?>
                    <option value="<?php echo $role_id; ?>"><?php echo $role_title; ?></option>
                    <?php
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <a class="ButtonLink" href="./users.php">Cancel</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" value="Add User" class="btn btn-primary" name="addUser">
    </div>
</form>