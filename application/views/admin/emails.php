<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>User Mail Addresses</h1>
			</div><!-- adminhead -->
		
			<div id="adminbody">
		
				<div id="adminbody-content">
					
					<div class="wrap">
						<!-- content goes here -->
						
						<div class="row">
							<div class="span16">
								<div id="brands_data_error"></div>
							</div>
						</div>
						

						
						<div class="row">
							
							<div class="span16 mbl">
						
							</div><!-- span16 -->
							
							<div class="span16">
								
								<div id="emails-table-box" class="mbm hidden">     
									<table cellpadding="0" cellspacing="0" border="0" class="display" id="emails-table">
										<thead>
											<tr>
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
					</div><!-- wrap --> 

					<div class="clear"></div>
				</div><!-- adminbody-content -->
				<div class="clear"></div>
			</div><!-- adminbody -->
			<div class="clear"></div>
		</div><!-- admincontent -->
		
<?php $this->load->view('admin/footer'); ?>

<script type="text/javascript">
    var oTable; 
    var emails_data = <?php echo json_encode($emails); ?>;
    $().ready(function(){
        $('#main-bar').dropdown();
        if(emails_data.success){
            initDatatable();    
        }
        else{
            initEmailsDataError();   
        }
    });  
    
    function initDatatable(){
        $("#emails-table-box").removeClass('hidden');
        oTable = $('#emails-table').dataTable({
            "bProcessing": true,
            "aaData": emails_data.emails,
            "aaSorting": [[1,'asc']],
            "aoColumns": [ 
                { "mDataProp": "email",      "sTitle": "Email"  }

            ],
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        });       
    }
    
    function initEmailsDataError(){
        var markup;  
        markup  = '<div class="alert-message block-message warning">';
        markup += '<p><strong>There are no emails stored in database yet!</strong> </p>';
        markup += '</div>';
        
       $("#emails_data_error").html(markup); 
    }

</script>

<?php $this->load->view('admin/page-end'); ?>
