<?php include "includes/header.php" ?>
<?php post_status(); update_post(); delete_post(); ?>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                            if(isset($_GET['source'])) {
                                $source = $_GET['source'];
                            } else {
                                $source = '';
                            }

                            switch($source) {
                                default:
                                    include "includes/view_all_posts.php"; //view all posts page
                                break;
                                case 'update_post':
                                    include "includes/update_post.php"; //update post page
                                break;
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