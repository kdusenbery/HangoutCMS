<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS Front</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <?php 
            if(isset($_SESSION["id"])) {
                ?>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav" style="float:right;">
                        <?php
                            if($_SESSION['role_id'] == '1') {
                                $profileUrl = "admin/profile.php";
                                ?>
                                <li>
                                    <a href="admin">Admin</a>
                                </li>
                                <?php
                            } else {
                                $profileUrl = "profile.php?source=update_profile";
                                ?>
                                <li>
                                    <a href="contact_us.php">Contact Us</a>
                                </li>
                                <?php
                            }
                         ?>
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?PHP echo $_SESSION['firstName']; ?> <?PHP echo $_SESSION['lastName']; ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo $profileUrl; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                                </li>
                                <li>
                                    <a href="create_post.php"><i class="fa fa-fw fa-edit"></i> Create Post</a>
                                </li>
                                <li>
                                    <a href="index.php?logout=1"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                </li>
                            </ul>
                         </li>
                    </ul>
                </div>
                <?php
            }
        ?>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>