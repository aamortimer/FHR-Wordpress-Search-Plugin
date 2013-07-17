<?php
/*
Plugin Name: FHR Search
Plugin URI: http://www.fhr-net.co.uk/
Description: Plugin to allow you to add FHR searches to your site. please visit <strong>settings</strong> when installed to add all your default options also you will be able to switch to the about tab which will list all shortcodes.
Author: Andy Mortimer
Version: 1
Author URI: http://www.fhr-net.co.uk/
*/

require_once('api.php');
require_once('shortcodes.php');
require_once('widget.php');
require_once('fhr_options.php');


/*
* FHR Activation code
*/
function fhrsearch_activate() {
	if (get_page_by_title('FHR Search Results') == false) {
		wp_insert_post(array(
	        'post_type' => 'page',
	        'post_title' => 'FHR Search Results',
	        'post_content' => '[fhr_results]',
	        'post_name' => 'search-results',
	        'post_status' => 'publish',
	        'comment_status' => 'closed',
	        'ping_status' => 'closed'
	    ));
	}
	
	$page = get_page_by_title('FHR Search Results');
	
	$setting_data = array(
		'agent'=>'FHR',
		'affwin'=>'',
		'results_type'=>'new',
		'results_form'=>'airport-parking',
		'results_airport'=>'gatwick',
		'results_parking_airport'=>'gatwick',
		'results_hotel_airport'=>'gatwick',
		'results_page'=>$page->ID
	);

	
	add_option("fhr_settings", $setting_data);
}


/*
* FHR Deactivation code
*/
function fhrsearch_deactivate() {
	$options = get_option('fhr_settings');

	if (get_page_by_title('FHR Search Results')) {
		if (isset($options['results_page'])) {
			wp_delete_post($options['results_page']);
		}
	}
	delete_option("fhr_settings");
}

/*
* FHR code to load custom JS and CSS
*/
function fhrsearch_deactivate_scripts() {
	if( !is_admin()){
		wp_deregister_script('jquery-ui-core');
		wp_register_script('jquery-ui-core', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js', array('jquery'));
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

		wp_enqueue_script('fhr.js', plugins_url('/assets/js/fhr.js', __FILE__));
		wp_enqueue_style('fhr.css', plugins_url('/assets/css/fhr.css', __FILE__));
	}
}

register_deactivation_hook( __FILE__, 'fhrsearch_deactivate' );
register_activation_hook(__FILE__, 'fhrsearch_activate');


// Add settings link on plugin page
function fhr_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=fhr-settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

// add settings link
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'fhr_settings_link' );

// add scripts and css
add_action('wp_enqueue_scripts', 'fhrsearch_deactivate_scripts');

// add shortcodes
add_shortcode('fhr_lorem_pixel', 'fhr_lorem_pixel_shortcode');
add_shortcode('fhr_lorem', 'fhr_lorem_shortcode');
add_shortcode('fhr_price_from', 'fhr_price_from_shortcode');
add_shortcode('fhr_search_form', 'fhr_search_form_shortcode');
add_shortcode('fhr_carpark_list', 'fhr_carpark_list_shortcode');
add_shortcode('fhr_results', 'fhr_results_shortcode');
add_shortcode('fhr_hotel_list', 'fhr_hotel_list_shortcode');

 

/*
add_action('init', 'fhr_activate_au');  
function fhr_activate_au() {  
  require_once ('lib/wp_autoupdate.php');  
  $wptuts_plugin_current_version = '1.0';  
  $wptuts_plugin_remote_path = 'http://www.fhr-net.co.uk/wp-update.php';  
  $wptuts_plugin_slug = plugin_basename(__FILE__);  
  new wp_auto_update ($wptuts_plugin_current_version, $wptuts_plugin_remote_path, $wptuts_plugin_slug);  
}  
*/
?>