<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Menu</h1>
			</div><!-- adminhead -->
		
			<div id="adminbody">
		
				<div id="adminbody-content">
					
					<div class="wrap">
						
						    <div class="row">
						        <div>
						            <div id="galleries_data_error"></div>
						        </div>
						    </div><!-- row -->
						<!-- content goes here -->
						
						<div class='left'>
							<h3>Edit <?php echo $dish->title ?></h3>
							<p>Dish Type: </p>
							<select id='meal_type'>
								<?php foreach($categories as $cat){
									if($cat==$dish->category){
										echo "<option selected='selected' value='".$cat->cat."'>".$cat->cat."</option>";
									}
									else{
										echo "<option value='".$cat->id."'>".$cat->cat."</option>";
									}
								} ?>
							</select>
							<br/><br/>
							<p>Title: </p>
							<input type='text' name='title' id='title' value='<?php echo $dish->title; ?>' placeholder='Enter gallery title here' />
							<br/><br/>
							<p>Název: </p>
							<input type='text' name='title_cz' value='<?php echo $dish->title_cz; ?>'  id='title_cz' placeholder='Ovde unesite ime jela' />
							<br/><br/>
							<p>Ingredients (description): </p>
							<textarea rows="7" name='desc' id='desc' placeholder='Enter description here'><?php echo $dish->description; ?></textarea>
							<br /><br/>
							<p>Složení: </p>
							<textarea rows="7" name='desc_cz' id='desc_cz' placeholder='Unesite sastojke ovde'><?php echo $dish->description_cz; ?></textarea>
							<br /><br/>
							<p>Cena / price: </p>
							<input type='text' value='<?php echo $dish->price; ?>'  name='price' id='price' placeholder='Enter price here' />
							<br />
							<br />
							<input class="btn primary transition" type="button" onclick="updateDish()" value="Edit">
							<div id='gallery_create_error'></div>
						</div>
						
						<div class='right'>
							  <div class="row">
					        <div class="span16">
					            <div id="users_data_error"></div>
					        </div>
				        </div><!-- row -->
				        
				        <div class="row">

					            <div id="users-table-box" class="mbm hidden">     
						            <table cellpadding="0" cellspacing="0" border="0" class="display" id="users-table">
						                <thead>
						                    <tr>
						                        <th></th> 
						                        <th></th> 
						                        <th></th>  
						                        <th></th> 
						                        <th></th> 
						                    </tr>
						                </thead>
						                <tbody></tbody>
						            </table>
						   		</div>   
					       </div><!-- span16 -->
				       </div><!-- row --> 
						</div>
						
							<div id="modal-from-dom" class="modal hide fade">
					            <div class="modal-header">
					              <a href="#" class="close">&times;</a>
					              <h3>Are you sure?</h3>
					            </div>
					            <div class="modal-body">
					              <p>That you want to delete this dish.</p>
					            </div>
					            <div class="modal-footer">
					              <a id="delete-no" href="#" class="btn secondary">No</a>
					              <a id="delete-yes" href="#" class="btn danger">Yes</a>
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
<script type="text/javascript" src="<?php echo base_url('js/plugins/bootstrap-modal.js'); ?>"></script>
<script type="text/javascript">
    var oTable; 
    var menu_data = <?php echo json_encode($menu); ?>;
    $().ready(function(){
        if(menu_data){
            initDatatable();    
        }
        else{
            initusersDataError();   
        }
    });  
    
    function initDatatable(){
        $("#users-table-box").removeClass('hidden');
        oTable = $('#users-table').dataTable({
            "bProcessing": true,
            "aaData": menu_data,
            "aaSorting": [[1,'asc']],
            "aoColumns": [ 
                { "mDataProp": "title",      "sTitle": "Title", "sWidth": "80" },
                { "mDataProp": "description",   "sTitle": "Description", "sWidth": "150" },
                { "mDataProp": "cat",   "sTitle": "Category", "sWidth": "150" },
                { "mDataProp": "price", "sTitle": "Price", "sWidth": "30"},  
                {   "bSortable" : false,    "sTitle": "Actions", "sWidth": "80",
                    "fnRender": function ( oObj ) {
                        if(oObj.aData.id){
                            return "<a href='<?php echo base_url('admin/menu/editDish'); ?>/"+oObj.aData.id+"' class='edit-btn'>Edit</a>"
							+ " / " + '<a href="#" dish-id="' + oObj.aData.id + '" class="del-dish">Delete</a>';    
                        }
                    } 
                }              

            ],
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                $(nRow).attr('user-id', aData.id);
                return nRow;
            },
            
            "fnInitComplete": function() { 
                $('.view-info-btn').bind('click', function(){
                    var row = $(this).parents('tr');
                    alert(row.attr('user-id')); 
                });
            }
            
        });       
    }
    
    function initusersDataError(){
        var markup;  
        markup  = '<div class="alert-message block-message warning">';
        markup += '<p><strong>There are no users stored in database yet!</strong> </p>';
        markup += '</div>';
        
       $("#users_data_error").html(markup); 
    }
    
    var delete_dish_id;
    $().ready(function(){
    	$('#modal-from-dom').modal({
    		backdrop: true,
    		keyboard: true
    	});
    	$('#delete-yes').click(function(e){
    		e.preventDefault();
    		deleteDish(delete_dish_id);
    	});
    	$('#delete-no').click(function(e){
    		e.preventDefault();
    		$('#modal-from-dom').modal('hide');
    	});

        $('.del-dish').each(function(){
            var dish_id = $(this).attr('dish_id');
            $(this).click(function(e){
                e.preventDefault();
                $(this).lunchModal(); 
            });
        });
        
    });
    
    $.fn.lunchModal = function(){
    	delete_dish_id = $(this).attr('dish-id');
    	$('#modal-from-dom').modal('show');
    }
    
    function updateDish()
    {
    	var id = <?php echo $dish->id; ?>;
    	var title = $('#title').val();
    	var title_cz = $('#title_cz').val();
    	var desc = $('#desc').val();
    	var desc_cz = $('#desc_cz').val();
    	var price = $('#price').val();
        var category = $('#meal_type').val();
        
    	$.ajax({
    		type: "POST",
	        url: "../../../ajax/update_dish",
	        dataType: "json",
	        data: "title="+title+"&title_cz="+title_cz+"&desc="+desc+"&desc_cz="+desc_cz+"&price="+price+"&category="+category+"&id="+id,
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
        					$("html, body").animate({ scrollTop: $(document).height() }, 1000);
                            
	          	}
	          	else
	          	{
	          		var markup;  
			        markup  = '<div class="alert-message block-message warning">';
			        markup += '<p><strong>' + data.error + '</strong> </p>';
			        markup += '</div>';
			        
			       $("#gallery_create_error").html(markup);
			       $("html, body").animate({ scrollTop: $(document).height() }, 1000);
	          	}
	            
	          }
    	});
    }
    
    function deleteDish(id)
    {  
        $.ajax({
            type: "POST", url: '../../../ajax/delete_dish', data: "id="+id,
            dataType: "json",
            success: function(data){
                if(data.success == true)
                {
                    var markup;  
                    markup  = '<div class="alert-message block-message success">';
                    markup += '<p><strong>Dish has been successfuly deleted!</strong> </p>';
                    markup += '</div>';

                    $("#galleries_data_error").html(markup);
                    
                    setTimeout(function()
                    { 
                        window.location = "http://www.bozioko.com/admin/menu";
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
