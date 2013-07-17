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
		
		static function parking_search($airport, $arrival_date, $arrival_time, $return_date, $return_time) {
			$options = get_option('fhr_settings');
			
			$terminal = '';
			$terminal_id = '';
			$error_response = '';
			if(strstr($airport, '-')){
			  $a = explode('-',$airport);
			  $airport = $a[0];
			  $terminal = '<terminal>'.$a[1].'</terminal>';
			  $terminal_id = $a[1];
			}
			
			$agent = isset($options['agent']) ? $options['agent'] : 'fhr';
						
		  $data = '<?xml version="1.0" encoding="UTF-8"?>
							<request type="parkingandhotelquote" user="'.$agent.'" pass="" ip="" test="false">	
								<airport_id>'.$airport.'</airport_id>
								'.$terminal.'
								<arrival_date>'.$arrival_date.'</arrival_date>
								<dep_time>'.$arrival_time.'</dep_time>
								<rtn_date>'.$return_date.'</rtn_date>
								<rtn_time>'.$return_time.'</rtn_time>
								<show_discount>True</show_discount>
								<show_sales_messages>True</show_sales_messages>
							</request>';
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