<?php

function getRowJSON ($row, $array, $aipt_coords, $aipt_travel_mode) {
	$id=$row['id']; 
	$alias=$row['alias']; 
	$airport_code=$row['airport_code'];
	$city_nearby=utf8_encode($row['city_nearby']); 
	$activity_name=utf8_encode($row['activity_name']); 
	$activity_type=$row['activity_type']; 
	$description=utf8_encode($row['description']); 
	$address=utf8_encode($row['address']); 
	$gps_lat=$row['gps_lat']; 
	$gps_long=$row['gps_long']; 
	$cost=$row['cost']; 
	$travel_time=$row['travel_time']; 
	$travel_time_hour = getHour($travel_time);
	$travel_time_minute = getMinute($travel_time_hour, $travel_time);
	$activity_time=$row['activity_time'];
	$activity_time_hour = getHour($activity_time);
	$activity_time_minute = getMinute($activity_time_hour, $activity_time);
	$total_time = $travel_time + $activity_time;
	$total_time_hour = getHour($total_time);
	$total_time_minute = getMinute($total_time_hour, $total_time);
	$layover_howlong=$row['layover_howlong']; 
	$business_url=$row['business_url']; 
	$google_url=$row['google_url']; 
	$info_source=$row['info_source'];
	$coords = $gps_lat. "," . $gps_long;
	$google_maps_url = "http://maps.google.com/?saddr=".$aipt_coords."&daddr=".$coords."&dirflg=".$aipt_travel_mode;
	
	if($google_url){
		$external_url = $google_url;
	} else {
		$external_url = $business_url;
	}
	
	$entry_array = array(
		'airport_code'=> $airport_code,
		'id'=> $id,
		'alias'=> $alias,
		'city_nearby'=> $city_nearby,
		'activity_name'=> $activity_name,
		'activity_type'=> $activity_type,
		'description'=> $description,
		'address'=> $address,
		'google_maps_url'=> $google_maps_url,
		'cost'=> $cost,
		'travel_time_hour'=> $travel_time_hour,
		'travel_time_minute'=> $travel_time_minute,
		'total_time_hour'=> $total_time_hour,
		'total_time_minute'=> $total_time_minute,
		'activity_time_hour'=> $activity_time_hour,
		'activity_time_minute'=> $activity_time_minute,
		'layover_howlong'=> $layover_howlong,
		'external_url'=> $external_url,
		'info_source'=> $info_source
	);
	return $entry_array;
}

function getHour ($time){
	return floor($time);
}
	
function getMinute ($hour, $time){
	return ( ($time - $hour) * 60);
}

?>