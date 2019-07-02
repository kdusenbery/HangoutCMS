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
                Contact Us
            </h1>
            <!-- Post Form -->
            <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" name="subject" style="width:350px;" required>
                </div>
                <div class="form-group">
                    <label for="title">Content</label>
                    <textarea class="form-control" rows="10" cols="30" name="content" id="ckeditor"></textarea>
                </div>
                <div class="form-group">
                    <a class="ButtonLink" href="./posts.php">Cancel</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="Send Email" class="btn btn-primary" name="contactUs">
                </div>
            </form>
        </div>
    </div>
    <!-- /.row -->
    <hr>
<!-- Footer -->
<?php include "includes/footer.php";?> 