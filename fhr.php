<?php
/*
Plugin Name: FHR Search
Plugin URI: http://www.fhr-net.co.uk/
Description: Plugin to allow you to add FHR searches to your site. please visit <strong>settings</strong> when installed to add all your default options also you will be able to switch to the about tab which will list all shortcodes.
Author: Andy Mortimer
Version: 1.3
Author URI: http://www.fhr-net.co.uk/
*/

require_once('api.php');
require_once('shortcodes.php');
require_once('widget.php');
require_once('fhr_options.php');
require_once('lib/WordPress-GitHub-Plugin-Updater/updater.php');


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



if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
  $config = array(
      'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
      'proper_folder_name' => 'fhr', // this is the name of the folder your plugin lives in
      'api_url' => 'https://api.github.com/repos/aamortimer/FHR-Wordpress-Search-Plugin', // the github API url of your github repo
      'raw_url' => 'https://raw.github.com/aamortimer/FHR-Wordpress-Search-Plugin/master', // the github raw url of your github repo
      'github_url' => 'https://github.com/aamortimer/FHR-Wordpress-Search-Plugin', // the github url of your github repo
      'zip_url' => 'https://github.com/aamortimer/FHR-Wordpress-Search-Plugin/zipball/master', // the zip url of the github repo
      'sslverify' => true, // wether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
      'requires' => '3.0', // which version of WordPress does your plugin require?
      'tested' => '3.5.2', // which version of WordPress is your plugin tested up to?
      'readme' => 'README.md', // which file to use as the readme for the version number
      'access_token' => '', // Access private repositories by authorizing under Appearance > Github Updates when this example plugin is installed
  );
  new WP_GitHub_Updater($config);
}
?>