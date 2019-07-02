<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">CMS Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li>
            <a href="../index.php">CMS Front</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?PHP echo $_SESSION['firstName']; ?> <?PHP echo $_SESSION['lastName']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="./profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li>
                    <a href="../create_post.php"><i class="fa fa-fw fa-edit"></i> Create Post</a>
                </li>
                <li>
                    <a href="../index.php?logout=1"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li <?php if(isset($_GET["page"]) && $_GET["page"] == "profile"){echo "class='active'";} ?>>
                <a href="./profile.php?page=profile"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            <li <?php if(isset($_GET["page"]) && $_GET["page"] == "dashboard"){echo "class='active'";} ?>>
                <a href="index.php?page=dashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li <?php if(isset($_GET["page"]) && $_GET["page"] == "users"){echo "class='active'";} ?>>
                <a href="./users.php?page=users"><i class="fa fa-fw fa-users"></i> Users</a>
            </li>
            <li <?php if(isset($_GET["page"]) && $_GET["page"] == "categories"){echo "class='active'";} ?>>
                <a href="./categories.php?page=categories"><i class="fa fa-fw fa-list"></i> Categories</a>
            </li>
            <li <?php if(isset($_GET["page"]) && $_GET["page"] == "posts"){echo "class='active'";} ?>>
                <a href="./posts.php?page=posts"><i class="fa fa-fw fa-edit"></i> Posts</a>
            </li>
            <li <?php if(isset($_GET["page"]) && $_GET["page"] == "comments"){echo "class='active'";} ?>>
                <a href="./comments.php?page=comments"><i class="fa fa-fw fa-comments"></i> Comments</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>