<?php

/**
 * Fired during plugin deactivation
 *
 * @link       omark
 * @since      1.0.0
 *
 * @package    Ultimate_Twitter_Feed
 * @subpackage Ultimate_Twitter_Feed/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Ultimate_Twitter_Feed
 * @subpackage Ultimate_Twitter_Feed/includes
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Ultimate_Twitter_Feed_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option('utf_urls');
		delete_option('utf_shortcodes');
	}


}
