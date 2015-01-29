<script>

$(document).ready(function(){

	if(isMobile()){
		$('body').css("background","url(../images/wood_1.jpg)");
			
	
	}
	var error = <?php echo($error); ?>;
	var code = '<?php echo($code); ?>';
	var h = '<?php echo($h); ?>';
	var m = '<?php echo($m); ?>';
	var airports_ar = <?php echo json_encode($airport_ar); ?>;
        var availableTags = airports_ar;
	
        $("#aipt").autocomplete({
        	source: availableTags
        });
	
	
	// Sliding envelope
	
	if (code != '' && isMobile()) {
		$('#envelope').delay(700).fadeOut(500);
		$('#envelope_bottom').delay(700).fadeOut(500);
	} else {
		if(code != '') {
			$('#envelope').delay(700).animate({
				left: '150%',
			}, 1000, function() {
				$('#envelope').hide();
			});
			$('#envelope_bottom').delay(700).animate({
				left: '140%',
			}, 1000, function() {
				$('#envelope_bottom').hide();
			});
		}
	}


	if(code != '' && error ==0){
		var results = <?php echo json_encode($json_array); ?>;
		var currentActivity = 0;
		printPass(currentActivity, results);
	} else {
		showNoResultsPage();
	}
	
	$("#x_button").click(function(){
		$("#bubble").fadeOut(500);
		$("#x_button").css("display","none");
		$("#share_bubble").hide();
		$(".arrow-down").hide();
		$("#ticket").fadeOut(500, function(){
			currentActivity++;
			printPass(currentActivity, results);
		});
	});
	
	$("#restart_button").click(function(){
		$("#end_page").fadeOut(500, function(){
			currentActivity = 0;
			printPass(0,results);
		});
		$("#x_button").fadeIn(500);
	});
	
	$( "#x_button" ).hover(function() {
		$( this ).css("cursor","pointer");
	});

	function printPass(i, results) {
	
		var resultsCount = results.length;
		if(i == resultsCount-1){
			showEndPage();
			return;
		}
		
		if(i == 0) {
			$("#bubble").delay(3000).fadeIn(500);
			
		}
	
		if(results[i]['activity_name'] != ''){
			$("#top_text").show();
			$("#activity_container").show();
			$("#info_container").show();
			$("#ticket_right_side").show();
			$("#disclaimer").show();
			$("#ticket").fadeIn(500);
			$("#x_button").fadeIn(500);
			
		}	
	
		var activity_name = results[i]['activity_name'];
		var airport_code = results[i]['airport_code'];
		var city_nearby = results[i]['city_nearby'];
		var description = results[i]['description'];
		var google_maps_url = results[i]['google_maps_url'];
		var cost = results[i]['cost'];
		var travel_time_hour = results[i]['travel_time_hour'];
		var travel_time_minute = results[i]['travel_time_minute'];
		var total_time_hour = results[i]['total_time_hour'];
		var total_time_minute = results[i]['total_time_minute'];
		var activity_time_hour = results[i]['activity_time_hour'];
		var activity_time_minute = results[i]['activity_time_minute'];
		var layover_howlong = results[i]['layover_howlong'];
		var external_url = results[i]['external_url'];
		var alias = results[i]['alias'];
		
		var price_on = 'FREE';
		var price_off = '';
		
		switch(cost) {
			case "1":
				price_on = '$';
				price_off = '$$$';
				break;
			case "2":
				price_on = '$$';
				price_off = '$$';
				break;
			case "3":
				price_on = '$$$';
				price_off = '$';
				break;	
		}
		
		$("#activity").html(activity_name);
		$("#description").html(description);
		$("#price_on").html(price_on);
		$("#price_off").html(price_off);
		$("#travel_time_hour").html(travel_time_hour + ' ');
		$("#travel_time_minute").html(travel_time_minute + ' ');
		$("#activity_time_hour").html(activity_time_hour + ' ');
		$("#activity_time_minute").html(activity_time_minute + ' ');
		$("#total_time_hour").html(total_time_hour + ' ');
		$("#total_time_minute").html(total_time_minute + ' ');
		$("#directions_link_a").attr("href", google_maps_url);
		$("#external_url").attr("href", external_url);
		
		var share_url = "http://www.layovergenius.com/"+airport_code+"/"+alias+"?h="+h+"&m="+m;
		var share_title = "Fun things to do on a "+h+" hour layover in "+city_nearby;
		var facebook_url = "http://www.facebook.com/sharer/sharer.php?u="+share_url;
		var twitter_title = "Should I do this on my " +h+ " hour layover in " + city_nearby + "?";
		var twitter_url = "http://twitter.com/home?status=" + twitter_title;
		twitter_url += "+"+share_url;
		
		$("#facebook_link").attr("href", facebook_url);
		$("#twitter_link").attr("href", twitter_url);
		$("#share_url_box").val(share_url);
	}
	
	$("#airport_field_text").click(function(){
		$(this).hide();
		$("#aipt").select();
	});
	
	$("#aipt").click(function(){
		$('#airport_field_text').hide();
	});
	
	$("#aipt").focusout(function(){
		var val= $('#aipt').val(); 
		if (val.length == 0) {
			$('#airport_field_text').show();
		}
		
	});
	
	$("#fb_icon").mouseleave(function(){
		$(this).attr("src","/images/facebook.png");
	});
	
	$("#fb_icon").click(function(){
		$(this).attr("src","/images/FB_Click.png");
	});
	
	$("#fb_icon").mouseenter(function(){
		$(this).attr("src","/images/FB_Hover.png");
	});
	
	$("#twitter_icon").mouseenter(function(){
		$(this).attr("src","/images/Twitter_Hover.png");
	});
	
	$("#twitter_icon").mouseleave(function(){
		$(this).attr("src","/images/twitter.png");
	});
	
	$("#twitter_icon").click(function(){
		$(this).attr("src","/images/Twitter_Click.png");
	});
	
	$("#share_button").click(function(){
		$("#share_bubble").toggle();
		$(".arrow-down").toggle();
		$("#share_url_box").focus();
	});
	
	$("#h").click(function(){
		makeTimeBlack();
	});
	
	$("#m").click(function(){
		makeTimeBlack();
	});
	
	$("#visa").click(function(){
		$("#visa_widget").fadeIn(500, function(){
		});
	});
	
	$('#submit_button').click(function(){
		processForm();
	});
});
	
	


 
$(document).keypress(function(e) {
    if(e.which == 13) {
        processForm();
    }
});


function makeTimeBlack(){
	$("#h").css("color","black");
	$("#m").css("color","black");
}


function processForm(){
		var aipt_code =  $("#aipt").val();
		aipt_code = aipt_code.substring(0,3);
		 $('#main_form').attr('action', "/" + aipt_code);
		document.forms['main_form'].submit();
	}
	
	
function isMobile(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		return true;
	} else {
		return false;
	}
}

function showEndPage(){
		$("#top_text").hide();
		$("#activity_container").hide();
		$("#info_container").hide();
		$("#ticket_right_side").hide();
		$("#ticket").fadeIn(500);
		$("#end_page").fadeIn(500);
		$("#disclaimer").hide();
}
	
function showNoResultsPage(){
	$("#error_page").delay(1000).fadeIn(500);
	$("#top_text").hide();
	$("#info_container").hide();
	$("#ticket_right_side").hide();
	$("#disclaimer").hide();
}

$(document).mouseup(function (e)
{
    var container = $("#share_bubble");

    if (!container.is(e.target) 
        && container.has(e.target).length === 0) 
    {
        container.hide();
        $(".arrow-down").hide();
    }
});

</script>