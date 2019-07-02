<div class="col-md-4">
    <?php
        if(!isset($_SESSION['role_id'])) {
            ?>
            <!-- Login -->
            <div class="well">
                <form action="index.php" method="post">
                    <?php
                        if(isset($_GET['login']) && $_GET['login'] == '0') {
                            ?>
                            <div class="form-group">
                                <span style="color:red";>Username or Pasword is incorrect</span>
                            </div>
                            <?php
                        } elseif(isset($_GET['deleteProfile']) && $_GET['deleteProfile'] == '1') {
                            ?>
                            <div class="form-group">
                                <span style='color:green;'>Profile deleted successfully</span>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group text-center" style="margin-bottom:0;">
                        <input type="submit" value="Login" class="btn btn-primary" name="login" style="width:150px;">
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" value="Create Profile" id="createProfile" class="btn" onclick="goToCreateProfile()" style="width:150px;">
                    </div>
                </form>
            </div>
            <?php
        }
    ?>
    
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" class="form-control" name="search">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default" name="submit">
                        <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>
    
    <!-- Blog Categories Well -->
    <div class="well">
        <?php
            $getCategories_sidebar = "SELECT * FROM categories";
            $execute_getCategories_sidebar = mysqli_query($connection, $getCategories_sidebar);
        ?>
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                        while($row = mysqli_fetch_assoc($execute_getCategories_sidebar)) {
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];

                            echo "<li><a href='category.php?catID={$cat_id}'>{$cat_title}</a></li>";
                        }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php //include "widget.php" ?>

</div>
<script>
    function goToCreateProfile() {
         window.location = 'profile.php?source=create_profile';
    }
</script>