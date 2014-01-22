<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Dreamhouse :: Administration</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url('css/admin/main.css'); ?>">
        <script src="<?php echo base_url('js/vendor/modernizr.js'); ?>"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
            
        <div id="wrap">

            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container-fluid">
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="brand transition" href="<?php echo base_url('admin/homepage'); ?>">Dreamhouse Admin</a>
                        <div class="nav-collapse collapse">
                            <ul class="nav pull-right">
                                <li><a href="<?php echo base_url('admin/homepage'); ?>" class="transition">Homepage</a></li>
                                <li><a href="<?php echo base_url('admin/designers'); ?>" class="transition">Designers</a></li>
                                <li><a href="<?php echo base_url('admin/artists'); ?>" class="transition">Artists</a></li>
                                <li><a href="<?php echo base_url('admin/brands'); ?>" class="transition">Textile + Wallpaper</a></li>
                                <li><a href="<?php echo base_url('admin/news'); ?>" class="transition">News</a></li>
                                <li><a href="<?php echo base_url(); ?>" class="transition" target="_blank">Site</a></li>
                                <?php if($this->session->userdata('privilegies') == 1): ?>
                                    <li><a href="<?php echo base_url('admin/users'); ?>" class="transition">Users</a></li>
                                <?php endif; ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle transition" data-toggle="dropdown">User <b class="caret transition"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo base_url('admin/users/editUser/'.$this->session->userdata('user_id')); ?>">Edit profile</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo base_url('admin/login/logout');?>">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Begin page content -->
            <div class="container">