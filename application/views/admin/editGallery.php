<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Edit Gallery</h1>
			</div><!-- adminhead -->
		
			<div id="adminbody">
		
				<div id="adminbody-content">
					
					<div class="wrap">
						<!-- content goes here -->
						
					    <div class="row">
						    <div class="span16">
						        
						        <div class="actions topAction clearfix" id="top-actions">  
									
						        </div>
						        

						        <h3>Gallery Images</h3>
                  
						        <form>
						            <div class="clearfix" id="image_upload">

										<div id="browse_btn">		
											<noscript>			
												<p>Please enable JavaScript to use file uploader.</p>
												<!-- or put a simple form for upload here -->
											</noscript>         
										</div>


						            </div>
						            

						            <div id="image_info"></div>
						            <div class="alert-message block-message" id="message-image-box" style="display: none;">
						                
						            </div>
						        </form>
						        <div id="message-image">
						        </div>
						        
						        
						        <div class="clearfix">
						            <div class="well" >
						                <ul id="grid" class="media-grid">
						                    <?php if(isset($gallery->photos)&&is_array($gallery->photos)&&count($gallery->photos)>0) :?> 
						                    <?php foreach($gallery->photos as $image): ?>
						                    <li>
						                        <div class="grid-item">
						                            <img src="<?php echo base_url('img/galleryphotos/').$image->thumb_url; ?>"></img>
						                            <div class="item-options">
						                                <a href="" class="del-image" image_id="<?php echo $image->id; ?>" image_name="<?php echo htmlspecialchars($image->url); ?>">delete</a>
						                            </div>
						                        </div>
						                    </li>
						                    <?php endforeach; ?>
						                    <?php endif;?>
						                </ul>
						            </div>
						        </div><!-- /clearfix -->
						    </div><!-- span16 -->
					    </div><!-- row -->    
						
						<!-- content ends here -->
						<br class="clear">
						
						<div id="modal-from-dom" class="modal hide fade">
				            <div class="modal-header">
				              <a href="#" class="close">&times;</a>
				              <h3>Are you sure?</h3>
				            </div>
				            <div class="modal-body">
				              <p>That you want to delete this image.</p>
				            </div>
				            <div class="modal-footer">
				              <a id="delete-no" href="#" class="btn secondary">No</a>
				              <a id="delete-yes" href="#" class="btn danger">Yes</a>
				            </div>
				            
				            
				        </div>
				        
					</div>

					<div class="clear"></div>
				</div><!-- adminbody-content -->
				<div class="clear"></div>
			</div><!-- adminbody -->
			<div class="clear"></div>
		</div><!-- admincontent -->
		
<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript" src="<?php echo base_url('js/libs/fileuploader.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/plugins/bootstrap-modal.js'); ?>"></script>

<script type="text/javascript">
	var delete_image_id;
    $().ready(function(){
    	$('#modal-from-dom').modal({
    		backdrop: true,
    		keyboard: true
    	});
    	$('#delete-yes').click(function(e){
    		e.preventDefault();
    		deleteImage(delete_image_id);
    	});
    	$('#delete-no').click(function(e){
    		e.preventDefault();
    		$('#modal-from-dom').modal('hide');
    	});

        $('.del-image').each(function(){
            var img_id = $(this).attr('image_id');
            $(this).click(function(e){
                e.preventDefault();
                $(this).lunchModal(); 
            });
        });
        createUploader();
    });
    
    function createUploader(){           
        var uploader = new qq.FileUploader({
            element: document.getElementById('browse_btn'),
            action: '<?php echo base_url('admin/ajax/multiple_upload_ajax'); ?>',
            debug: true,
            onComplete:  function(id, fileName, responseJSON){   
                $('#upload_progress').hide(); 
                if(responseJSON.success){
                	
                	var image_url = responseJSON.tempurl; 
                	var image_name = responseJSON.filename;
                	
                	addPhotoDb(image_url, image_name);
                }   
                
            }
        });     

    }
    
        
    function addPhotoDb(image_url, image_name ){
    	console.log("upisivanje u bazu =====");
    	$.post(
    		"<?php echo base_url('admin/ajax/addPhotoDb_ajax'); ?>",
    		{ 
    			url: encodeURIComponent(image_url),
    			file_name: encodeURIComponent(image_name),
    			gallery_id: <?php echo $gallery->id; ?>
    		}, 
    		addImageCallBack,
    		"json"
    	);
    }
                                                                                                                                                                                                         
    function addImageCallBack(data){
        if(data.success){ 
			
            var li = $('<li>');
            var div = $('<div class="grid-item">');
            
            var img = $('<img>');
            img.attr('src', '<?php echo base_url('img/galleryphotos/thumbs/'); ?>'+data.img_url);
            div.append(img);
            

            
            var optionsDiv  = '<div class="item-options">';
            	optionsDiv += '<a href="" class="del-image" image_id="'+data.id+'" image_name="">delete</a>';
            	optionsDiv += '</div>';
            	
            div.append(optionsDiv);
            
            
            $('.del-image', div).click(function(e){
            	e.preventDefault();
            	$(this).lunchModal();
            })


            
            li.append(div);
            $('#grid').append(li);
              
        }   
        else{
            renderMessage(data.error, $('#message-image'), 'error');
        }     
    }
    
    function deleteImage(id){
        $.get('<?php echo base_url('admin/ajax/deleteImage_ajax'); ?>', { id : id}, deleteImageCallBack, 'json' );
        return false;   
    }
    
    function deleteImageCallBack(data){
        if(data.success){
        	$('#modal-from-dom').modal('hide');
            $('.del-image').each(function(){
                if($(this).attr('image_id') == data.id){
                    $(this).parent().parent().remove();
                }
            });    
        }else{
            alert(data.error);
        }    
    }
    
    function renderMessage(message, element, type){
        
        //var offset = element.offset();
        
        $.scrollTo(element, 400);
        
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
    
    $.fn.lunchModal = function(){
    	delete_image_id = $(this).attr('image_id');
    	$('#modal-from-dom').modal('show');
    }
</script>

<?php $this->load->view('admin/page-end'); ?>