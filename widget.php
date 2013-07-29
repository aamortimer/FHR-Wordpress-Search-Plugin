<?php
	add_action( 'widgets_init', 'fhr_search_widget' );

	function fhr_search_widget() {
		register_widget('FHRSearchWidget');
		register_widget('FHRCarParkList');
		register_widget('FHRHotelList');
	}

	/*
	* FHR search form widget
	*/	
	class FHRSearchWidget extends WP_Widget {
		function FHRSearchWidget() {
			$widget_ops = array(
				'classname' => 'fhrsearch', 
				'description' => __('This widget allows you to enter your Agent id and select the search form to display', 'fhrsearch')
			);
			
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'fhrsearch-widget' );
			
			$this->WP_Widget( 'fhrsearch-widget', __('FHR Search', 'fhrsearch'), $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
			extract( $args );
	
			//Our variables from the widget settings.
			$form 	= isset($instance['form']) ? $instance['form'] : 'airport-parking';
			
			echo do_shortcode('[fhr_search_form form="'.$form.'"]');
						
			echo $after_widget;
		}
	
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
	
			//Strip tags from title and name to remove HTML 
			$instance['results_type'] = strip_tags($new_instance['results_type']);
			$instance['form'] = $new_instance['form'];
	
			// set options
			$options = get_option('fhr_settings');
			$options['results_type'] = $instance['results_type'];
			$options['results_form'] = $instance['form'];
			
			update_option("fhr_settings", $options);
			
			return $instance;
		}
	
		
		function form($instance) {
			$options = get_option('fhr_settings');
			$results_form = isset($options['results_form']) ? $options['results_form'] : 'airport-parking';
			$results_type = isset($options['results_type']) ? $options['results_type'] : 'new';
		
			//Set up some default widget settings.
			$defaults = array(
				'form' => 'airport-parking',
				'results_type' => 'new',
			);
			
			$instance = wp_parse_args((array)$instance, $defaults); ?>
			<p>
				<label for="<?php echo $this->get_field_id('results_type'); ?>"><?php _e('Results Type:', 'fhrsearch'); ?></label>
				<select id="<?php echo $this->get_field_id('results_type'); ?>" name="<?php echo $this->get_field_name('results_type'); ?>" style="width:100%;">
					<option value="new" <?php echo ($results_type == 'new') ? 'selected="selected"' : ''; ?>>New Window</option>
					<option value="iframe" <?php echo ($results_type == 'iframe') ? 'selected="selected"' : ''; ?>>iFrame</option>
					<option value="xml" <?php echo ($results_type == 'xml') ? 'selected="selected"' : ''; ?>>XML</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('form'); ?>"><?php _e('Search Form', 'fhrsearch'); ?></label>
				<select id="<?php echo $this->get_field_id('form'); ?>" name="<?php echo $this->get_field_name('form'); ?>" style="width:100%;">
					<option value="airport-parking" <?php echo ($results_form == 'airport-parking') ? 'selected="selected"' : ''; ?>>Airport Parking</option>
					<option value="airport-parking-and-hotels" <?php echo ($results_form == 'airport-parking-and-hotels') ? 'selected="selected"' : ''; ?>>Airport Hotels and Parking</option>
					<option value="airport-hotels" <?php echo ($results_form == 'airport-hotels') ? 'selected="selected"' : ''; ?>>Airport Hotels</option>
					<option value="airport-lounge" <?php echo ($results_form == 'airport-lounge') ? 'selected="selected"' : ''; ?>>Airport Lounges</option>
				</select>
			</p>
		<?php
		}
	}
	
	
	/*
	* Car park list widget
	*/
	class FHRCarParkList extends WP_Widget {
		function FHRCarParkList() {
			$widget_ops = array(
				'classname' => 'fhrcarparklist', 
				'description' => __('This widget allows you to display a list of FHR carparks', 'fhrsearch')
			);
			
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'fhrcarparklist-widget' );
			
			$this->WP_Widget( 'fhrcarparklist-widget', __('FHR Car Park List', 'fhrsearch'), $widget_ops, $control_ops );
		}
		
	  function widget($args, $instance ) {
	  	$options = get_option('fhr_settings');
			$results_parking_airport = isset($options['results_parking_airport']) ? $options['results_parking_airport'] : 'gatwick';
			$agent = isset($options['agent']) ? $options['agent'] : 'fhr';
			$affwin = isset($options['affwin']) ? $options['affwin'] : '';
		
			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $args['before_widget'];
			if (!empty( $title )) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
		  echo do_shortcode('[fhr_carpark_list airport="'.$results_parking_airport.'" agent="'.$agent.'" affwin="'.$affwin.'"]');
		  echo $args['after_widget'];
	  }
	  
	  function update($new_instance, $old_instance) {
		  $instance = $old_instance;
	
			//Strip tags from title and name to remove HTML 
			$instance['airport'] = $new_instance['airport'];
			$instance['title'] = $new_instance['title'];
	
			// set options
			$options = get_option('fhr_settings');
			$options['results_parking_airport'] = $instance['airport'];
			
			update_option("fhr_settings", $options);
			
			return $instance;
	  }
	  
	  function form($instance) {
	  	$options = get_option('fhr_settings');
			$results_parking_airport = isset($options['results_parking_airport']) ? $options['results_parking_airport'] : 'gatwick';
			
		  //Set up some default widget settings.
			$defaults = array(
				'airport' => 'Gatwick',
				'title' => 'Airport Car Parks'
			);
			
			$airports = json_decode(fhr::get('http://www.fhr-net.co.uk/api/airports.php?type=all', $data = false));

			$instance = wp_parse_args((array)$instance, $defaults); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'fhrsearch'); ?></label>
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title'] ?>" style="width:100%;" />
			</p>
	
			<p>
				<label for="<?php echo $this->get_field_id('airport'); ?>"><?php _e('Airport:', 'fhrsearch'); ?></label>
				<select id="<?php echo $this->get_field_id('airport'); ?>" name="<?php echo $this->get_field_name('airport'); ?>" style="width:100%;">
					<?php foreach($airports as $a) : ?>
						<?php if ( ($results_parking_airport == strtolower($a->airport)) || ($results_parking_airport == '' && ($results_parking_airport == strtolower($a->airport))) ) : ?>
							<option value="<?php echo strtolower($a->airport); ?>" selected="selected"><?php echo $a->airport; ?></option>
						<?php else: ?>
							<option value="<?php echo strtolower($a->airport); ?>"><?php echo $a->airport; ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</p>
			<?php
	  }
	}
	
	
	/*
	* Hotel list widget
	*/
	class FHRHotelList extends WP_Widget {
		function FHRHotelList() {
			$widget_ops = array(
				'classname' => 'fhrhotellist', 
				'description' => __('This widget allows you to display a list of FHR hotels', 'fhrsearch')
			);
			
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'fhrhotellist-widget' );
			
			$this->WP_Widget( 'fhrhotellist-widget', __('FHR Hotel List', 'fhrsearch'), $widget_ops, $control_ops );
		}
		
	  function widget($args, $instance ) {
	  	$options = get_option('fhr_settings');
			$results_hotel_airport = isset($options['results_hotel_airport']) ? $options['results_hotel_airport'] : 'gatwick';
			$agent = isset($options['agent']) ? $options['agent'] : 'fhr';
			$affwin = isset($options['affwin']) ? $options['affwin'] : '';

			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $args['before_widget'];
			if (!empty( $title )) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
		  echo do_shortcode('[fhr_hotel_list airport="'.$results_hotel_airport.'" agent="'.$agent.'" affwin="'.$affwin.'"]');
		  echo $args['after_widget'];
	  }
	  
	  function update($new_instance, $old_instance) {
		  $instance = $old_instance;
	
			//Strip tags from title and name to remove HTML 
			$instance['airport'] = $new_instance['airport'];
			$instance['title'] = $new_instance['title'];
			
			// set options
			$options = get_option('fhr_settings');
			$options['results_hotel_airport'] = $instance['airport'];
			
			update_option("fhr_settings", $options);
			
			return $instance;
	  }
	  
	  function form($instance) {
	  	$options = get_option('fhr_settings');
			$results_hotel_airport = isset($options['results_hotel_airport']) ? $options['results_hotel_airport'] : 'gatwick';
			
		  //Set up some default widget settings.
			$defaults = array(
				'airport' => 'Gatwick',
				'title' => 'Airport Hotels'
			);
			
			$airports = json_decode(fhr::get('http://www.fhr-net.co.uk/api/airports.php?type=all', $data = false));

			$instance = wp_parse_args((array)$instance, $defaults); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'fhrsearch'); ?></label>
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title'] ?>" style="width:100%;" />
			</p>
	
			<p>
				<label for="<?php echo $this->get_field_id('airport'); ?>"><?php _e('Airport:', 'fhrsearch'); ?></label>
				<select id="<?php echo $this->get_field_id('airport'); ?>" name="<?php echo $this->get_field_name('airport'); ?>" style="width:100%;">
					<?php foreach($airports as $a) : ?>
						<?php if ( ($results_hotel_airport == strtolower($a->airport)) || ($results_hotel_airport == '' && ($results_hotel_airport == strtolower($a->airport))) ) : ?>
							<option value="<?php echo strtolower($a->airport); ?>" selected="selected"><?php echo $a->airport; ?></option>
						<?php else: ?>
							<option value="<?php echo strtolower($a->airport); ?>"><?php echo $a->airport; ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</p>
			<?php
	  }
	}
?>