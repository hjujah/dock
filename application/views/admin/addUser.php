<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Add User</h1>
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
				                        <label for="username">Username:</label>
				                        <div class="input">
				                            <input class="xlarge required_usr" id="username" name="username" size="30" type="text"/>
				                        </div>
				                    </div><!-- /clearfix -->
				
				                    <div class="clearfix">
				                        <label for="email">Email:</label>
				                        <div class="input">
				                            <input class="xlarge required email" id="email" name="email" size="30" type="text"/>
				                        </div>
				                    </div><!-- /clearfix --> 
				                              
				                    <div class="clearfix">
				                        <label for="display_name">Display name:</label>
				                        <div class="input">
				                            <input class="xlarge" id="display_name" name="display_name" size="30" type="text"/>
				                        </div>
				                    </div><!-- /clearfix --> 
				                            
				                    <div class="clearfix">
				                        <label for="privileg">Privilegies:</label>
				                        <div class="input">
				                            <select id="privileg" name="privileg">
				                                <option value="0">Moderator</option>
				                                <option value="1">Administrator</option>
				                            </select>
				                        </div>
				                    </div><!-- /clearfix -->
				                    
				                    <h3>User password</h3>
				                    
				                    <div class="clearfix">
				                        <label for="password">Password:</label>
				                        <div class="input">
				                            <input class="xlarge required_pass" id="password" name="password" size="30" type="password" />
				                        </div>
				                    </div><!-- /clearfix -->
				                    
				                    <div class="clearfix">
				                        <label for="repeat_pass">Repeat password:</label>
				                        <div class="input">
				                            <input class="xlarge pass_repeat" id="repeat_pass" name="repeat_pass" size="30" type="password" />
				                        </div>
				                    </div><!-- /clearfix -->  
				                                            
				                    <div class="actions" id="actions">
				                        <button type="submit" id='add_user_btn' class="btn primary">Save User</button>
				                        <a class="btn" id="cancel_btn" href="<?php echo base_url('admin/users/'); ?>">Go back</a>
				                    </div>
				                    
				                </form><!-- user-form -->
				                
				            </div><!-- span16 -->
				        </div><!-- row -->   
						
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

    
    $().ready(function(){ 
    	$('#main-bar').dropdown();
        jQuery.validator.addMethod("required_usr", function(value, element){  
             return (value.length >= 3);
        }, "Username must be at least 3 characters long.");
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
                addUser();
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
      
    function addUser(){
         var adresa="<?php echo base_url('admin/ajax/addUser_ajax'); ?>";  
         $.post(
            adresa, 
            {
                username: $('#username').val(),
                password: $('#password').val(),
                repeat_pass: $('#repeat_pass').val(),
                email: $('#email').val(),
                display_name: $('#display_name').val(),
                privilegies: $('#privileg').val()
            }, 
            addUserCallBack, 
            'json');
    }

    function addUserCallBack(data){
        if (typeof(data) == "object"){
            if(!data.success){
                renderErrorMsg($('#actions-result'), data.error);
                
            }
            else{
                $('#actions').hide();
                renderSuccessMsg($('#actions-result'), data.id);   
            }
        }
    }



    function renderSuccessMsg(element, user_id){

        var selector = (element)?element:$('');
        
        var markup;
        markup  = '<div class="alert-message block-message success">';
        markup += '<p><strong>User added successfuly!</strong>&nbsp;';
        markup += '</p>'; 
        markup += '<div class="alert-actions">';
        markup += '<a class="btn" href="<?php echo base_url('admin/users/editUser/'); ?>'+user_id+'">Edit this user</a>&nbsp;';
        markup += '<a class="btn" href="<?php echo base_url('admin/users/addUser'); ?>">or add another</a>'; 
        markup += '</div>';
        markup += '</div>';

        selector.html(markup);
    }

    function renderErrorMsg(element, error_msg){

        var selector = (element)?element:$('');
        var msg = (error_msg)?error_msg:'Oops, error!';
        
        var markup;
        markup  = '<div class="alert-message block-message error">';
        markup += '<p><strong>'+msg+'</strong></p>';
        markup += '</div>';

        selector.html(markup);
    }  
    // geo search
    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
          };
    })();  




</script>
<?php $this->load->view('admin/page-end'); ?>
