<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Galleries</h1>
			</div><!-- adminhead -->
		
			<div id="adminbody">
				<div class='left'>
					<h3>Create new gallery</h3>
					<p>Gallery Type: </p>
					<select id='gallery_type'>
						<option value='p'>Photo Gallery</option>
						<option value='v'>Video Gallery</option>
					</select>
					<p>Title: </p>
					<input type='text' name='title' id='title' placeholder='Enter gallery title here' />
					<br />
					<br />
					<input class="btn primary transition" type="button" onclick="createGallery()" value="Create">
					<div id='gallery_create_error'></div>
				</div>
				<div class='right'>
					<h3>Manage Existing</h3>
					<div id="adminbody-content">
					
						<div class="wrap">
							<!-- content goes here -->
							
					        <div class="row">
						        <div>
						            <div id="galleries_data_error"></div>
						        </div>
						    </div><!-- row -->
						    
						    <div class="row">
						        <div>
						            <div id="galleries-table-box" class="mbm hidden">     
							            <table cellpadding="0" cellspacing="0" border="0" class="display" id="galleries-table">
							                <thead>
							                    <tr>
							                        <th></th> 
							                        <th></th> 
							                        <th></th>  
							                        	<!-- 		<th></th> 
							                        <th></th> 
							                        <th></th> 
							                        <th></th> -->
							                    </tr>
							                </thead>
							                <tbody></tbody>
							            </table>
						            </div>   
						       </div>
					       </div><!-- row --> 
	    					
	    					<!-- content ends here -->
							<br class="clear">
							
							<div id="modal-from-dom" class="modal hide fade">
					            <div class="modal-header">
					              <a href="#" class="close">&times;</a>
					              <h3>Are you sure?</h3>
					            </div>
					            <div class="modal-body">
					              <p>That you want to delete this gallery.</p>
					            </div>
					            <div class="modal-footer">
					              <a id="delete-no" href="#" class="btn secondary">No</a>
					              <a id="delete-yes" href="#" class="btn danger">Yes</a>
					            </div>
				        	</div>
				        	
						</div>
	
						<div class="clear"></div>
					</div><!-- adminbody-content -->
				</div>
				
				<div class="clear"></div>
			</div><!-- adminbody -->
			<div class="clear"></div>
		</div><!-- admincontent -->
		
<?php $this->load->view('admin/footer');  ?>
<script type="text/javascript" src="<?php echo base_url('js/plugins/bootstrap-modal.js'); ?>"></script>
<script type="text/javascript">
    var oTable; 
    var galleries_data = <?php echo json_encode($galleries); ?>;
    $().ready(function(){
        if(galleries_data.success){
            initDatatable();    
        }
        else{
            initgalleriesDataError();   
        }
    });  
    
    function initDatatable(){
        $("#galleries-table-box").removeClass('hidden');
        oTable = $('#galleries-table').dataTable({
            "bProcessing": true,
            "aaData": galleries_data.galleries,
            "aaSorting": [[1,'asc']],
            "aoColumns": [ 
                { "mDataProp": "title", "sTitle": "Gallery Title", "sWidth": "100", "sClass": "tc_title" },
                { "mDataProp": "type",   "sTitle": "Gallery Type", "sWidth": "100", "sClass": "tc_start" },
                {   "bSortable" : false,    "sTitle": "Actions", "sWidth": "80",
                    "fnRender": function ( oObj ) {
                        if(oObj.aData.id){
                            return "<a href='<?php echo base_url('admin/galleries/editGallery?id='); ?>"+oObj.aData.id+"' class='edit-btn'>Edit</a>" +
                               " / " + '<a href="#" gall-id="' + oObj.aData.id + '" class="del-gallery">Delete</a>';    
                        }
                    } 
                }
            ],
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        });       
    }
    
    function initgalleriesDataError(){
        var markup;  
        markup  = '<div class="alert-message block-message warning">';
        markup += '<p><strong>There are no galleries stored in database yet!</strong> </p>';
        markup += '</div>';
        
       $("#galleries_data_error").html(markup); 
    }
    
    function createGallery()
    {
    	var title = $('#title').val();
        var type = $('#gallery_type').val();
    	$.ajax({
    		type: "POST",
	        url: "../index.php/ajax/create_gallery",
	        dataType: "json",
	        data: "title="+title+"&type="+type,
	        cache:false,
	        success: 
	          function(data){
	          	if(data.success == true)
	          	{
                            var markup;  
                            markup  = '<div class="alert-message block-message success">';
                            markup += '<p><strong>' + data.msg + '</strong> </p>';
                            markup += '</div>';

                            $("#gallery_create_error").html(markup);
                            
                            setTimeout(function()
                            { 
                                location.reload();
                            }, 1000 ); 
                            
	          	}
	          	else
	          	{
	          		var markup;  
			        markup  = '<div class="alert-message block-message warning">';
			        markup += '<p><strong>' + data.error + '</strong> </p>';
			        markup += '</div>';
			        
			       $("#gallery_create_error").html(markup);
	          	}
	            
	          }
    	});
    }
    
    var delete_image_id;
   
    $().ready(function(){
    	$('#modal-from-dom').modal({
    		backdrop: true,
    		keyboard: true
    	});
    	$('#delete-yes').click(function(e){
    		e.preventDefault();
    		deleteGallery(delete_image_id);
    	});
    	$('#delete-no').click(function(e){
    		e.preventDefault();
    		$('#modal-from-dom').modal('hide');
    	});

        $('.del-gallery').each(function(){
            var gall_id = $(this).attr('gall_id');
            $(this).click(function(e){
                e.preventDefault();
                $(this).lunchModal(); 
            });
        });
        
        createUploader();
    });
    
    $.fn.lunchModal = function(){
    	delete_image_id = $(this).attr('gall-id');
    	$('#modal-from-dom').modal('show');
    }
    
    function deleteGallery(id)
    {  
        $.ajax({
            type: "POST", url: '../ajax/delete_gallery', data: "id="+id,
            dataType: "json",
            success: function(data){
                if(data.success == true)
                {
                    var markup;  
                    markup  = '<div class="alert-message block-message success">';
                    markup += '<p><strong>Gallery successfuly deleted!</strong> </p>';
                    markup += '</div>';

                    $("#galleries_data_error").html(markup);
                    
                    setTimeout(function()
                    { 
                        location.reload();
                    }, 1000 );
                }
                else
                {
                    var markup;  
                    markup  = '<div class="alert-message block-message warning">';
                    markup += '<p><strong>Fatal error occured while deleting gallery! Please try again.</strong> </p>';
                    markup += '</div>';

                    $("#galleries_data_error").html(markup);
                }
            }
        });
    }

</script>

<?php $this->load->view('admin/page-end'); ?>
