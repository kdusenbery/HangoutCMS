<?php
    if(isset($_GET['username'])) {
        $username = $_GET['username'];
        $firstName = $_GET['firstName'];
        $lastName = $_GET['lastName'];
        $email = $_GET['email'];
        ?>
        <h4 style="color:red;">The username you chose alright exists, please select another one.</h4>
        <?php
    }
?>
<!-- Page Header -->
<h1 class="page-header">
    Create User Profile
</h1>
<!-- User Form -->
<form action="index.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name="username" style="width:350px;" <?php if(isset($_GET['username'])){echo "value='{$username}'";} ?> required>
    </div>
    <div class="form-group">
        <label for="title">Password</label>
        <input type="text" class="form-control" name="password" style="width:350px;" required>
    </div>
    <div class="form-group">
        <label for="title">First Name</label>
        <input type="text" class="form-control" name="firstName" style="width:350px;" <?php if(isset($_GET['firstName'])){echo "value='{$firstName}'";} ?> required>
    </div>
    <div class="form-group">
        <label for="title">Last Name</label>
        <input type="text" class="form-control" name="lastName" style="width:350px;" <?php if(isset($_GET['lastName'])){echo "value='{$lastName}'";} ?> required>
    </div>
    <div class="form-group">
        <label for="title">Email</label>
        <input type="text" class="form-control" name="email" style="width:350px;" <?php if(isset($_GET['email'])){echo "value='{$email}'";} ?> required>
    </div>
    <div class="form-group">
        <a class="ButtonLink" href="index.php">Cancel</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" value="Create Profile" class="btn btn-primary" name="createProfile">
    </div>
</form>