<?php
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
?>
<form action="<?php echo $search_form; ?>" method="get"  id="fhr_parking" class="fhr-form">
	<div class="form-group">
		<label for="parking-airport" class="control-label">Airport: </label>
		<select name="airport" id="parking-airport">
			<?php foreach($airports as $airport): ?>
				<?php if ( ($sel_ariport && $airport->airportid == $sel_airport) || (strtolower($airport->airport) == $default_airport)) : ?>
					<option value="<?php echo $airport->airportid; ?>" selected="selected"><?php echo $airport->airport; ?></option>
				<?php else: ?>
					<option value="<?php echo $airport->airportid; ?>"><?php echo $airport->airport; ?></option>				
				<?php endif; ?>
			<?php endforeach; ?>
		</select>	    
	</div>
	
	<div class="form-group">
		<label for="parking-from" class="control-label">Parking From: </label>
		<input type="text" name="parking-from" id="parking-from" value="<?php echo $sel_parking_from; ?>" placeholder="dd/mm/yyyy" class="datepicker"><span class="add-on date"><i class="icon-calendar"></i></span>
	</div>	
	
	<div class="form-group">
		<label for="parking-start-hour" class="control-label">Drop-off time: </label>
  	<select name="parking-start-hour" id="parking-start-hour">
  		<?php foreach(range(0, 23) as $i) : ?>
  			<?php if (str_pad($i, 2, "0", STR_PAD_LEFT) == $sel_parking_start_hour) : ?>
  				<option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" selected="selected"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
  			<?php else: ?>
  				<option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
  			<?php endif; ?>
  		<?php endforeach; ?>
  	</select>	    	
  	<select name="parking-start-min" id="parking-start-min">
  		<option value="00" <?php echo ($sel_parking_start_min == '00') ? 'selected="selected"' : '' ?>>00</option>
  		<option value="05" <?php echo ($sel_parking_start_min == '05') ? 'selected="selected"' : '' ?>>05</option>
  		<option value="10" <?php echo ($sel_parking_start_min == '10') ? 'selected="selected"' : '' ?>>10</option>
  		<option value="15" <?php echo ($sel_parking_start_min == '15') ? 'selected="selected"' : '' ?>>15</option>
  		<option value="20" <?php echo ($sel_parking_start_min == '20') ? 'selected="selected"' : '' ?>>20</option>
  		<option value="25" <?php echo ($sel_parking_start_min == '25') ? 'selected="selected"' : '' ?>>25</option>
  		<option value="30" <?php echo ($sel_parking_start_min == '30') ? 'selected="selected"' : '' ?>>30</option>
  		<option value="35" <?php echo ($sel_parking_start_min == '35') ? 'selected="selected"' : '' ?>>35</option>
  		<option value="40" <?php echo ($sel_parking_start_min == '40') ? 'selected="selected"' : '' ?>>40</option>
  		<option value="45" <?php echo ($sel_parking_start_min == '45') ? 'selected="selected"' : '' ?>>45</option>
  		<option value="50" <?php echo ($sel_parking_start_min == '50') ? 'selected="selected"' : '' ?>>50</option>
  		<option value="55" <?php echo ($sel_parking_start_min == '55') ? 'selected="selected"' : '' ?>>55</option>
  	</select>
  </div>	    

	<div class="form-group">
		<label for="parking-to" class="control-label">Parking To: </label>
		<input type="text" name="parking-to" id="parking-to" value="<?php echo $sel_parking_to; ?>" placeholder="dd/mm/yyyy" class="datepicker"><span class="add-on date"><i class="icon-calendar"></i></span>
	</div>   
   		
  <div class="form-group">
		<label for="parking-end-hour" class="control-label">Landing Time: </label>
    <select name="parking-end-hour" id="parking-end-hour">
	    <?php foreach(range(0, 23) as $i) : ?>
  			<?php if (str_pad($i, 2, "0", STR_PAD_LEFT) == $sel_parking_end_hour) : ?>
  				<option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" selected="selected"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
  			<?php else: ?>
  				<option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
  			<?php endif; ?>
  		<?php endforeach; ?>
    </select>	    	
    <select name="parking-end-min" id="parking-end-min">
    	<option value="00" <?php echo ($sel_parking_end_min == '00') ? 'selected="selected"' : '' ?>>00</option>
  		<option value="05" <?php echo ($sel_parking_end_min == '05') ? 'selected="selected"' : '' ?>>05</option>
  		<option value="10" <?php echo ($sel_parking_end_min == '10') ? 'selected="selected"' : '' ?>>10</option>
  		<option value="15" <?php echo ($sel_parking_end_min == '15') ? 'selected="selected"' : '' ?>>15</option>
  		<option value="20" <?php echo ($sel_parking_end_min == '20') ? 'selected="selected"' : '' ?>>20</option>
  		<option value="25" <?php echo ($sel_parking_end_min == '25') ? 'selected="selected"' : '' ?>>25</option>
  		<option value="30" <?php echo ($sel_parking_end_min == '30') ? 'selected="selected"' : '' ?>>30</option>
  		<option value="35" <?php echo ($sel_parking_end_min == '35') ? 'selected="selected"' : '' ?>>35</option>
  		<option value="40" <?php echo ($sel_parking_end_min == '40') ? 'selected="selected"' : '' ?>>40</option>
  		<option value="45" <?php echo ($sel_parking_end_min == '45') ? 'selected="selected"' : '' ?>>45</option>
  		<option value="50" <?php echo ($sel_parking_end_min == '50') ? 'selected="selected"' : '' ?>>50</option>
  		<option value="55" <?php echo ($sel_parking_end_min == '55') ? 'selected="selected"' : '' ?>>55</option>
    </select>
	</div>	
   	
  <?php if ($results_type == 'iframe') : ?><input type="hidden" name="popup" value="true" /><?php endif; ?>
  <input type="hidden" name="page_id" value="<?php echo $results_page; ?>" />
	<input type="hidden" name="agent" value="<?php echo $agent; ?>" />
	
	<?php if ($affwin !== '') : ?>
		<input type="hidden" name="awinmid" value="3000">
		<input type="hidden" name="awinaffid" value="<?php echo $affwin; ?>">
		<input type="hidden" name="clickref" value="">
		<input type="hidden" name="OverrideAgent" value="<?php echo $agent; ?>">
		<input type="hidden" name="p" value="<?php echo ($search_form_p); ?>">
	<?php endif; ?>
	
	<button type="submit" class="button">Get a Quote</button>
</form>