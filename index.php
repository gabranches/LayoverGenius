<?php

include('connect.php');
include('functions.php');

if(!isset($_GET['code'])){
	$frontpage=1;
} else {
	$frontpage=0;
}

if(isset($_POST['envelope'])){
	$envelope=0;
} else {
	$envelope=1;
}

$code = mysqli_real_escape_string($mysqli, $_GET['code']);
$a = mysqli_real_escape_string($mysqli, $_GET['a']);

$i = 0;
$error = 0;
$json_array=array();

if(isset($_GET['h'])){
	$h = mysqli_real_escape_string($mysqli, $_GET['h']);
} else if(isset($_POST['h'])){
	$h = mysqli_real_escape_string($mysqli, $_POST['h']);
} else {
	$h = 6;
}

if(isset($_GET['m'])){
	$m = mysqli_real_escape_string($mysqli, $_GET['m']);
} else if(isset($_POST['m'])){
	$m = mysqli_real_escape_string($mysqli, $_POST['m']);
} else {
	$m = '00';
}

$layover_input_time = $h + $m / 60;

// Query current airport

$airport_query = "SELECT * FROM airports WHERE code = '" . $code . "'";
$airport_result = $mysqli->query($airport_query);

while($row = mysqli_fetch_array($airport_result)){
	$aipt_lat =  $row['gps_lat'];
	$aipt_long =  $row['gps_long'];
	$aipt_country =  seoUrl($row['country']);
	$aipt_city =  $row['city'];
	$aipt_coords = $aipt_lat . "," . $aipt_long;
	$aipt_travel_mode = $row['transportation_mode'];
	$aipt_code =  $row['code'];
}	

//Query specific activity if it is in the address, based on the alias
if ($a){
	$a_query = "SELECT * FROM activities WHERE alias= '" . $a. "' LIMIT 1";
	$a_result = $mysqli->query($a_query);
	
	while($row = mysqli_fetch_array($a_result)){
		$json_array[] = getRowJSON ($row, $json_array, $aipt_coords, $aipt_travel_mode);
	}
}

//Query all activities associated with the airport

$activity_query = "SELECT * FROM activities WHERE airport_code = '" . $code . "' AND layover_howlong <= ".$layover_input_time." ORDER BY RAND()";
$activity_result = $mysqli->query($activity_query);
$num_results = mysqli_num_rows($activity_result ); 

if($num_results==0) {
	$error = 1;
}

while($row = mysqli_fetch_array($activity_result )){
	if(!isset($json_array[$row['alias']])) {
		$json_array[] = getRowJSON($row, $json_array, $aipt_coords, $aipt_travel_mode);
	}
}


// Get all airports

$allairport_query = "SELECT * FROM airports ORDER BY code ASC";
$allairport_result = $mysqli->query($allairport_query);

while($row = mysqli_fetch_array($allairport_result)){
	if($row['country']){
		$airport_ar[] = $row['code'] . "   - " . $row['name'] . ", " . $row['city'] . ", " . $row['country'];
	} else {
		$airport_ar[] = $row['code'] . "   - " . $row['name'] . ", " . $row['city'];
	}
}	

function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}
	
?>

<!DOCTYPE html>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"></meta>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
  
<link rel="stylesheet" type="text/css" href="/css/style.css">

<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

<?php

if($code){
	echo("<title>What to do on a layover in ".$aipt_code.", ".$aipt_city." | Layover Genius</title>");
} else {
	echo("<title>Layover Genius</title>");
}

?>

</head>

<body>

<div id='social_menu'>
	<div class="g-plusone" data-size="medium" data-annotation="none" data-width="300"></div>
	<div class="fb-like" data-href="https://www.facebook.com/layovergenius" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
	<div class="twitter-share"><a href="https://twitter.com/layovergenius" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @layovergenius</a></div>
</div>

