<!-- DB Connection -->
<?php include "includes/db.php";?>   
<!-- Header -->
<?php include "includes/header.php";?>    
<!-- Navigation -->
<?php include "includes/navigation.php";?>
<!-- Functions --->
<?php include "functions.php";?> 
<?php update_profile(); ?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
                if(isset($_GET['source'])) {
                    $source = $_GET['source'];
                } else {
                    $source = '';
                }

                switch($source) {
                    default:
                        include "includes/create_profile.php"; //create profile page
                    break;
                    case 'update_profile':
                        include "includes/update_profile.php"; //update profile page
                    break;
                }
            ?>
        </div>
    </div>
    <!-- /.row -->
    <hr>
<!-- Footer -->
<?php include "includes/footer.php";?> 