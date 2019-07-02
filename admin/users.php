<?php include "includes/header.php" ?>
<?php add_user(); update_user(); delete_user(); ?>
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
                                    include "includes/view_all_users.php"; //view all users page
                                break;
                                case 'add_user':
                                    include "includes/add_user.php"; //add user page
                                break;
                                case 'update_user':
                                    include "includes/update_user.php"; //update user page
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