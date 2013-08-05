<?php
	function hotel_search_form($search_form, $airports, $rooms, $form, $agent, $affwin, $airport) {
		$options = get_option('fhr_settings');
		$results_airport = isset($options['results_airport']) ? $options['results_airport'] : '';
		$results_type = isset($options['results_type']) ? $options['results_type'] : '';
		$results_page = isset($options['results_page']) ? $options['results_page'] : '';
		$results_form = isset($options['results_form']) ? $options['results_form'] : '';


		$default_airport = ($airport) ? $airport : $results_airport;
		$sel_airport = isset($_GET['airport']) ? $_GET['airport'] : false;	
		$sel_hotel_from = isset($_GET['hotel-from']) ? $_GET['hotel-from'] : false;
		$sel_room_type = isset($_GET['room-type']) ? $_GET['room-type'] : 2;
		$sel_rooms = isset($_GET['number-of-rooms']) ? $_GET['number-of-rooms'] : 1;
		$sel_parking_return = isset($_GET['parking-return']) ? $_GET['parking-return'] : false;
		
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


		$parking_return_html = '';
		if ($results_form == 'airport-parking-and-hotels') {
			$parking_return_html = '<div class="form-group">
														<label for="parking-return" class="control-label">Collect Car: </label>
														<input type="text" name="parking-return" id="parking-return" value="" placeholder="dd/mm/yyyy" class="datepicker">
														<span class="add-on date"><i class="icon-calendar"></i></span>
													</div>';
		}

		$room_options = '';
		foreach($rooms as $room) {
			if ($sel_room_type == $room->roomid) {
				$room_options .= '<option value="'.$room->roomid.'" selected="selected">'.$room->roomtype.'</option>';
			} else {
				$room_options .= '<option value="'.$room->roomid.'">'.$room->roomtype.'</option>';
			}
		}

		$number_of_room_options = '';
		foreach(range(1,5) as $i) {
			if ($i == $sel_rooms) {
				$number_of_room_options .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			} else {
				$number_of_room_options .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}

		$hidden_fields = '';
		if ($results_type == 'iframe') {
			$hidden_fields .= '<input type="hidden" name="popup" value="true" />';
		}
	  $hidden_fields .= '<input type="hidden" name="page_id" value="'.$results_page.'" />';
		$hidden_fields .= '<input type="hidden" name="agent" value="'.$agent.'" />';
		if ($results_form == 'airport-hotels') {
			$hidden_fields .= '<input type="hidden" name="parking-ind" id="parking-ind" value="2" />';
		} else {
			$hidden_fields .= '<input type="hidden" name="parking-options" id="parking-options" value="2">';
			$hidden_fields .= '<input type="hidden" name="parking-ind" id="parking-ind" value="1">';
		}

		if ($affwin !== '') {
			$hidden_fields .= '<input type="hidden" name="awinmid" value="3000">';
			$hidden_fields .= '<input type="hidden" name="awinaffid" value="'.$affwin.'">';
			$hidden_fields .= '<input type="hidden" name="clickref" value="">';
			$hidden_fields .= '<input type="hidden" name="OverrideAgent" value="'.$agent.'">';
			$hidden_fields .= '<input type="hidden" name="p" value="'.$search_form_p.'">';
		}

		$html = '
		<form action="'.$search_form.'" method="get" id="fhr_hotels" class="fhr-form">
			<div class="form-group">
				<label for="hotel-airport" class="control-label">Airport: </label>
				<select name="airport" id="hotel-airport">
					'.$airport_options.'
				</select>
			</div>
			
			<div class="form-group">
				<label for="hotel-from" class="control-label">Night of Stay: </label>
				<input type="text" name="hotel-from" id="hotel-from" value="'.$sel_hotel_from.'" placeholder="dd/mm/yyyy" class="datepicker"><span class="add-on date"><i class="icon-calendar"></i></span>
			</div>
			'.$parking_return_html.'
			<div class="form-group">
				<label for="parking-room-types" class="control-label">Room Type </label>
				<select name="room-type" id="parking-room-types">
					'.$room_options.'
				</select>
			</div>
			<div class="form-group">
				<label for="parking-rooms" class="control-label">Number of rooms </label>
				<select name="number-of-rooms" id="hotel-number-of-rooms">
					'.$number_of_room_options.'
				</select>
			</div>

		  '.$hidden_fields.'

			<button type="submit" class="button">Get a Quote</button>
		</form>';

		return $html;
	}
?>