<?php include "includes/header.php" ?>
<?php comment_status(); update_comment(); delete_comment(); ?>
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
                                    include "includes/view_all_comments.php"; //view all comments page
                                break;
                                case 'update_comment':
                                    include "includes/update_comment.php"; //update comment page
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