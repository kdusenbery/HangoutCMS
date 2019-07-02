<?php include "modals.php"; ?>
<h1 class="page-header">
    View All Users
    <small><?PHP echo $_SESSION['username']; ?></small>
</h1>
<div class="col-xs-6" style="padding-left:0;">
    <form action="./users.php?source=add_user" method="post">
        <div class="form-group" style="padding-top:25px;">
            <input type="submit" value="Add User" class="btn btn-primary" style="width:150px;">
        </div>
    </form>
</div>
<div class="col-xs-6" style="padding-right:0;padding-top:20px;">
    <?php
        if(isset($_GET['addUserSuccess']) && $_GET['addUser'] =='1') {
            ?>
            <span style='color:green;'>User Added successfully</span>
            <?php
        } elseif(isset($_GET['updateUserSuccess']) && $_GET['updateUserSuccess'] =='1') {
            ?>
            <span style='color:green;'>User Updated successfully</span>
            <?php
        } elseif(isset($_GET['deleteUserSuccess']) && $_GET['deleteUserSuccess'] =='1') {
            ?>
            <span style='color:green;'>User Deleted successfully</span>
            <?php
        }
    ?>
</div>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Image</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $getUsers = "SELECT U.*,R.role_title FROM users U INNER JOIN roles R ON U.user_role_id = R.role_id";
            $execute_getUsers = mysqli_query($connection, $getUsers);
        
            while($row = mysqli_fetch_assoc($execute_getUsers)) {
                $user_id = $row['user_id'];
                $user_username = $row['user_username'];
                $user_firstName = $row['user_firstName'];
                $user_lastName = $row['user_lastName'];
                $user_email = $row['user_email'];
                $role_title = $row['role_title'];
                $user_image = $row['user_image'];
                $user_date = $row['user_date'];
                
                ?>
                <tr>
                    <td><?php echo $user_id; ?></td>
                    <td>
                    <?php
                        if($row['user_image'] == "" || empty($row['user_image'])) {
                            echo "No Image";
                        } else {
                            ?>
                            <img src="../images/<?php echo $user_image; ?>" alt="image" width="100">
                            <?php
                        }
                    ?>
                    </td>
                    <td><?php echo $user_username; ?></td>
                    <td><?php echo $user_firstName; ?></td>
                    <td><?php echo $user_lastName; ?></td>
                    <td><?php echo $user_email; ?></td>
                    <td><?php echo $role_title; ?></td>
                    <td><?php echo $user_date; ?></td>
                    <td>
                        <a href="users.php?source=update_user&updateUser=<?php echo $user_id; ?>" style="color:blue;">Update</a>&nbsp
                        <a href="" data-toggle="modal" data-target="#myModal_confirmDelete" onclick="deleteUser(<?php echo $user_id; ?>)" style="color:red;">Delete</a>
                    </td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>
<script>
    function deleteUser(id) {
        var delete_user = "users.php?page=users&deleteUser=" + id;
        $(".confirm_delete").attr("href", delete_user);
    };
</script>