<div id='main_container'>
	<div id='top_logo'><div onclick="location.href='/';" style="cursor: pointer;" id='title'>layover genius</div><div id='subtitle'>DISCOVER HOW MUCH YOU CAN DO ON A LAYOVER</div></div>
	<div id='top_logo_bg'></div>
	<div id='tagline'>EXPLORE A <span id='newcity'>NEW CITY</span> BEFORE YOUR NEXT FLIGHT</div>
	<div id='boarding_pass'>
		<div id='envelope' <?php if($envelope==0) { echo("style='display:none;'"); } ?>><img src='/images/envelope.png' /></div>
		<div id='envelope_bottom' <?php if($envelope==0) { echo("style='display:none;'"); } ?>></div>
		<div id='bubble'>
			<img src='/images/NotInterestedBubble.png'>
		</div>
		<div id='stub'>
			<div id='stub_top'>Welcome</div>
			<div id='stub_body'>
				<form id='main_form' action="index.php" method="post">
				<div id='stub_details'>ENTER YOUR LAYOVER DETAILS:</div>
				<div id='airport_container' class='field_container'>
					<div id='airport_header' class='field_header'>Where is your layover?</div>
					
					<span id='plane'><img src='/images/Plane.png'></span>
					<div id='airport' class='stub_field'>
						<?php if (!$code) { ?>
							<div id='airport_field_text'>Type airport / city</div>
						<?php } ?>
						<div class="ui-widget">
							<input id="aipt" value="<?php echo($code); ?>">
						</div>
					</div>
					<div id='airport_border' class='field_border'></div>
				</div>
				<div id='howlong_container' class='field_container'>
					<div id='howlong_header' class='field_header'>How long is it? <span style='top:0px;' class='littletext'>(Round down)</span></div>
					<span id='clock'><img src='/images/Clock.png'></span>
					<div id='howlong' class='stub_field'>
						<span class="ui-widget">
							<input id="h" <?php if($frontpage==1) { echo("style='color:lightgrey;'"); } ?> name="h" value="<?php echo($h);?>">
						</span>
						<span id='howlong_text_h'>H</span>
						<span class="ui-widget">
							 <input id="m" name="m" <?php if($frontpage==1) { echo("style='color:lightgrey;'"); } ?> value="<?php echo($m);?>">
						</span>
						<span id='howlong_text_m'>M</span>
					<div id='howlong_border' class='field_border'></div>
					</div>
				</div>
				<?php if($code !='') { echo("<input type='hidden' name='envelope' value='0'>"); } ?>
				<div id='submit_button'>FIND AN ACTIVITY</div>
				</form>
			</div>
		</div>
		<div id='ticket' class="tip">
			<div id='ticket_top'>
			
			<?php
			if ($code){
				echo("<span id='top_text'>We recommend:</span> <div id='x_button'><img src='/images/Xbutton.png'></div>");
			} 
			?>
				 	
			</div>
			<div id='ticket_body'>
				<?php
				if ($code){
					include('ticket.php');
				} else {
					include('frontpage.php');
				}
				?>
			</div>
		</div>
	</div>
	
	<div id='footer'>
		<div>
			Concept / Design by Lawrence Tran | Developed by Gustavo Abranches | Editor: Marcus Oda | Photo: John Chock
		</div>
		<div style='position: absolute; right: 10px; top: 10px;'>
			Have an idea for a city? <div id="idea_button"><a class="typeform-share button" href="https://layovergenius.typeform.com/to/yTwYAu" data-mode="1" target="_blank">SUBMIT IT HERE</a></div>
		</div>
		
	</div>
</div>

<div style="clear: both;"></div>



<?php include('main.js'); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54483941-1', 'auto');
  ga('send', 'pageview');

</script>

<script src="https://apis.google.com/js/platform.js" async defer></script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>(function(){var qs,js,q,s,d=document,gi=d.getElementById,ce=d.createElement,gt=d.getElementsByTagName,id='typef_orm',b='https://s3-eu-west-1.amazonaws.com/share.typeform.com/';if(!gi.call(d,id)){js=ce.call(d,'script');js.id=id;js.src=b+'share.js';q=gt.call(d,'script')[0];q.parentNode.insertBefore(js,q)}id=id+'_';if(!gi.call(d,id)){qs=ce.call(d,'link');qs.id=id;qs.href=b+'share-button.css';s=gt.call(d,'head')[0];s.appendChild(qs,s)}})()</script>

</body>
</html>