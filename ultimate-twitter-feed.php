<?php
/**
 * Plugin Name:       Ultimate Twitter Feed
 * Plugin URI:        ultimate-twitter-feed
 * Description:       The only plugin you are going to need to display any twitter feeds, You can display feeds with Unlimited Shortcodes and Widgets, Cache the feeds to speed your website, Finally the most important feature is you won't need to edit any code to dispaly the feeds in your already designed templates, NOW You can generate unlimited json urls and loop through them, Don't know what loop means ? No problem you will get a ready code to just paste in your template..
 * Version:           1.7.2
 * Author:            Omar Kasem
 * Author URI:        omark
 * Text Domain:       ultimate-twitter-feed
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ultimate-twitter-feed-activator.php
 */
function activate_ultimate_twitter_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-twitter-feed-activator.php';
	Ultimate_Twitter_Feed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ultimate-twitter-feed-deactivator.php
 */
function deactivate_ultimate_twitter_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-twitter-feed-deactivator.php';
	Ultimate_Twitter_Feed_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ultimate_twitter_feed' );
register_deactivation_hook( __FILE__, 'deactivate_ultimate_twitter_feed' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/lib/twitteroauth.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-twitter-feed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ultimate_twitter_feed() {

	$plugin = new Ultimate_Twitter_Feed();
	$plugin->run();

}
function utf_magic_function($shortcode){
	return json_decode(do_shortcode($shortcode));
}
run_ultimate_twitter_feed();
