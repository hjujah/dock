<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Dreamhouse :: Admin Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url('css/admin/main.css'); ?>">
        <script src="<?php echo base_url('js/vendor/modernizr-2.6.2.min.js'); ?>"></script>
    </head>
    <body class="login-body">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <section id="login">
            
            <div>
                <div class="logo"></div>
                <div id="login-error">
                    <div class="alert-message">
                        <p>
                            
                        </p>
                    </div>
                </div>
                <form id="login-form" method="POST">
                    <div class="clearfix">
                        <input id="username" name="username" type="text" placeholder="Username" />
                    </div>
            
                    <div class="clearfix">
                        <input id="password" name="password" type="password" placeholder="Password" />
                    </div>
                    
                    <div class="form-action clearfix" id="actions">
                        <button type="submit" id="login_btn" class="btn">Login</button>
                    </div>
                </form>
            </div>
            
            <p>
                <a href="<?php echo base_url(); ?>" class="backToSite">&larr; Back to site</a>
            </p>
            
        </section>

        <script data-main="<?php echo base_url('js/admin/main'); ?>" src="<?php echo base_url('js/vendor/require.js'); ?>"></script>
    </body>
</html>