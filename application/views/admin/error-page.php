<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $heading; ?></title>

    <!-- Le styles -->                   
    <link href="<?php echo  base_url('css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo  base_url('css/admin-style.css'); ?>" rel="stylesheet">


</head>
<body>
<div id="wrap">

<div id="main-content" class="container-fluid">
    <style>
        .custom-error{
            border:1px solid #FBC7C6;
            background-color: rgba(251,199,199, 0.1);
            padding: 20px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }    
    </style>
    <div class="content full">
        <div class="custom-error">
            <div class="page-header">
                <h1><?php echo $heading; ?></h1>
            </div>
            <p><?php echo $body; ?></p>
            <hr/>
            <a href="#" class="btn">Go back</a>    
        </div>
    </div>
</div> 

</div>

<footer id="footer">
    <p>&copy; VizioArt <?php echo date('Y');?></p>
</footer>

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
<script>window.jQuery || document.write("<script src='<?php echo base_url('js/lib/jquery-1.6.4.min.js'); ?>'>\x3C/script>")</script>

<script type="text/javascript">
    $().ready(function(){
        $('.btn').click(function(e){
            e.preventDefault();
            window.history.back();
        });
    });
    
</script>
</body>
</html>