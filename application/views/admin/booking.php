<?php $this->load->view('admin/header'); ?>
		
		<div id="adminmenuback"></div>
		<div id="adminmenuwrap">
			<div id="adminmenushadow"></div>
			
		</div><!-- adminmenuwrap -->
		
		<div id="admincontent">
		
			<div id="adminhead">
				<h1>Booking Calendar</h1>
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
						

						
						<div class="row" style="margin-left:0;">
							
							  <div id="house"></div>
									
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
	<!-- BOOKING SYSTEM -->

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('BookingCalendar/css/jquery.dop.BookingCalendar.css'); ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('BookingCalendar/css/style.css');?>" />

        <script type="text/JavaScript" src="<?php echo base_url('BookingCalendar/js/jquery.dop.BookingCalendar.js'); ?>"></script>

  	<script type="text/JavaScript">
            $(document).ready(function(){
                $('#house').DOPBookingCalendar({'Type':'BackEnd', 'DataURL':'../../BookingCalendar/php/load.php?id=<?php echo $id; ?>', 'SaveURL':'../../BookingCalendar/php/save.php?id=<?php echo $id; ?>'});
            });
        </script>


<?php $this->load->view('admin/page-end'); ?>
