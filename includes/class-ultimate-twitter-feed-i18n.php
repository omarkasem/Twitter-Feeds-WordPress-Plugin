<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       omark
 * @since      1.0.0
 *
 * @package    Ultimate_Twitter_Feed
 * @subpackage Ultimate_Twitter_Feed/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ultimate_Twitter_Feed
 * @subpackage Ultimate_Twitter_Feed/includes
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Ultimate_Twitter_Feed_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ultimate-twitter-feed',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
