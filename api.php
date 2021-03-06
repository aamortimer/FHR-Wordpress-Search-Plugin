<?php
	class fhr {
		static function airports($type) {
			$url = self::get('http://www.fhr-net.co.uk/api/airports.php?type='.$type);
			return json_decode($url);
		}
	
		static function room_types() {
			$url = self::get('http://www.fhr-net.co.uk/api/rooms.php');
			return json_decode($url);
		}
		
		static function lounge_search() {
			$options = get_option('fhr_settings');
			
			$airport 						= isset($_GET['airport']) ? $_GET['airport'] : false;
			$arrival_date 			= isset($_GET['lounge-from']) ? $_GET['lounge-from'] : false;
			$adults				 			= isset($_GET['adults']) ? $_GET['adults'] : false;
			$children			 			= isset($_GET['children']) ? $_GET['children'] : 0;
			$infants			 			= isset($_GET['infants']) ? $_GET['infants'] : false;
			$agent							= $options['agent'];
			$affwin							= $options['affwin'];

			$data = self::get('http://www.fhr-net.co.uk/api/lounge-search.php?airport='.$airport.'&lounge-from='.$arrival_date.'&adults='.$adults.'&children='.$children.'&infants='.$infants.'&agent='.$agent);
			$data = json_decode($data);
			
			$affwin_link = '';
			if ($affwin) {
				$affwin_link = 'http://www.awin1.com/cread.php?awinmid=3000&awinaffid='.$affwin.'&OverrideAgent='.$agent.'&clickref=&p=';
			}
			
			//print_r($data);die();
			
			if ($data) {
			?>
				<div id="fhr-search-details">
					<h2>Search Details</h2>
					<ul>
						<li><strong>Airport</strong> <?php echo $data->search_details->airport; ?></li>
						<li><strong>Arrival Date</strong> <?php echo $data->search_details->lounge_from; ?></li>
						<li><strong>Adults</strong> <?php echo $data->search_details->adults; ?></li>
						<li><strong>Children</strong> <?php echo $data->search_details->children; ?></li>
						<li><strong>Infants</strong> <?php echo $data->search_details->infants; ?></li>
					</ul>
				</div>
				<div id="fhr-search-results" class="fhr-airport-lounges">
					<?php foreach($data->lounges as $result) : ?>
						<div class="fhr-results">
							<h2 class="fhr-results-title">
								<a href="<?php echo $affwin_link.$result->deeplink; ?>" title="<?php echo $result->airportLoungeName; ?> More Information">
									<?php echo $result->airportLoungeName; ?>
								</a>
							</h2>
							<span class="fhr-results-image">
								<img src="<?php echo $result->picture; ?>" title="<?php echo $result->airportLoungeName; ?>" alt="<?php echo $result->airportLoungeName; ?>" />
							</span>
							<ul class="fhr-results-sales-messages">
								<?php if ($result->sales_message1 !== '') : ?><li><?php echo $result->sales_message1; ?></li><?php endif; ?>
								<?php if ($result->sales_message2 !== '') : ?><li><?php echo $result->sales_message2; ?></li><?php endif; ?>
								<?php if ($result->sales_message3 !== '') : ?><li><?php echo $result->sales_message3; ?></li><?php endif; ?>
								<?php if ($result->sales_message4 !== '') : ?><li><?php echo $result->sales_message4; ?></li><?php endif; ?>
							</ul>
							<span class="fhr-results-price">
								<strong>&#163;<?php echo $result->total_price; ?> </strong>
								<a href="<?php echo $affwin_link.$result->booking_deeplink; ?>" title="Book <?php echo $result->airportLoungeName; ?>" class="fhr-button">Book Now</a>
							</span>
							
						</div>
					<?php endforeach; ?>
				</div>
			<?php
			} else {
				echo '<div class="error">Sorry we were unable to complete your search please try again later.</div>';
			}

		}
		
		static function parking_search() {
			$options = get_option('fhr_settings');
			
			$airport 						= isset($_GET['airport']) ? $_GET['airport'] : false;
			$arrival_date 			= isset($_GET['parking-from']) ? $_GET['parking-from'] : false;
			$arrival_time_hour	= isset($_GET['parking-start-hour']) ? $_GET['parking-start-hour'] : false;
			$arrival_time_min 	= isset($_GET['parking-start-min']) ? $_GET['parking-start-min'] : false;
			$return_date 				= isset($_GET['parking-to']) ? $_GET['parking-to'] : false;
			$return_time_hour		= isset($_GET['parking-end-hour']) ? $_GET['parking-end-hour'] : false;
			$return_time_min		= isset($_GET['parking-end-min']) ? $_GET['parking-end-min'] : false;
			$agent							= $options['agent'];
			$affwin							= $options['affwin'];
					
			$data = self::get('http://www.fhr-net.co.uk/api/parking-search.php?airport='.$airport.'&parking-from='.$arrival_date.'&parking-to='.$return_date.'&parking-start-hour='.$arrival_time_hour.'&parking-start-min='.$arrival_time_min.'&parking-end-hour='.$return_time_hour.'&parking-end-min='.$return_time_min.'&agent='.$agent);
			$data = json_decode($data);
			
			//print_r($data);die();
			
			$affwin_link = '';
			if ($affwin) {
				$affwin_link = 'http://www.awin1.com/cread.php?awinmid=3000&awinaffid='.$affwin.'&OverrideAgent='.$agent.'&clickref=&p=';
			}
			
			if ($data) {
			?>
				<div id="fhr-search-details">
					<h2>Search Details</h2>
					<ul>
						<li><strong>Airport</strong> <?php echo $data->search_details->airport; ?></li>
						<li><strong>Arrival Date and Time</strong> <?php echo $data->search_details->arrival_date; ?> at <?php echo $data->search_details->arrival_time; ?></li>
						<li><strong>Return Date and Time</strong> <?php echo $data->search_details->return_date; ?> at <?php echo $data->search_details->return_time; ?></li>
					</ul>
				</div>
				<div id="fhr-search-results" class="fhr-airport-parking">
				<?php foreach($data->carparks as $carpark) : ?>
					<div class="fhr-results">
						<h2 class="fhr-results-title">
							<a href="<?php echo $affwin_link.$carpark->deeplink; ?>" title="<?php echo $carpark->car_park_name; ?> More Information">
								<?php echo $carpark->car_park_name; ?>
							</a>
						</h2>
						<span class="fhr-results-image">
							<img src="<?php echo $carpark->picture; ?>" title="<?php echo $carpark->car_park_name; ?>" alt="<?php echo $carpark->car_park_name; ?>" />
						</span>
						<ul class="fhr-results-sales-messages">
							<?php if ($carpark->sales_messages_1 !== '') : ?><li><?php echo $carpark->sales_messages_1; ?></li><?php endif; ?>
							<?php if ($carpark->sales_messages_2 !== '') : ?><li><?php echo $carpark->sales_messages_2; ?></li><?php endif; ?>
							<?php if ($carpark->sales_messages_3 !== '') : ?><li><?php echo $carpark->sales_messages_3; ?></li><?php endif; ?>
							<?php if ($carpark->sales_messages_4 !== '') : ?><li><?php echo $carpark->sales_messages_4; ?></li><?php endif; ?>
						</ul>
						<span class="fhr-results-price">
							<strong>&#163;<?php echo $carpark->price; ?></strong>
							<a href="<?php echo $affwin_link.$carpark->booking_deeplink; ?>" title="Book <?php echo $carpark->car_park_name; ?>" class="fhr-button">Book Now</a>
						</span>
						
					</div>
				<?php endforeach; ?>
				</div>
			<?php
			} else {
				echo '<div class="error">Sorry we were unable to complete your search please try again later.</div>';
			}
		}

		static function hotel_search() {
			$options = get_option('fhr_settings');

			$airport 						= isset($_GET['airport']) ? $_GET['airport'] : false;
			$hotel_from 				= isset($_GET['hotel-from']) ? $_GET['hotel-from'] : false;
			$room_type 					= isset($_GET['room-type']) ? $_GET['room-type'] : false;
			$number_of_rooms 		= isset($_GET['number-of-rooms']) ? $_GET['number-of-rooms'] : false;
			$parking_return 		= isset($_GET['parking-return']) ? $_GET['parking-return'] : false;
			$hotel_stay 				= isset($_GET['hotel-stay']) ? $_GET['hotel-stay'] : false;
			$parking_options 		= isset($_GET['parking-options']) ? $_GET['parking-options'] : false;
			$parking_ind 				= isset($_GET['parking-ind']) ? $_GET['parking-ind'] : false;
			$hotel_stay_before  = isset($_GET['hotel-stay']) ? $_GET['hotel-stay'] : false;
			$agent							= $options['agent'];
			$affwin							= $options['affwin'];
		
			if ($options['results_form'] == 'airport-hotels') {
				$url = 'http://www.fhr-net.co.uk/api/hotel-search.php?airport='.$airport.'&hotel-from='.$hotel_from.'&room-type='.$room_type.'&number-of-rooms='.$number_of_rooms.'&parking-options='.$parking_options.'&parking-ind='.$parking_ind.'&agent='.$agent;
			} else {
				$url = 'http://www.fhr-net.co.uk/api/hotel-search.php?airport='.$airport.'&hotel-from='.$hotel_from.'&room-type='.$room_type.'&number-of-rooms='.$number_of_rooms.'&parking-return='.$parking_return.'&parking-options='.$parking_options.'&parking-ind='.$parking_ind.'&agent='.$agent;
			}

			$data = self::get($url);
			$data = json_decode($data);

			if ($data) {
				?>
					<div id="fhr-search-details">
					<h2>Search Details</h2>
					<ul>
						<li><strong>Airport</strong> <?php echo $data->search_details->airport; ?></li>
						<li><strong>Arrival Date</strong> <?php echo $data->search_details->arrival_date; ?></li>
						<li><strong>Room(s)</strong> <?php echo $data->search_details->number_of_rooms; ?> * <?php echo $data->search_details->room; ?></li>
					</ul>
				</div>
				<div id="fhr-search-results" class="fhr-airport-hotel">
					<?php foreach($data->hotels as $hotel) : ?>
						<div class="fhr-results">
							<h2 class="fhr-results-title">
								<a href="<?php echo $affwin_link.$hotel->deeplink; ?>" title="<?php echo $hotel->hotel_name; ?> More Information">
									<?php echo $hotel->hotel_name; ?>
								</a>
							</h2>
							<span class="fhr-results-image">
								<img src="<?php echo $hotel->picture; ?>" title="<?php echo $hotel->hotel_name; ?>" alt="<?php echo $hotel->hotel_name; ?>" />
							</span>
							<ul class="fhr-results-sales-messages">
								<?php if ($hotel->sales_messages_1 !== '') : ?><li><?php echo $hotel->sales_messages_1; ?></li><?php endif; ?>
								<?php if ($hotel->sales_messages_2 !== '') : ?><li><?php echo $hotel->sales_messages_2; ?></li><?php endif; ?>
								<?php if ($hotel->sales_messages_3 !== '') : ?><li><?php echo $hotel->sales_messages_3; ?></li><?php endif; ?>
								<?php if ($hotel->sales_messages_4 !== '') : ?><li><?php echo $hotel->sales_messages_4; ?></li><?php endif; ?>
							</ul>
							
							<?php
								$room_match = false;
								$matching_rooms = array();
								$non_matching_rooms = array();
								foreach($hotel->rooms as $room) {
									if ($data->search_details->room === $room->room_type) {
										$room_match = true;
										$matching_rooms[] = $room;
									} else {
										$non_matching_rooms[] = $room;
									}
								}
							?>

							<?php if (!$matching_rooms) : ?>
								<p>This hotel has no <strong><?php echo $data->search_details->room; ?></strong> but we did find the following similar room types.</p>
							<?php endif; ?>	

							<table class="fhr-price-table" id="hotel_<?php echo $hotel->hotel_id; ?>">
								<?php if ($matching_rooms) : ?>
									
									<?php foreach($matching_rooms as $room) : ?>
										<tr>
											<td class="fhr-table-desc"><?php echo $number_of_rooms.' x '.$room->room_type; ?> Room<br /><?php echo $room->room_desc; ?></td>								
											<td class="fhr-table-price"><strong>&#163;<?php echo $room->price; ?></strong></td>
											<td class="fhr-table-button"><a href="<?php echo $affwin_link.$room->booking_deeplink; ?>" title="Book <?php echo $hotel->hotel_name; ?>" class="fhr-button">Book Now</a></td>
										</tr>
									<?php endforeach; ?>

									<?php foreach($non_matching_rooms as $room) : ?>
										<tr class="fhr-hide">
											<td class="fhr-table-desc"><?php echo $number_of_rooms.' x '.$room->room_type; ?> Room<br /><?php echo $room->room_desc; ?></td>								
											<td class="fhr-table-price"><strong>&#163;<?php echo $room->price; ?></strong></td>
											<td class="fhr-table-button"><a href="<?php echo $affwin_link.$room->booking_deeplink; ?>" title="Book <?php echo $hotel->hotel_name; ?>" class="fhr-button">Book Now</a></td>
										</tr>
									<?php endforeach; ?>

								<?php else : ?>
									<?php foreach($hotel->rooms as $room) : ?>
										<tr>
											<td class="fhr-table-desc"><?php echo $number_of_rooms.' x '.$room->room_type; ?> Room<br /><?php echo $room->room_desc; ?></td>								
											<td class="fhr-table-price"><strong>&#163;<?php echo $room->price; ?></strong></td>
											<td class="fhr-table-button"><a href="<?php echo $affwin_link.$room->booking_deeplink; ?>" title="Book <?php echo $hotel->hotel_name; ?>" class="fhr-button">Book Now</a></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</table>

							<?php if (!empty($non_matching_rooms)) : ?>
								<a href="#" class="show-fhr-hidden-rooms" data-hotel-id="hotel_<?php echo $hotel->hotel_id; ?>">Show other room types</a>
							<?php endif; ?>
							
						</div>
					<?php endforeach; ?>
				</div>
				<?php
			} else {
				echo '<div class="error">Sorry we were unable to complete your search please try again later.</div>';
			}
		}
		
		static function get($url, $data = false) {
			$session = curl_init($url);
		
			// Put the POST data in the body
			if($data){
				curl_setopt ($session, CURLOPT_POST, true);
				curl_setopt ($session, CURLOPT_POSTFIELDS, $data);
			}
			
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLINFO_HEADER_OUT, true);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($session, CURLOPT_TIMEOUT, 60); //set timeout in seconds
			if(isset($_SERVER['HTTP_USER_AGENT'])){
			  curl_setopt($session, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		  }
			curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
		
	 		// Make the call
			$response = curl_exec($session);
		
	  	$info = curl_getinfo($session);

			// Close the curl session
			curl_close($session);
			
			return $response;
		}
	}
?>