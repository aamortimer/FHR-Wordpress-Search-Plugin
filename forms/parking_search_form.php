<?php
	function parking_search_form($search_form, $airports, $rooms, $form, $agent, $affwin, $airport) {
		$options = get_option('fhr_settings');
		$results_airport = isset($options['results_airport']) ? $options['results_airport'] : '';
		$results_type = isset($options['results_type']) ? $options['results_type'] : '';
		$results_page = isset($options['results_page']) ? $options['results_page'] : '';
		
		$default_airport = ($airport) ? $airport : $results_airport;
		$sel_airport = isset($_GET['airport']) ? $_GET['airport'] : 1;
		$sel_parking_from = isset($_GET['parking-from']) ? $_GET['parking-from'] : false;
		$sel_parking_start_hour = isset($_GET['parking-start-hour']) ? $_GET['parking-start-hour'] : '12';
		$sel_parking_start_min = isset($_GET['parking-start-min']) ? $_GET['parking-start-min'] : '00';
		$sel_parking_to = isset($_GET['parking-to']) ? $_GET['parking-to'] : false;
		$sel_parking_end_hour = isset($_GET['parking-end-hour']) ? $_GET['parking-end-hour'] : '12';
		$sel_parking_end_min = isset($_GET['parking-end-min']) ? $_GET['parking-end-min'] : '00';
		
		if ($affwin !== '') {
			$search_form_p = $search_form;
			$search_form = 'http://www.awin1.com/cread.php';
		}	
	

		$airport_options = '';
		foreach($airports as $airport) {
			if ( ($sel_airport && $airport->airportid == $sel_airport) || (strtolower($airport->airport) == $default_airport)) {
				$airport_options .= '<option value="'.$airport->airportid.'" selected="selected">'.$airport->airport.'</option>';
			} else {
				$airport_options .= '<option value="'.$airport->airportid.'">'.$airport->airport.'</option>';
			}
		}

		$start_hours = '';
		foreach(range(0, 23) as $i) {
	  	if (str_pad($i, 2, "0", STR_PAD_LEFT) == $sel_parking_start_hour) {
				$start_hours = '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'" selected="selected">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>';
	  	} else {
				$start_hours = '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>';
	  	}
	  }

	  $start_mins = '';
		for($i=0;$i<=55;$i=$i+5) {
			if ($sel_parking_start_min == str_pad($i, 2, "0", STR_PAD_LEFT)) {
				$start_mins .= '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'" selected="selected">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>';
			} else {
				$start_mins .= '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>';
			}
		}

		$end_hours = '';
		foreach(range(0, 23) as $i) {
	  	if (str_pad($i, 2, "0", STR_PAD_LEFT) == $sel_parking_end_hour) {
				$end_hours = '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'" selected="selected">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>';
	  	} else {
				$end_hours = '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>';
	  	}
	  }

	  $end_mins = '';
	  for($i=0;$i<=55;$i=$i+5) {
			if ($sel_parking_end_min == str_pad($i, 2, "0", STR_PAD_LEFT)) {
				$end_mins .= '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'" selected="selected">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>';
			} else {
				$end_mins .= '<option value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>';
			}
		}

		$hidden_fields = '';
		if ($results_type == 'iframe') {
			$hidden_fields .= '<input type="hidden" name="popup" value="true" />';
		}
	  $hidden_fields .= '<input type="hidden" name="page_id" value="'.$results_page.'" />';
		$hidden_fields .= '<input type="hidden" name="agent" value="'.$agent.'" />';
		
		if ($affwin !== '') {
			$hidden_fields .= '<input type="hidden" name="awinmid" value="3000">';
			$hidden_fields .= '<input type="hidden" name="awinaffid" value="'.$affwin.'">';
			$hidden_fields .= '<input type="hidden" name="clickref" value="">';
			$hidden_fields .= '<input type="hidden" name="OverrideAgent" value="'.$agent.'">';
			$hidden_fields .= '<input type="hidden" name="p" value="'.$search_form_p.'">';
		}

		$html = '
		<form action="'.$search_form.'" method="get"  id="fhr_parking" class="fhr-form">
			<div class="form-group">
				<label for="parking-airport" class="control-label">Airport: </label>
				<select name="airport" id="parking-airport">
					'.$airport_options.'
				</select>	    
			</div>
			
			<div class="form-group">
				<label for="parking-from" class="control-label">Parking From: </label>
				<input type="text" name="parking-from" id="parking-from" value="'.$sel_parking_from.'" placeholder="dd/mm/yyyy" class="datepicker"><span class="add-on date"><i class="icon-calendar"></i></span>
			</div>	
			
			<div class="form-group">
				<label for="parking-start-hour" class="control-label">Drop-off time: </label>
		  	<select name="parking-start-hour" id="parking-start-hour">
		  		'.$start_hours.'
		  	</select>	    	
		  	<select name="parking-start-min" id="parking-start-min">
		  		'.$start_mins.'
		  	</select>
		  </div>	    

			<div class="form-group">
				<label for="parking-to" class="control-label">Parking To: </label>
				<input type="text" name="parking-to" id="parking-to" value="'.$sel_parking_to.'" placeholder="dd/mm/yyyy" class="datepicker"><span class="add-on date"><i class="icon-calendar"></i></span>
			</div>   
		   		
		  <div class="form-group">
				<label for="parking-end-hour" class="control-label">Landing Time: </label>
		    <select name="parking-end-hour" id="parking-end-hour">
			    '.$end_hours.'
		    </select>	    	
		    <select name="parking-end-min" id="parking-end-min">
		    	'.$end_mins.'
		    </select>
			</div>	
		   	
		  '.$hidden_fields.'
			
			<button type="submit" class="button">Get a Quote</button>
		</form>';

		return $html;
	}
?>
