<?php
	function lounge_search_form($search_form, $airports, $form, $agent, $affwin, $airport) {
		$options = get_option('fhr_settings');
		$results_airport = isset($options['results_airport']) ? $options['results_airport'] : '';
		$results_type = isset($options['results_type']) ? $options['results_type'] : '';
		$results_page = isset($options['results_page']) ? $options['results_page'] : '';
		$results_form = isset($options['results_form']) ? $options['results_form'] : '';


		$default_airport = ($airport) ? $airport : $results_airport;
		$sel_lounge_location = isset($_GET['lounge_location']) ? $_GET['lounge_location'] : 'ukLounges';
		$sel_airport = isset($_GET['airport']) ? $_GET['airport'] : 1;
		$sel_lounge_from = isset($_GET['lounge_from']) ? $_GET['lounge_from'] : false;
		$sel_adults = isset($_GET['noadults']) ? $_GET['noadults'] : 2;
		$sel_children = isset($_GET['nochildren']) ? $_GET['nochildren'] : 0;
		$sel_infants = isset($_GET['noinfants']) ? $_GET['noinfants'] : 0;

		if ($affwin !== '') {
			$search_form_p = $search_form;
			$search_form = 'http://www.awin1.com/cread.php';
		}	

		$uk_selected = ($sel_lounge_location == 'ukLounges') ? 'selected="selected"' : '';
		$int_selected = ($sel_lounge_location == 'intLounges') ? 'selected="selected"' : '';

		$lounge_location = '';
		$lounge_location .= '<option value="ukLounges" '.$uk_selected.'>UK</option>';
		$lounge_location .= '<option value="intLounges" '.$int_selected.'>International</option>';

		$airport_options = '';
		foreach($airports as $airport) {
			if ( ($sel_airport && $airport->airportid == $sel_airport) || (strtolower($airport->airport) == $default_airport)) {
				$airport_options .= '<option value="'.$airport->airportid.'" selected="selected">'.$airport->airport.'</option>';
			} else {
				$airport_options .= '<option value="'.$airport->airportid.'">'.$airport->airport.'</option>';
			}
		}

		$no_adults = '';
		foreach(range(1,9) as $i) {
			if ($i == $sel_adults) {
				$no_adults .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			} else {
				$no_adults .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}

		$no_children = '';
		foreach(range(1,9) as $i) {
			if ($i == $sel_children) {
				$no_children .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			} else {
				$no_children .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}

		$no_infants = '';
		foreach(range(1,9) as $i) {
			if ($i == $sel_infants) {
				$no_infants .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			} else {
				$no_infants .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}


		$hidden_fields = '';
		if ($results_type == 'iframe') {
			$hidden_fields .= '<input type="hidden" name="popup" value="true" />';
		}
		$hidden_fields .= '<input type="hidden" name="page_id" value="'.$results_page.'" />';
		$hidden_fields .= '<input type="hidden" name="agent" value="='.$agent.'" />';

		if ($affwin !== '') {
			$hidden_fields .= '<input type="hidden" name="awinmid" value="3000">';
			$hidden_fields .= '<input type="hidden" name="awinaffid" value="'.$affwin.'">';
			$hidden_fields .= '<input type="hidden" name="clickref" value="">';
			$hidden_fields .= '<input type="hidden" name="OverrideAgent" value="'.$agent.'">';
			$hidden_fields .= '<input type="hidden" name="p" value="'.$search_form_p.'">';
		}

		$html = '
			<form action="'.$search_form.'" method="get" id="fhr_lounge" class="fhr-form">	
				<div class="form-group">
					<label for="lounge_location" class="control-label">Lounge Location: </label>
					<select name="lounge_location" id="lounge_location">
						'.$lounge_location.'
					</select>
				</div>
					
				<div class="form-group">
					<label for="lounge_airport" class="control-label">Airport: </label>
					<select name="airport" id="lounge-airport">
						'.$airport_options.'
					</select>
				</div>
					
				<div class="form-group">
					<label for="lounge-from" class="control-label">Date of Visit: </label>
					<input type="text" name="lounge-from" id="lounge-from" value="'.$sel_lounge_from.'" placeholder="dd/mm/yyyy" class="datepicker"><span class="add-on date"><i class="icon-calendar"></i></span>
				</div>
					
				<div class="form-group" id="passengers">
					<label class="control-label" for="noadults">Passengers:</label>
			    <label class="radio">
						<select name="noadults" id="noadults">
							'.$no_adults.'
						</select> Adults
					</label>
					<label class="radio"> 
						'.$no_children.'
						</select> Children
					</label>
					<label class="radio">
						<select name="noinfants" id="noinfants" class="span1">
							'.$no_infants.'
						</select> Infants
					</label>
				</div>
					
				'.$hidden_fields.'
				
				<button type="submit" class="button">Get a Quote</button>
			</form>
		';

		return $html;
	}
?>
