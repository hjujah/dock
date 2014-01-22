<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"><![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"><!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title></title>
  <meta name="description" content="">
  <meta name="author" content="">
  
  
  <meta property="og:title" content="<?php echo $photo->title; ?>"/>
  <meta property="og:type" content="website"/>
  <meta property="og:url" content="<?php echo base_url('image/'.$photo->id); ?>"/>
  <meta property="og:image" content="<?php echo $photo->thumb_permalink; ?>"/>
  <meta property="og:site_name" content="Voovents"/>
  <meta property="fb:admins" content=""/>
  <meta property="og:description" content="<?php echo $photo->description; ?>" />

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet/less" type="text/css" href="<?php echo base_url('css/less/bootstrap.less'); ?>">
  <script src="<?php echo base_url('js/libs/less-1.1.3.min.js'); ?>" type="text/javascript"></script>
  
  <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">

  <!-- end CSS-->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="<?php echo base_url('js/libs/modernizr-2.0.6.min.js'); ?>"></script>
</head>

<body>
<div id="fb-root"></div>
<div id="wrap" class="singleImg">
    <header id="branding" class="container">
         <a href="<?php echo base_url(); ?>" id="logo" title="Voovents">
            <img src="<?php echo base_url('img/css/logo.png'); ?>" alt="Voovents logo" />
         </a>
         <div id="share-links">
         <!-- AddThis Button BEGIN -->
         <div class="addthis_toolbox">
	         <a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
	         <a class="addthis_button_tweet" tw:count="vertical"></a>
	         <a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
         </div>
         <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4e98312d2697cc7b"></script>
         <!-- AddThis Button END -->
         </div>
    </header>
    
    <div class="container">
        
        <?php $this->load->view('main-navigation', array('active'=>'galleries', 'menudata' => $menudata)); ?>
        
    </div>
    
    <div id="main-content" role="main" class="container"> 

        <div id="photo" class="row mbl">
			<div class="span16">
				
				
				<div id="singleImgWrapper">
					<img class="imgBig" src="<?php echo $photo->permalink; ?>" />
				</div>
				
				<div id="singleImgNav" class="clearfix">
                    <p class="pull-left">
                    	<?php if($prev_id) : ?><a href="<?php echo base_url('image/'.$prev_id); ?>" >Previous</a><?php endif; ?>
                    	<?php if($prev_id && $next_id){ echo '&ndash;'; }  ?>
                    	<?php if($next_id) : ?><a href="<?php echo base_url('image/'.$next_id); ?>" >Next</a><?php endif; ?>
                    </p>
                </div>
				
				<div id="singleImage-fb-wrapper">
					<div class="fb-comments" data-href="<?php echo base_url('image/'.$photo->id); ?>" data-num-posts="2" data-width="520">
						
					</div>
				</div>

			</div>
        </div><!-- end #galleries -->
    
    </div><!-- end #main-content -->
    
</div>

<?php $this->load->view('html-footer'); ?>

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
<script>window.jQuery || document.write("<script src='<?php echo base_url('js/libs/jquery-1.6.4.min.js'); ?>'>\x3C/script>")</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.5.3/jquery-ui.min.js" ></script>

<script type="text/javascript" src="<?php echo base_url('js/plugins/jquery.lavaNavbar.js'); ?>"></script>

<script type="text/javascript">
    $().ready(function(){
        
        $('#navigation').lavaNavbar();
    })
</script>

<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

</body>
</html>