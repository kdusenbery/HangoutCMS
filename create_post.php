<!-- DB Connection -->
<?php include "includes/db.php";?>   
<!-- Header -->
<?php include "includes/header.php";?>    
<!-- Navigation -->
<?php include "includes/navigation.php";?>
<!-- Functions --->
<?php include "functions.php";?> 
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Page Header -->
            <h1 class="page-header">
                Create Post
            </h1>
            <!-- Post Form -->
            <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Image</label>
                    <input type="file" name="image">
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" style="width:350px;" required>
                </div>
                <div class="form-group">
                    <label for="title">Category</label><br/>
                    <select name="category_id" class="form-control" style="width:350px;">
                        <?php
                            $getCategories = "SELECT * FROM categories";
                            $execute_getCategories = mysqli_query($connection, $getCategories); 

                            while($row = mysqli_fetch_assoc($execute_getCategories)) {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];

                                ?>
                                <option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Tags</label>
                    <input type="text" class="form-control" name="tags" style="width:350px;">
                </div>
                <div class="form-group">
                    <label for="title">Content</label>
                    <textarea class="form-control" rows="10" cols="30" name="content" id="ckeditor"></textarea>
                </div>
                <div class="form-group">
                    <a class="ButtonLink" href="./posts.php">Cancel</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="Publish Post" class="btn btn-primary" name="createPost">
                </div>
            </form>
        </div>
    </div>
    <!-- /.row -->
    <hr>
<!-- Footer -->
<?php include "includes/footer.php";?> 