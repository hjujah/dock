<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Edit User</h1>
			</div><!-- adminhead -->
		
			<div id="adminbody">
		
				<div id="adminbody-content">
					
					<div class="wrap">
						<!-- content goes here -->
						
				        <div class="row">
				            <div class="span16">
				                
				                <div id="actions-result" class="clearfix"></div>
				                
				                <form id="user-form">
				                    
				                    <h3>User info</h3>
				                    
				                    <div class="clearfix">
				                        <label for="email">Email:</label>
				                        <div class="input">
				                            <input class="xlarge required email" id="email" name="email" size="30" type="text" value="<?php echo htmlspecialchars($user->email);?>"/>
				                        </div>
				                    </div><!-- /clearfix --> 
				                              
				                    <div class="clearfix">
				                        <label for="url">Display name:</label>
				                        <div class="input">
				                            <input class="xlarge" id="display_name" name="display_name" size="30" type="text" value="<?php echo htmlspecialchars($user->display_name);?>"/>
				                        </div>
				                    </div><!-- /clearfix --> 
				                     
				                     <!--       
				                    <div class="clearfix">
				                        <label for="desc">Privilegies:</label>
				                        <div class="input">
				                            <select id="privileg" name="privileg">
				                                <option <?php if($user->privilegies == 0) echo 'selected="selected"';?> value="0">Moderator</option>
				                                <?php if($user->privilegies == 1) : ?>
				                                <option  selected="selected" value="1">Administrator</option>
				                                <?php endif; ?>
				                            </select>
				                        </div>
				                    </div> /clearfix -->
				                    
				                
				                    <div id="change-pass-box">
				                        <div class="clearfix">
				                            <div class="input">
				                                <a href="#" class="btn" id="change-pass-btn">Change password</a>
				                                <a href="#" class="btn" id="cancel-pass-btn" style="display: none;">Cancel</a> 
				                            </div>
				                        </div><!-- /clearfix -->
				                    </div>
				                
				                    <div id="password-box" style="display: none;"></div>
				                                  
				                    <div id="actions-result" class="clearfix"></div>   
				                                            
				                    <div class="actions" id="actions">
				                        <button type="submit" id='add_user_btn' class="btn primary">Update User</button>&nbsp;
				                        <!--<a class="btn" id="go-back-btn" href="<?php echo base_url('admin/users/'); ?>">Go back</a>-->
				                    </div>
				                    
				                </form><!-- end #user-form -->
				            </div><!-- end .span16 -->
				        </div><!-- end .row -->   
						
						<!-- content ends here -->
						<br class="clear">
					</div>

					<div class="clear"></div>
				</div><!-- adminbody-content -->
				<div class="clear"></div>
			</div><!-- adminbody -->
			<div class="clear"></div>
		</div><!-- admincontent -->
		
<?php $this->load->view('admin/footer'); ?>
 
<script type="text/javascript">
// GLOBAL VARIABLES 

    var form;  
    var changePass = false;
    
    $().ready(function(){
    	$('#main-bar').dropdown();
        $('#user-form').submit(function(){
            return false;
        });
     
        jQuery.validator.addMethod("required_usr", function(value, element){  
             return (value.length > 3);
        }, "Username must be at least 4 characters long.");
        jQuery.validator.addMethod("required_pass", function(value, element){  
             return (value.length > 4);
        }, "Password must be at least 5 characters long.");
        jQuery.validator.addMethod("pass_repeat", function(value, element){  
             return (value == $('#password').val());
        }, "Passwords do not match.");
        form = $('#user-form');
        form.validate({
            invalidHandler: function(e, validator) {},
            submitHandler: function() { 
                //alert(123);
                updateUser();
            },
            errorElement: 'p',
            //ignore: '.skip',
            errorClass: 'err',
            highlight: function(element, errorClass) {
                $(element).parents('.clearfix').first().addClass('error');
            },
            unhighlight: function(element, errorClass) {
                $(element).parents('.clearfix').first().removeClass('error');
            },
            errorPlacement: function(error, element) {       
                element.parent().append('<span class="help-block"></span>').find('.help-block').append(error);
            },
        });
        
        $('#change-pass-btn').bind('click', function(e){
            e.preventDefault();
            changePass = true;
            $('#change-pass-btn').hide();
            $('#cancel-pass-btn').show();
            var pass = $('<div>').addClass('clearfix');
            var input = $('<div>').addClass('input');
            pass.append('<label for="phone">New password:</label>');
            input.append('<input class="xlarge required_pass" id="password" name="password" size="30" type="password" />');
            pass.append(input);
            
            var rep_pass = $('<div>').addClass('clearfix');
            var input2 = $('<div>').addClass('input');
            input2.append('<input class="xlarge pass_repeat" id="repeat_pass" name="repeat_pass" size="30" type="password" />');
            rep_pass.append('<label for="phone">Repeat password:</label>');
            rep_pass.append(input2);
            
            $('#password-box').html('');
            $('#password-box').append(pass);
            $('#password-box').append(rep_pass);
            $('#password-box').show(); 
        });
        $('#cancel-pass-btn').bind('click', function(e){
            e.preventDefault();
            changePass = false;
            $('#cancel-pass-btn').hide();
            $('#change-pass-btn').show();
            $('#password-box').hide();
            $('#password-box').html('');    
        });
        $('#username').bind({
            keyup: function(){
                $('#display_name').val($('#username').val());        
            },
            paste: function(){
                var el = $(this);
                setTimeout(function() {
                    $('#display_name').val($(el).val());   
                }, 100);    
            },
            change: function(){
                $('#display_name').val($('#username').val());    
            }
        });
        $('#display_name').bind({
            keyup: function(){
                $('#username').unbind();        
            },
            paste: function(){
                $('#username').unbind();   
            }
        });
                
    });
      
    function updateUser(){ 
         var adresa="<?php echo base_url('ajax/updateUser_ajax'); ?>";  
         $.post(
            adresa, 
            {
                id: <?php echo $user->id; ?>, 
                password: (changePass)?$('#password').val():0,
                repeat_pass: (changePass)?$('#repeat_pass').val():0,
                email: $('#email').val(),
                display_name: $('#display_name').val(),  
                privilegies: $('#privileg').val() 
            }, 
            updateUserCallBack, 
            'json'
         );
    }

    function updateUserCallBack(data){
        if (typeof(data) == "object"){
            if(!data.success){
                renderMessage(data.error, $('#actions-result'), 'error');
                
            }
            else{                   
                renderMessage(data.msg, $('#actions-result'), 'success');;   
            }
        }
    }
    
    function renderMessage(message, element, type){
        var msg = $('<div>').addClass('alert-message block-message');
        msg.append('<p>'+message+'</p>');
        if(type == 'error'){
            msg.addClass('error');
            element.html('');
            element.append(msg);
        }
        else if(type == 'success'){
            msg.addClass('success');
            element.html('');
            element.append(msg);
            setTimeout(function(){
                msg.fadeOut();
            }, 3000);
        }
    }
    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
          };
    })();  
</script>
<?php $this->load->view('admin/page-end'); ?>

