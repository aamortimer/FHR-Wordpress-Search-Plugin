<?php
// include the wp-settings-api-bootstrap file
require_once dirname( __FILE__ ) . '/lib/wp-settings-api-bootstrap/class.wp-settings-api-bootstrap.php';

/**
 * FHR Options panel
 *
 * @author Andy Mortimer
 */
if (!class_exists('FHROptions')) :
	class FHROptions {
	  /**
	   * @var WP_Settings_API_Bootstrap
	   */
	  private $wp_settings_api;

    /**
     * Constructor
     */
    function __construct() {
      $this->wp_settings_api = new WP_Settings_API_Bootstrap();

      add_action( 'admin_init', array( $this, 'admin_init') );
      add_action( 'admin_menu', array( $this, 'admin_menu') );
    }

    /**
     * Initialize the settings on admin_init hook
     */
    function admin_init() {
	    //set the settings
	    $this->wp_settings_api->set_sections( $this->get_settings_sections() );
	    $this->wp_settings_api->set_fields( $this->get_settings_fields() );
	
	    //initialize settings
	    $this->wp_settings_api->admin_init();
    }

    /**
     * Add the menu on admin_menu hook
     */
    function admin_menu() {
      add_options_page( 'FHR Settings', 'FHR Settings', 'delete_posts', 'fhr-settings', array($this, 'plugin_page') );
    }

    /**
     * Set up all of the Main settings sections
     *
     * @return array
     */
    function get_settings_sections() {
        $sections = array(
					array(
						'id' => 'fhr_settings',
						'title' => __( 'Basic Settings', 'fhrsearch' )
					),
					array(
						'id' => 'fhr_about',
						'title' => __( 'About', 'fhrsearch' )
					)
				);
				return $sections;
		}

      /**
       * Returns all the settings fields
       *
       * @return array settings fields
       */
      function get_settings_fields() {
				// a little cleaner to create a variable and add html rather than in the array
					$about = '<h2>FHR Settings</h2>
										<p>Please add either your FHR ID or your Affiliate Window ID these settings are used in all functions.</p>
										<h2>Shortcodes</h2>
										<p>
											<strong>[fhr_search_form]</strong><br />
											The above will show the default search form and use all default settings
										</p>
										<p>
											<strong>[fhr_search_form form=\'airport-parking\' agent=\'fhr\' affwin=\'1111\' airport=\'gatwick\']</strong><br />
											The above is a demo off the parameters you can pass in.
										</p>
										<p>
											<strong>[fhr_search_form] Parameter values</strong><br />
											All parameters are optional defaults will be selected from the settings panel, except for form which defaults to parking<br /><br />
											<strong>form</strong> airport-parking, airport-parking-and-hotels, airport-hotels or airport-lounge<br />
											<strong>agent</strong> your FHR agent ID<br />
											<strong>affwin</strong> your Affiliate Window ID<br />
											<strong>airport</strong> the default airport to select<br />
										</p>
										<hr />
										<p>
											<strong>[fhr_carpark_list]</strong><br />
											The above will out put a html list for the default airport set in settings.
										</p>
										<p>
											<strong>[fhr_carpark_list agent=\'fhr\' affwin=\'1111\' airport=\'gatwick\']</strong><br />
											The above is a demo off the parameters you can pass in.
										</p>
										<p>
											<strong>[fhr_carpark_list] Parameter values</strong><br />
											All parameters are optional defaults will be selected from the settings panel, except for form which defaults to parking<br /><br />
											<strong>agent</strong> your FHR agent ID<br />
											<strong>affwin</strong> your Affiliate Window ID<br />
											<strong>airport</strong> the default airport to select<br />
										</p>
										<hr />
										<p>
											<strong>[fhr_hotel_list]</strong><br />
											The above will out put a html list for the default airport set in settings.
										</p>
										<p>
											<strong>[fhr_hotel_list agent=\'fhr\' affwin=\'1111\' airport=\'gatwick\']</strong><br />
											The above is a demo off the parameters you can pass in.
										</p>
										<p>
											<strong>[fhr_hotel_list] Parameter values</strong><br />
											All parameters are optional defaults will be selected from the settings panel, except for form which defaults to parking<br /><br />
											<strong>agent</strong> your FHR agent ID<br />
											<strong>affwin</strong> your Affiliate Window ID<br />
											<strong>airport</strong> the default airport to select<br />
										</p>
										<hr />
										<p>
											<strong>[fhr_price_from]</strong><br />
											The above will out put a div with the current from price based on the selected airport
										</p>
										<p>
											<strong>[fhr_price_from agent=\'fhr\' affwin=\'1111\' airport=\'gatwick\']</strong><br />
											The above is a demo off the parameters you can pass in.
										</p>
										<p>
											<strong>[fhr_price_from] Parameter values</strong><br />
											All parameters are optional defaults will be selected from the settings panel, except for form which defaults to parking<br /><br />
											<strong>agent</strong> your FHR agent ID<br />
											<strong>affwin</strong> your Affiliate Window ID<br />
											<strong>airport</strong> the default airport to select<br />
										</p>
										<hr />
										<p>
											<strong>[fhr_lorem]</strong><br />
											The above will output some lorem text
										</p>
										<p>
											<strong>[fhr_lorem number=\'5\' type=\'text\']</strong><br />
											The above is a demo off the parameters you can pass in.
										</p>
										<p>
											<strong>[fhr_lorem] Parameter values</strong><br />
											All parameters are optional<br /><br />
											<strong>type</strong> default is text, options are text or list<br />
											<strong>number</strong> the number of paragraphs or list items to show<br />
										</p>	
										<hr />
										<p>
											<strong>[fhr_lorem_pixel]</strong><br />
											The above will output a lorem image
										</p>
										<p>
											<strong>[fhr_lorem_pixel width=\'400\' height=\'400\' type=\'business\']</strong><br />
											The above is a demo off the parameters you can pass in.
										</p>
										<p>
											<strong>[fhr_lorem_pixel] Parameter values</strong><br />
											All parameters are optional<br /><br />
											<strong>type</strong> default is business, options are abstract, city, people, transport, animals, food, nature, nightlife, sports, cats, fashion or technics<br />
											<strong>width</strong> the width of the image default is 200<br />
											<strong>height</strong> the height of the image default is 200<br />
										</p>									
										';

          $settings_fields = array(
              'fhr_settings' => array(
								array(
									'name'      => 'agent',
									'label'     => __( 'FHR Agent ID', 'fhrsearch' ),
									'desc'      => '',
									'type'      => 'text',
									'default'   => 'FHR'
								),
								array(
									'name'      => 'affwin',
									'label'     => __( 'Affiliate Window ID', 'fhrsearch' ),
									'desc'      => '',
									'type'      => 'text',
									'default'   => ''
								),
								array(
									'name'      => 'results_airport',
									'label'     => __( 'Default Airport', 'fhrsearch' ),
									'desc'      => '',
									'type'      => 'text',
									'default'   => ''
								),
								array(
									'name'      => 'results_type',
									'label'     => '',
									'desc'      => '',
									'type'      => 'hidden',
									'default'   => ''
								),
								array(
									'name'      => 'results_form',
									'label'     => '',
									'desc'      => '',
									'type'      => 'hidden',
									'default'   => ''
								),
								array(
									'name'      => 'results_hotel_airport',
									'label'     => '',
									'desc'      => '',
									'type'      => 'hidden',
									'default'   => ''
								),
								array(
									'name'      => 'results_parking_airport',
									'label'     => '',
									'desc'      => '',
									'type'      => 'hidden',
									'default'   => ''
								),
              ),
              'fhr_about' => array(
								array(
									'name'      => 'about',
									'label'     => __( 'About', 'fhrsearch' ),
									'desc'      => __( $about, 'fhrsearch' ),
									'type'      => 'about'
								)
              )
				);

				return $settings_fields;
      }

      /**
       * Display the admin page
       */
      function plugin_page() {
				echo '<div class="wrap">';
				echo '<div id="icon-options-general" class="icon32"></div>';
				echo '<h2>FHR Settings</h2>';

				settings_errors();

				$this->wp_settings_api->show_navigation();
				$this->wp_settings_api->show_forms();

				echo '</div>';
      }

      /**
       * Get all the pages
       *
       * @return array page names with key value pairs
       */
      function get_pages() {
				$pages = get_pages();
				$pages_options = array();
				if ( $pages ) {
					foreach ($pages as $page) {
						$pages_options[$page->ID] = $page->post_title;
					}
				}

				return $pages_options;
			}
    }
endif; // if class_exists

// initiate the class
$settings = new FHROptions();