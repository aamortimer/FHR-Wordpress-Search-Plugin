<?php
	require_once('api.php');
	
	$locaiton = isset($_GET['location']) ? $_GET['location'] : 'lounges';
	$airports = fhr::airports($locaiton);
	$sel_airport = isset($_GET['airport']) ? $_GET['airport'] : 1;
	
	foreach($airports as $airport) {
		if ($airport->airportid == $sel_airport) {
			echo '<option value="'.$airport->airportid.'" selected="selected">'.$airport->airport.'</option>';
		} else {
			echo '<option value="'.$airport->airportid.'">'.$airport->airport.'</option>';
		}
	}
?>