<?php
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
?>
<form action="<?php echo $search_form; ?>" method="get" id="fhr_lounge" class="fhr-form">	
	<div class="form-group">
		<label for="lounge_location" class="control-label">Lounge Location: </label>
		<select name="lounge_location" id="lounge_location">
			<option value="ukLounges" <?php echo ($sel_lounge_location == 'ukLounges') ? 'selected="selected"' : ''; ?>>UK</option>
			<option value="intLounges"  <?php echo ($sel_lounge_location == 'intLounges') ? 'selected="selected"' : ''; ?>>International</option>
		</select>
	</div>
		
	<div class="form-group">
		<label for="lounge_airport" class="control-label">Airport: </label>
		<select name="airport" id="lounge-airport">
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
		<label for="lounge-from" class="control-label">Date of Visit: </label>
		<input type="text" name="lounge-from" id="lounge-from" value="<?php echo $sel_lounge_from; ?>" placeholder="dd/mm/yyyy" class="datepicker"><span class="add-on date"><i class="icon-calendar"></i></span>
	</div>
		
	<div class="form-group" id="passengers">
		<label class="control-label" for="noadults">Passengers:</label>
    <label class="radio">
			<select name="noadults" id="noadults">
				<?php foreach(range(1,9) as $i) : ?>
					<?php if ($i == $sel_adults) : ?>
						<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
					<?php else: ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select> Adults
		</label>
		<label class="radio"> 
			<select name="nochildren" id="nochildren">
				<?php foreach(range(0,9) as $i) : ?>
					<?php if ($i == $sel_children) : ?>
						<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
					<?php else: ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select> Children
		</label>
		<label class="radio">
			<select name="noinfants" id="noinfants" class="span1">
				<?php foreach(range(0,9) as $i) : ?>
					<?php if ($i == $sel_infants) : ?>
						<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
					<?php else: ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select> Infants
		</label>
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