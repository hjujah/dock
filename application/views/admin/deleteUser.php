<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Delete User</h1>
			</div><!-- adminhead -->
		
			<div id="adminbody">
		
				<div id="adminbody-content">
					
					<div class="wrap">
						<!-- content goes here -->
						
				        <div class="row">
				            <div class="span8">
				            <?php if($user):?>
				                <h2>Confirm</h2>  
				                <div id="info">
				                    <div id="user" class="mbm">
				                        <h3><?php echo htmlspecialchars($user->display_name); ?></h3> 
				                    </div>
				                </div>
				                <div class="alert-message block-message warning" id="actions" >
				                    <p><strong>Are you sure you want to delete this user?</strong></p>
				                    <div class="alert-actions" >
				                        <a class="btn danger" id="delete_btn" href="#">Delete</a> 
				                        <a class="btn" id="cancel_btn" href="<?php echo base_url('admin/users'); ?>">Cancel</a>
				                    </div>
				                </div>
				                <?php else: ?>
				                	
				                <h3>Oops, something went wrong!</h3>
				                 
				                <?php endif;?>  
				            </div>
				        </div> 
						
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

<script>
    $().ready(function(){
        $('#main-bar').dropdown();
        
        $("#delete_btn").one("click", function() {
            $.get("<?php echo base_url('admin/ajax/deleteUser_ajax'); ?>", { id : <?php echo $user->id; ?> }, deleteCallback, "json" );
            return false;
        });
    });
    
    function deleteCallback(data) {  
        if (data.success) {
            $("#info").html("");
            $("#actions").removeClass('warning').addClass('success').find('p').html('<strong>'+data.msg+'</strong>');
            $("#actions").find('.alert-actions').html('').append('<a href="<?php echo base_url('admin/users'); ?>" id="cancel_btn" class="btn small">Go back</a>'); 
        } else {
            $("#info").html("");
            $("#actions").removeClass('warning').addClass('error').find('p').html('<strong>'+data.error+'</strong>');
            $("#actions").find('.alert-actions').html('').append('<a href="<?php echo base_url('admin/users'); ?>" id="cancel_btn" class="btn small">Go back</a>').append('<a href="#" id="delete_btn" class="btn small">Or try again</a>');
            $("#delete_btn").one("click", function() {
                $.get("<?php echo base_url('admin/ajax/deleteUser_ajax'); ?>", { id : <?php echo $user->id; ?> }, deleteCallback, "json" );
                return false;
            });           
            
        }
    }
</script>

<?php $this->load->view('admin/page-end'); ?>