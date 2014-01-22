<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->                   
    <!-- CSS concatenated and minified via ant build script-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo base_url('css/admin/main.css'); ?>">

	<meta name='robots' content='noindex,nofollow' />

</head>
<body class="admin-login">

	<div id="login">

	    <div id="login-error">
	    	<?php if(!empty($error)): ?>
	    	<div class="alert-message block-message error">
	    		<p>
	    			<strong><?php echo htmlspecialchars($error); ?></strong>
	    		</p>
	    	</div>
	    	<?php endif;?>
	    </div>
	    
	    <div class="uiBoxLogin pal">
		    <form id="login-form" class="form-stacked" method="POST">
		        <div class="clearfix">
		            <label for="name">Username:</label>
		            <div class="input">
		                <input <?php if(!$post){echo 'autofocus="autofocus"';}?> class="xlarge required_usr" id="username" name="username" size="30" type="text" value="<?php echo htmlspecialchars($username);?>"/>
		            </div>
		        </div><!-- /clearfix -->
		
		        <div class="clearfix mbl">
		            <label for="phone">Password:</label>
		            <div class="input">
		                <input <?php if($post){echo 'autofocus="autofocus"';}?> class="xlarge required_pass" id="password" name="password" size="30" type="password" />
		            </div>
		        </div><!-- /clearfix -->
		        
		        <div class="form-action clearfix" id="actions">
		            <button type="submit" id="login_btn" class="btn primary right">Login</button>
		        </div>
		    </form>
	    </div>
	    
	    <p id="nav">
	        <a href="../">&larr; Back to site</a>
	    </p>
	    
	    
	       
	    
	</div>
	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
	<script>window.jQuery || document.write("<script src='<?php echo base_url('js/lib/jquery-1.6.4.min.js'); ?>'>\x3C/script>")</script>
	
	<script>
	
	console.log('login forma');
	
	var $form,
	    $usernameInput,
	    $passwordInput,
	    $loginBtn;
	
	$().ready(function(){
		
		$form = $('#login-form');
		$usernameInput = $('#username');
		$passwordInput = $('#password');
		$loginBtn = $('#login_btn');
	
		$form.submit(function(e){
			e.preventDefault();
		});
		
		$loginBtn.click(function(e){
			e.preventDefault();
			login();
		});
	
	});
	
	function login(){
		
		var username = $usernameInput.val();
		var password = $passwordInput.val();
		
		if (username == ''){
			$usernameInput.focus();
			return false;
		}
		
		if (password == ''){
			$passwordInput.focus();
			return false;		
		};
		
		$loginBtn.addClass('wait');
		
		var loginUrl = '<?php echo base_url('admin/login/login_ajax');?>';
		
		$.ajax(
			loginUrl,
			{username: username, password: password},
			function(data){
				if(data){
					if(data.success){
						window.location.href = '<?php echo base_url('admin/'); ?>'; 
					} else {
						console.log(data.error);
					}
				} else {
					console.log('error');
				}
				
				$loginBtn.removeClass('wait');
			},
			'json'
		);
	};
	
	
	</script>

</body>
</html>