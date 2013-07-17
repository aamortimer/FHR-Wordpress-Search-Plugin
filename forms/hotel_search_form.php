<?php
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
?>
<form action="<?php echo $search_form; ?>" method="get" id="fhr_hotels" class="fhr-form">
	<div class="form-group">
		<label for="hotel-airport" class="control-label">Airport: </label>
		<select name="airport" id="hotel-airport">
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
		<label for="hotel-from" class="control-label">Night of Stay: </label>
		<input type="text" name="hotel-from" id="hotel-from" value="<?php echo $sel_hotel_from; ?>" placeholder="dd/mm/yyyy" class="datepicker"><span class="add-on date"><i class="icon-calendar"></i></span>
	</div>
	
	<?php if ($results_form == 'airport-parking-and-hotels') : ?>
	<div class="form-group">
		<label for="parking-return" class="control-label">Collect Car: </label>
		<input type="text" name="parking-return" id="parking-return" value="" placeholder="dd/mm/yyyy" class="datepicker"><span class="add-on date"><i class="icon-calendar"></i></span>
	</div>
	<?php endif; ?>
	
	<div class="form-group">
		<label for="parking-room-types" class="control-label">Room Type </label>
		<select name="room-type" id="parking-room-types">
			<?php foreach($rooms as $room) : ?>
				<?php if ($sel_room_type == $room->roomid) : ?>
					<option value="<?php echo $room->roomid; ?>" selected="selected"><?php echo $room->roomtype; ?></option>
				<?php else: ?>
					<option value="<?php echo $room->roomid; ?>"><?php echo $room->roomtype; ?></option>				
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="form-group">
		<label for="parking-rooms" class="control-label">Number of rooms </label>
		<select name="number-of-rooms" id="hotel-number-of-rooms">
			<?php foreach(range(1,5) as $i) : ?>
				<?php if ($i == $sel_rooms) : ?>
					<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
				<?php else: ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>

  <?php if ($results_type == 'iframe') : ?><input type="hidden" name="popup" value="true" /><?php endif; ?>
  <input type="hidden" name="page_id" value="<?php echo $results_page; ?>" />
	<input type="hidden" name="agent" value="<?php echo $agent; ?>" />
	<?php if ($results_form == 'airport-hotels') : ?>
		<input type="hidden" name="parking-ind" id="parking-ind" value="2" />
	<?php else: ?>
		<input type="hidden" name="parking-options" id="parking-options" value="2">	    	
		<input type="hidden" name="parking-ind" id="parking-ind" value="1">	
	<?php endif; ?>

	<?php if ($affwin !== '') : ?>
		<input type="hidden" name="awinmid" value="3000">
		<input type="hidden" name="awinaffid" value="<?php echo $affwin; ?>">
		<input type="hidden" name="clickref" value="">
		<input type="hidden" name="OverrideAgent" value="<?php echo $agent; ?>">
		<input type="hidden" name="p" value="<?php echo ($search_form_p); ?>">
	<?php endif; ?>

	<button type="submit" class="button">Get a Quote</button>
</form>
