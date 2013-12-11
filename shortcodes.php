<?php
	/*
	* FHR results shortcode
	*/
	function fhr_results_shortcode($atts) {
		$params = array();
		foreach($_GET as $name => $value) {
			$params[] = $name.'='.$value;
		}
		
		$params = implode('&', $params);
		
		$options = get_option('fhr_settings');
		$results_type = isset($options['results_type']) ? $options['results_type'] : 'new';
		$results_form = isset($options['results_form']) ? $options['results_form'] : 'airport-parking';
		
		if ($results_type == 'iframe')  {
			if ($results_form == 'airport-parking') {
				$html = '<iframe src="http://www.fhr-net.co.uk/airport-parking/results/?'.$params.'" frameborder="0" scrolling="auto" width="100%" height="2000"></iframe>';	
			} elseif ($results_form == 'airport-lounge') {
				$html = '<iframe src="http://www.fhr-net.co.uk/airport-lounges/results/?'.$params.'" frameborder="0" scrolling="auto" width="100%" height="2000"></iframe>';	
			} else {
				$html = '<iframe src="http://www.fhr-net.co.uk/airport-hotels/results/?'.$params.'" frameborder="0" scrolling="auto" width="100%" height="2000"></iframe>';	
			}
		} else {
			if ($results_form == 'airport-parking') {
				$html = fhr::parking_search();
			} elseif ($results_form == 'airport-lounge') {
				$html = fhr::lounge_search();			
			} else {
				$html = fhr::hotel_search();
			}
		}
		
		return $html;
	}
	
	
	/*
	* FHR shortcode to return list of carparks
	*/
	function fhr_carpark_list_shortcode($atts) {
		$options = get_option('fhr_settings');
		$results_airport = isset($options['results_airport']) ? $options['results_airport'] : 'gatwick';
		$agent = isset($options['agent']) ? $options['agent'] : 'fhr';
		$affwin = isset($options['affwin']) ? $options['affwin'] : '';
		
		extract(shortcode_atts(array(
			'airport' => $results_airport,
			'agent' => $agent,
			'affwin' => $affwin
		), $atts));
		
		$url = 'http://www.fhr-net.co.uk/api/carparks.php?agentid='.$agent.'&airport='.$airport;
		 
		$rsp = '';
		if($data = json_decode(fhr::get($url, $data = false))) {
			$rsp = '<ul id="fhr_carpark_list">'."\n";
			
			foreach($data as $d) {
				if ($affwin) {
					$rsp .= '<li><a rel="nofollow" href="http://www.awin1.com/cread.php?awinmid=3000&awinaffid='.$affwin.'&p='.urlencode($d->link).'&OverrideAgent='.$agent.'" title="'.$d->carpark.' Airport Parking">'.$d->carpark.'</a></li>'."\n";	
				} else {
					$rsp .= '<li><a rel="nofollow" href="'.$d->link.'" title="'.$d->carpark.' Airport Parking">'.$d->carpark.'</a></li>'."\n";	
				}
			}
						
			$rsp .= '<ul>'."\n";
		}
 
		return $rsp;
	}
	
	
	/*
	* FHR shortcode to return list of hotels
	*/
	function fhr_hotel_list_shortcode($atts) {
		$options = get_option('fhr_settings');
		$results_airport = isset($options['results_airport']) ? $options['results_airport'] : 'gatwick';
		$agent = isset($options['agent']) ? $options['agent'] : 'fhr';
		$affwin = isset($options['affwin']) ? $options['affwin'] : '';
		
		extract(shortcode_atts(array(
			'airport' => $results_airport,
			'agent' => $agent,
			'affwin' => $affwin
		), $atts));
	
		$url = 'http://www.fhr-net.co.uk/api/hotels.php?agentid='.$agent.'&airport='.$airport;
		 
		$rsp = '';
		if($data = json_decode(fhr::get($url, $data = false))) {
			$rsp = '<ul id="fhr_carpark_list">'."\n";
			
			foreach($data as $d) {
				if ($affwin) {
					$rsp .= '<li><a rel="nofollow" href="http://www.awin1.com/cread.php?awinmid=3000&awinaffid='.$affwin.'&p='.urlencode($d->link).'&OverrideAgent='.$agent.'" title="'.$d->hotel.' Airport Hotels">'.$d->hotel.'</a></li>'."\n";	
				} else {
					$rsp .= '<li><a rel="nofollow" href="'.$d->link.'" title="'.$d->hotel.' Airport Hotels">'.$d->hotel.'</a></li>'."\n";	
				}
			}
						
			$rsp .= '</ul>'."\n";
		}
 
		return $rsp;
	}
	
	
	/*
	* FHR shortcode to return price from
	*/
	function fhr_price_from_shortcode($atts) {
		$options = get_option('fhr_settings');
		$results_airport = isset($options['results_airport']) ? $options['results_airport'] : 'gatwick';
		$agent = isset($options['agent']) ? $options['agent'] : 'fhr';
		$affwin = isset($options['affwin']) ? $options['affwin'] : '';
		
		extract(shortcode_atts(array(
			'airport' => $results_airport,
			'agent' => $agent,
			'type' => 'parking',
			'affwin' => $affwin
		), $atts));
	
		$url = 'http://www.fhr-net.co.uk/api/prices.php?agentid='.$agent.'&airport='.$airport.'&type='.$type;
		 
		$rsp = '';
		if($data = json_decode(fhr::get($url, $data = false))) {
			$rsp = '<span class="fhr_price_from">'."\n";
			
			foreach($data as $d) {
				if ($affwin) {
					$rsp .= '<a class="fhr_title" href="http://www.awin1.com/cread.php?awinmid=3000&awinaffid='.$affwin.'&p='.urlencode($d->link).'&OverrideAgent='.$agent.'" title="'.$d->airport.' Airport '.ucwords($type).'">'.$d->airport.' Airport '.ucwords($type).'</a>'."\n";	
				} else {
					$rsp .= '<a class="fhr_title" href="'.$d->link.'" title="'.$d->airport.' Airport '.ucwords($type).'">'.$d->airport.' Airport '.ucwords($type).'</a>'."\n";	
				}
				$rsp .= 'from <strong class="fhr_price">&#163;'.$d->price.'</strong>'."\n";
			}
						
			$rsp .= '</span>'."\n";
		}
 
		return $rsp;
	}
	
	/*
	* FHR search form
	*/
	function fhr_search_form_shortcode($atts) {
		$options = get_option('fhr_settings');
		$results_form = isset($options['results_form']) ? $options['results_form'] : 'airport-parking';
		$results_airport = isset($options['results_airport']) ? $options['results_airport'] : 'gatwick';
		$agent = isset($options['agent']) ? $options['agent'] : 'fhr';
		$affwin = isset($options['affwin']) ? $options['affwin'] : '';
		$results_type = isset($options['results_type']) ? $options['results_type'] : 'new';
		$results_page = isset($options['results_page']) ? $options['results_page'] : '';
		
		extract(shortcode_atts(array(
			'form' => $results_form,
			'agent' => $agent,
			'affwin' => $affwin,
			'airport' => $results_airport 
		), $atts));
		
		switch($form) {
			case 'airport-parking': 
				$search_form = $results_type == 'new' ? 'http://www.fhr-net.co.uk/airport-parking/results/' : get_permalink($results_page) ;
				$airports = fhr::airports('parking');
				require_once('forms/parking_search_form.php');
				return parking_search_form($search_form, $airports, $rooms, $form, $agent, $affwin, $airport);
				break;
			case 'airport-parking-and-hotels': 
				$search_form = $results_type == 'new' ? 'http://www.fhr-net.co.uk/airport-hotels/results/' : get_permalink($results_page) ;
				$airports = fhr::airports('hotels');
				$rooms = fhr::room_types();
				require_once('forms/hotel_search_form.php');
				return hotel_search_form($search_form, $airports, $rooms, $form, $agent, $affwin, $airport);
				break;
			case 'airport-hotels':
				$search_form = $results_type == 'new' ? 'http://www.fhr-net.co.uk/airport-hotels/results/' : get_permalink($results_page);
				$airports = fhr::airports('hotels');
				$rooms = fhr::room_types();
				require_once('forms/hotel_search_form.php');
				return hotel_search_form($search_form, $airports, $rooms, $form, $agent, $affwin, $airport);
				break;
			case 'airport-lounge':
				$search_form = $results_type == 'new' ? 'http://www.fhr-net.co.uk/airport-lounges/results/' : get_permalink($results_page);
				$sel_lounge_location = isset($_GET['lounge_location']) ? $_GET['lounge_location'] : 'ukLounges';
				
				if ($sel_lounge_location == 'ukLounges') {
					$airports = fhr::airports('lounges');
				} else {
					$airports = fhr::airports('international');
				}
				require_once('forms/lounge_search_form.php');
				return lounge_search_form($search_form, $airports, $form, $agent, $affwin, $airport);
				break;
		}
	}
	
	function fhr_lorem_shortcode($atts) {
		extract(shortcode_atts(array(
			'type' => 'text',
			'number' => 2,
		), $atts));
		
		$rsp = '';
		if ($type == 'text') {
			for($i=1;$i<=$number;$i++) {
				$rsp .= '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
			}			
		}
		
		if ($type == 'list') {
			$rsp = '<ul>';
				for($i=1;$i<=$number;$i++) {
				$rsp .= '<li>Item '.($i).'</li>';
			}	
			$rsp .= '</ul>';
		}
		
		return $rsp;
	}
	
	function fhr_lorem_pixel_shortcode($atts) {
		extract(shortcode_atts(array(
			'type' => 'business',
			'width' => 200,
			'height' => 200
		), $atts));
		
		return '<img src="http://lorempixel.com/'.$width.'/'.$height.'/'.$type.'" title="Lorem Image" alt="Lorem Image" />';
	}
?>