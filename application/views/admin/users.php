<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Users</h1>
			</div><!-- adminhead -->
		
			<div id="adminbody">
		
				<div id="adminbody-content">
					
					<div class="wrap">
						<!-- content goes here -->
						
				        <div class="row">
					        <div class="span16">
					            <div id="users_data_error"></div>
					        </div>
				        </div><!-- row -->
				        
				        <div class="row">
				        	
				        	<div class="span16 mbl">
				        		<span class="pull-right"> 
					                <a class="btn" id="add_user_btn" href="<?php echo base_url('admin/users/addUser'); ?>">Add new user</a>
					            </span>	
				        	</div>
				        	
					        <div class="span16">

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
    var oTable; 
    var users_data = <?php echo json_encode($users); ?>;
    $().ready(function(){
        $('#main-bar').dropdown();
        if(users_data.success){
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
            "aaData": users_data.users,
            "aaSorting": [[1,'asc']],
            "aoColumns": [ 
                { "mDataProp": "display_name",      "sTitle": "Name", "sWidth": "300", "sClass": "tc_display_name"  },
                { "mDataProp": "username",   "sTitle": "Username", "sWidth": "100", "sClass": "tc_username" },
                { "mDataProp": "email", "sTitle": "Email", "sWidth": "100", "sClass": "tc_email" },                
                {   "bSortable" : true,    "sTitle": "Privilegies", "sWidth": "60",
                    "fnRender": function ( oObj ) {
                        if(oObj.aData.privilegies == 1){
                            return 'Administrator';
                        }                
                        else if(oObj.aData.g_published == 0){
                            return 'Moderator';
                        }
                        else{
                            return 'None'; 
                        }                                                                                                                   
                    } 
                },
                {   "bSortable" : false,    "sTitle": "Actions", "sWidth": "80",
                    "fnRender": function ( oObj ) {
                        return "<a href='<?php echo base_url('admin/users/editUser/'); ?>"+oObj.aData.id+"' class='edit-btn'>Edit</a>&nbsp;|&nbsp;" + "<a href='<?php echo base_url('admin/users/deleteUser/'); ?>"+oObj.aData.id+"' class='delete-btn'>Delete</a>";    
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

</script>

<?php $this->load->view('admin/page-end'); ?>
