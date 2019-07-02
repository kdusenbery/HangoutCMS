<?php include "includes/header.php" ?>
<?php insert_category(); update_category(); delete_category(); ?>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="page-header">
                            Categories
                            <small><?PHP echo $_SESSION['username']; ?></small>
                        </h1>
                        <div class="col-xs-4" style="padding-left:0;">
                            <form action="categories.php" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Add Category</label><br/>
                                    <input type="text" name="cat_title" class="form-control" style="width:150px;display:inline;">
                                    <input type="submit" name="addCat" value="Add" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-4" style="padding-right:0;">
                           <?php updateCategorySection(); //get update category section ?>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php findAllCategories(); //get categories table ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>