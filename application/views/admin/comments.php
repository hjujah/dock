<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Comments</h1>
			</div><!-- adminhead -->
		
			<div id="adminbody">
			
				<div class='right'>
					<div id="adminbody-content">
					
						<div class="wrap">
							<!-- content goes here -->
							
					        <div class="row">
						        <div>
						            <div id="galleries_data_error"></div>
						        </div>
						    </div><!-- row -->
						    
						    <div class="row">
						    	<p><b>Unapproved</b></p>
						        <div>
						            <div id="commentsU-table-box" class="mbm hidden">     
							            <table cellpadding="0" cellspacing="0" border="0" class="display" id="commentsU-table">
							                <thead>
							                    <tr>
							                        <th></th> 
							                        <th></th> 
							                        <th></th>  
							                     	<th></th> 
							                        <!--<th></th> 
							                        <th></th> -->
							                    </tr>
							                </thead>
							                <tbody></tbody>
							            </table>
						            </div>   
						       </div>
					       </div><!-- row --> 
					       
					       <br/><br/>
					       
					       	<div class="row">
					       		<p><b>Approved</b></p>
						        <div>
						            <div id="commentsA-table-box" class="mbm hidden">     
							            <table cellpadding="0" cellspacing="0" border="0" class="display" id="commentsA-table">
							                <thead>
							                    <tr>
							                        <th></th> 
							                        <th></th> 
							                        <th></th>  
							                     	<th></th> 
							                        	<!-- <th></th> 
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
					              <p>That you want to delete this comment.</p>
					            </div>
					            <div class="modal-footer">
					              <a id="delete-no" href="#" class="btn secondary">No</a>
					              <a id="delete-yes" href="#" class="btn danger">Yes</a>
					            </div>
				        	</div>
				        	
				        	<div id="modal-from-dom2" class="modal hide fade">
					            <div class="modal-header">
					              <a href="#" class="close">&times;</a>
					              <h3>Are you sure?</h3>
					            </div>
					            <div class="modal-body">
					              <p>That you want to approve this comment.</p>
					            </div>
					            <div class="modal-footer">
					              <a id="delete-no2" href="#" class="btn secondary">No</a>
					              <a id="delete-yes2" href="#" class="btn danger">Yes</a>
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
    var commentsA = <?php echo json_encode($commentsA); ?>;
    var commentsU = <?php echo json_encode($commentsU); ?>;
    $().ready(function(){   	
        if(commentsA.success){
            initDatatable();    
        }       
        if(commentsU.success){
            initDatatableUn();    
        }
    });  
    
    function initDatatable(){
        $("#commentsA-table-box").removeClass('hidden');
        oTable = $('#commentsA-table').dataTable({
            "bProcessing": true,
            "aaData": commentsA.comments,
            "aaSorting": [[1,'asc']],
            "aoColumns": [ 
                { "mDataProp": "name", "sTitle": "Name", "sWidth": "200", "sClass": "tc_title" },
                { "mDataProp": "email",   "sTitle": "E-mail", "sWidth": "100", "sClass": "tc_start" },
                { "mDataProp": "comment",   "sTitle": "comment", "sWidth": "100", "sClass": "tc_start" },
                {   "bSortable" : false,    "sTitle": "Actions", "sWidth": "80",
                    "fnRender": function ( oObj ) {
                        if(oObj.aData.id){
                            return '<a href="#" gall-id="' + oObj.aData.id + '" class="del-comment">Delete</a>';  
                        }
                    } 
                }
            ],
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        });       
    }
    
      function initDatatableUn(){
        $("#commentsU-table-box").removeClass('hidden');
        oTable = $('#commentsU-table').dataTable({
            "bProcessing": true,
            "aaData": commentsU.comments,
            "aaSorting": [[1,'asc']],
            "aoColumns": [ 
                { "mDataProp": "name", "sTitle": "Name", "sWidth": "200", "sClass": "tc_title" },
                { "mDataProp": "email",   "sTitle": "E-mail", "sWidth": "100", "sClass": "tc_start" },
                { "mDataProp": "comment",   "sTitle": "Comments", "sWidth": "100", "sClass": "tc_start" },
                {   "bSortable" : false,    "sTitle": "Actions", "sWidth": "80",
                    "fnRender": function ( oObj ) {
                        if(oObj.aData.id){
                         	return '<a href="#" gall-id="' + oObj.aData.id + '" class="app-comment">Approve</a>'+
                         	" / " + '<a href="#" gall-id="' + oObj.aData.id + '" class="del-comment">Delete</a>';  
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
        markup += '<p><strong>There are no comments yet...</strong> </p>';
        markup += '</div>';
        
       $("#galleries_data_error").html(markup); 
    }
    
    var delete_image_id;
   
    $().ready(function(){
    	/*delete*/
    	$('#modal-from-dom').modal({
    		backdrop: true,
    		keyboard: true
    	});
    	$('#delete-yes').click(function(e){
    		e.preventDefault();
    		deleteComment(delete_image_id);
    	});
    	$('#delete-no').click(function(e){
    		e.preventDefault();
    		$('#modal-from-dom').modal('hide');
    	});

        $('.del-comment').each(function(){
            var gall_id = $(this).attr('gall_id');
            $(this).click(function(e){
                e.preventDefault();
                $(this).lunchModal(); 
            });
        });
        
        /*approve*/
        $('#modal-from-dom2').modal({
    		backdrop: true,
    		keyboard: true
    	});
    	$('#delete-yes2').click(function(e){
    		e.preventDefault();
    		approveComment(delete_image_id);
    	});
    	$('#delete-no2').click(function(e){
    		e.preventDefault();
    		$('#modal-from-dom2').modal('hide');
    	});

        $('.app-comment').each(function(){
            var gall_id = $(this).attr('gall_id');
            $(this).click(function(e){
                e.preventDefault();
                $(this).lunchModal2(); 
            });
        });
        
    });
    
    $.fn.lunchModal = function(){
    	delete_image_id = $(this).attr('gall-id');
    	$('#modal-from-dom').modal('show');
    }
    
    $.fn.lunchModal2 = function(){
    	delete_image_id = $(this).attr('gall-id');
    	$('#modal-from-dom2').modal('show');
    }
    
    function deleteComment(id)
    {  
        $.ajax({
            type: "POST", url: '../ajax/delete_comment', data: "id="+id,
            dataType: "json",
            success: function(data){
                if(data.success == true)
                {
     				$('#modal-from-dom').modal('hide');
                    var markup;  
                    markup  = '<div class="alert-message block-message success">';
                    markup += '<p><strong>Comment successfuly deleted!</strong> </p>';
                    markup += '</div>';

                    $("#galleries_data_error").html(markup);
                    
                    setTimeout(function()
                    { 
                        location.reload();
                    }, 1000 );
                }
                else
                {
                	$('#modal-from-dom').modal('hide');
                    var markup;  
                    markup  = '<div class="alert-message block-message warning">';
                    markup += '<p><strong>Fatal error occured while deleting comment! Please try again.</strong> </p>';
                    markup += '</div>';

                    $("#galleries_data_error").html(markup);
                }
            }
        });
    }
    
    
    function approveComment(id)
    {  
        $.ajax({
            type: "POST", url: '../ajax/approve_comment', data: "id="+id,
            dataType: "json",
            success: function(data){
                if(data.success == true)
                {
     				$('#modal-from-dom').modal('hide');
                    var markup;  
                    markup  = '<div class="alert-message block-message success">';
                    markup += '<p><strong>Comment successfuly approved!</strong> </p>';
                    markup += '</div>';

                    $("#galleries_data_error").html(markup);
                    
                    setTimeout(function()
                    { 
                        location.reload();
                    }, 1000 );
                }
                else
                {
                	$('#modal-from-dom').modal('hide');
                    var markup;  
                    markup  = '<div class="alert-message block-message warning">';
                    markup += '<p><strong>Fatal error occured while approving comment! Please try again.</strong> </p>';
                    markup += '</div>';

                    $("#galleries_data_error").html(markup);
                }
            }
        });
    }

</script>

<?php $this->load->view('admin/page-end'); ?>
