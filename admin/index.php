<?php include "includes/header.php" ?>
    <div id="wrapper">
       <!-- Navigation -->
        <?php include "includes/navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            CMS Dashboard
                            <small><?PHP echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php
                                        $getPosts = "SELECT post_id, post_status FROM posts";
                                        $execute_getPosts = mysqli_query($connection, $getPosts);
                                        
                                        $post_count = mysqli_num_rows($execute_getPosts);
                                        $d_posts = 0;
                                        $p_posts = 0;
                                        $a_posts = 0;
                                        
                                        while($row = mysqli_fetch_assoc($execute_getPosts)) {
                                            $post_status = $row['post_status'];
                                            
                                            if($post_status == 0) {
                                                $d_posts++;
                                            } elseif($post_status == 1) {
                                                $p_posts++;
                                            } elseif($post_status == 2) {
                                                $a_posts++;
                                            }
                                        }
                                        
                                        echo "<div class='huge'>{$post_count}</div><div>Posts</div></div>";
                                    ?>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php
                                        $getComments = "SELECT comment_id, comment_status FROM comments";
                                        $execute_getComments = mysqli_query($connection, $getComments);
                                        
                                        $comment_count = mysqli_num_rows($execute_getComments);
                                        $d_comments = 0;
                                        $p_comments = 0;
                                        $a_comments = 0;
                                        
                                        while($row = mysqli_fetch_assoc($execute_getComments)) {
                                            $comment_status = $row['comment_status'];
                                            
                                            if($comment_status == 0) {
                                                $d_comments++;
                                            } elseif($comment_status == 1) {
                                                $p_comments++;
                                            } elseif($comment_status == 2) {
                                                $a_comments++;
                                            }
                                        }
                                        
                                        echo "<div class='huge'>{$comment_count}</div><div>Comments</div></div>";
                                    ?>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php
                                        $getUsers = "SELECT user_id, user_role_id FROM users";
                                        $execute_getUsers = mysqli_query($connection, $getUsers);
                                        
                                        $user_count = mysqli_num_rows($execute_getUsers);
                                        $a_users = 0;
                                        $u_users = 0;
                                        
                                        while($row = mysqli_fetch_assoc($execute_getUsers)) {
                                            $user_role_id = $row['user_role_id'];
                                            
                                            if($user_role_id == 1) {
                                                $a_users++;
                                            } elseif($user_role_id == 2) {
                                                $u_users++;
                                            }
                                        }
                                        
                                        echo "<div class='huge'>{$user_count}</div><div>Users</div></div>";
                                    ?>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php
                                        $getCategories = "SELECT cat_id FROM categories";
                                        $execute_getCategories = mysqli_query($connection, $getCategories);
                                        $cat_count = mysqli_num_rows($execute_getCategories);
                                        
                                        echo "<div class='huge'>{$cat_count}</div><div>Categories</div></div>";
                                    ?>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Data','Denied','Pending','Approved'],
                            <?php
                                $element_text = ['Posts', 'Comments', 'A.Users', 'Users', 'Categories'];
                                $denied_count = [$d_posts, $d_comments, 0, 0, 0];
                                $pending_count = [$p_posts, $p_comments, 0, 0, 0];
                                $approved_count = [$a_posts, $a_comments, $a_users, $u_users, $cat_count];
                            
                                for($i = 0;$i < 5;$i++) {
                                    echo "['{$element_text[$i]}'" . "," . "{$denied_count[$i]}" . "," . "{$pending_count[$i]}" . "," . "{$approved_count[$i]}],";
                                }
                            ?>
                        ]);
                        
                        var options = {
                          chart: {
                            title: '',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
<?php include "includes/footer.php" ?>