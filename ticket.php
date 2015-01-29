<div id='ticket_left_side'>		
	<div id='activity_container'>
		
		<div id='activity'></div>
		
		<div id='description'></div>
	</div>
	
	<div id='info_container'>
		<div id='ticket_toprow_container'>
									
			<div id='price_container' class='field_container'>
				<div id='price_header' class='field_header'>PRICE</div>
				<div id='price' class='ticket_field'><span id='price_on'></span><span id='price_off' class='graytext'></span></div>
				<div class='field_border'></div>
			</div>
			
			<div id='operation_container' class='field_container'>
				<div id='operation_header' class='field_header'>WEBSITE</div>
				<div id='operation' class='ticket_field'><a target='_blank' id='external_url' href=''>VIEW HERE</a></div>
				<div class='field_border'></div>
			</div>
			<div style="clear: both;"></div>
		</div>
		
		<div id='ticket_bottomrow_container'>
			<div id='visa_container' class='field_container'>
				<div id='visa_header' class='field_header'>VISA REQUIREMENTS</div>
				<div id='visa' class='ticket_field'><a target='_blank' href=<?php echo("'http://" . $aipt_country . ".visahq.com'"); ?>>FIND HERE</a></div>
				<div class='field_border'></div>
			</div>
			
			<div id='social_container' class='field_container'>
				<div id='social_header' class='field_header'>SHARE THIS IDEA</div>
				<div id='social' class='ticket_field'><span class='social_icon'><a target='_blank' id='facebook_link' href=''><img id='fb_icon' src='/images/facebook.png'></a></span><span class='social_icon'><a target='_blank' id='twitter_link' href=''><img id='twitter_icon' src='/images/twitter.png'></a></span><div id='share_button'>SHARE LINK</div></div>
				<div class='field_border'></div>
			</div>
			
			 <div id='share_bubble'><span style="position: relative; top: -3px;"><strong>COPY LINK: </strong></span><br /><textarea id="share_url_box" cols="25" rows="4" onfocus="this.select();"></textarea></div>
			 <div class='arrow-down'></div>
			
			<div style="clear: both;"></div>
		</div>
	</div>
	
	<div id='end_page' style='display:none;'>
		<div id='end_text'>You've breezed through our list of selected activities!</div>
		<div id='breeze'><img src='/images/breeze.png'></div>
		<div id='restart_button'>START OVER</div>
	</div>
	
	<div id='error_page' style='display:none;'>
	
		<div id='error_img'><img src='/images/error_page.png' /></div>
		<div id='error_text'>Your layover is too short! We don't recommend leaving <?php echo($code); ?>.</div>
		<div id='error_text2'>We don't support your airport yet. View our supported airports.</div>
	</div>
</div>
<div id='ticket_right_side'>
		<div id='total_time_container' class='field_container'>
			<div id='total_time_header' class='field_header'>ESTIMATED TOTAL TIME</div>
			<div id='total_time' class='ticket_field'><span id='total_time_hour'></span> <span class='total_time_letter'>HR </span><span id='total_time_minute'> </span><span class='total_time_letter'>M</span></div>
		</div>
	
		<div style="clear: both;"></div>
	
		<div id='time_details_container'>
			<div id='travel_time_header' class='field_header'>TRAVEL TIME</div>
			<div id='travel_time'><span id='travel_time_hour'> </span>HR <span id='travel_time_minute'> </span> M <span class='littletext'>(round trip)</span></div>
			<div id='directions_link'><a id='directions_link_a' target='_blank' href='/'>Directions</a></div>
		</div>
		
		<div id='activity_details_container'>
			<div id='activity_time_header' class='field_header'>ACTIVITY TIME</div>
			<div id='activity_time'><span id='activity_time_hour'> </span>HR <span id='activity_time_minute'> </span>M</div>
		</div>

</div>
<div id='disclaimer'>Airlines recommend arriving ~2 hours before your departure. “Estimated total time” do not include this buffer.</div>