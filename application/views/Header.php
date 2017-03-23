<!DOCTYPE html> <html>
<head>
    <title> <?php if (isset($title)) echo $title; else echo 'News Romania'; ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>css/custom.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>js/jquery.js"></script>

    <script src="<?php echo base_url(); ?>js/bootstrap.js"></script>

    <script src="<?php echo base_url(); ?>js/my-jquery.js"></script>

</head>
<body>
<?php if((uri_string() != 'login') && (uri_string() != 'register')) { ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>">News Romania</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="<?php echo base_url(); ?>it">IT</a></li>
                    <li><a href="<?php echo base_url(); ?>economic">Economic</a></li>
                    <li><a href="<?php echo base_url(); ?>social">Social</a></li>
                    <li><a href="<?php echo base_url(); ?>sport">Sport</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(isset($_SESSION['reporter']) && $_SESSION['reporter'] == 1 || isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { ?>
                        <li id="test"><a href="#">Salut <?php echo $_SESSION['username']; ?>!</a> <div id="myPan"></div> </li>
                        <li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
                    <?php } else { ?>
                        <li class="login"><a href="<?php echo base_url(); ?>login">Login</a></li>
                        <li class="register"><a href="<?php echo base_url(); ?>register">Register</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div id="output_width" class="my-img">  </div>

    <div class="row">
        <form action="<?php echo base_url(); ?>search" method="post" class="navbar-form navbar-right margin-bottom" role="search">
            <div class="form-group">
                <input name="search_news" type="text" class="form-control search-form" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default buton-search">Submit</button>
        </form>
    </div>
<?php } ?>