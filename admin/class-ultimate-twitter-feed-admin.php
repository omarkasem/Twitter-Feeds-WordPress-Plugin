<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       omark
 * @since      1.0.0
 *
 * @package    Ultimate_Twitter_Feed
 * @subpackage Ultimate_Twitter_Feed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ultimate_Twitter_Feed
 * @subpackage Ultimate_Twitter_Feed/admin
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Ultimate_Twitter_Feed_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Twitter_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Twitter_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_style( $this->plugin_name.'datepicker', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-twitter-feed-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Twitter_Feed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Twitter_Feed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ultimate-twitter-feed-admin.js', array( 'jquery','jquery-ui-datepicker' ), $this->version, false );
	    wp_localize_script( $this->plugin_name, 'utf_ajax_object',
	        array( 
	            'site_url' => get_site_url(),
	        )
	    );

	}

	// Making an option page in the settings page.
	public function utf_option_page(){
		add_options_page('Ultimate Tiwtter Feed','Ultimate Tiwtter Feed','manage_options',$this->plugin_name.'.php',array($this, 'utf_display_funcion'));
	}

	// Making tabs in the option page.
	private function utf_tabs(){
		return array(
			'keys-and-tokens'=>'Keys and Tokens',
			'shortcodes'=>'Shortcodes',
			'developers'=>'Developers',
			'cache' => 'Cache',
			'extra-options'=> 'Extra Options',
		);
	}

	// The display function that's required by the add_options_page function, it displays the HTML in the page.
	public function utf_display_funcion(){ ?>
		<div class="wrap">
		
			<div id="icon-themes" class="icon32"></div>
			<h2><?php _e( 'Ultimate Twitter Feed', $this->plugin_name ); ?></h2>
			
			<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'keys-and-tokens'; ?>
			
			<h2 class="nav-tab-wrapper">
				<?php foreach($this->utf_tabs() as $key => $value){ ?>
					<a href="?page=<?php echo $this->plugin_name ?>.php&tab=<?php echo $key ?>" class="nav-tab <?php echo $active_tab == $key ? 'nav-tab-active' : ''; ?>"><?php echo _e($value,$this->plugin_name); ?></a>
				<?php } ?>
			</h2>

			<?php foreach($this->utf_tabs() as $key => $value){
				if($active_tab == $key){
					include_once('partials/utf-'.$key.'-display.php');
				}
			} ?>
			
		</div><!-- /.wrap -->
	<?php }

	// Register the plugin settings
	public function utf_register_settings(){
		// Keys and tokens
		register_setting( 'utf_options_group', 'utf_consumer_key'); 
		register_setting( 'utf_options_group', 'utf_consumer_secret' ); 
		register_setting( 'utf_options_group', 'utf_access_token'  ); 
		register_setting( 'utf_options_group', 'utf_access_token_secret');
	}



	// The ajax function that's called on clicking the generate shortcodes button, it generates the shortcodes obviously.
	public function utf_save_shortcodes(){
		$shortcode = sanitize_text_field($_POST['shortcode']);
		$shortcodes = get_option('utf_shortcodes');
		if($shortcodes != "" && is_array($shortcodes)){
			$shortcodes[] = $shortcode;
			update_option('utf_shortcodes',$shortcodes);
		}else{
			add_option('utf_shortcodes',array($shortcode));
		}
		$shortcodes = get_option('utf_shortcodes');
		$shortcodes = array_reverse($shortcodes);
		$output .= "<ul>";
		foreach($shortcodes as $shortcode){
			$shortcode = str_replace('\\','',$shortcode);
			$output .= "<li><input type='text' disabled value='".esc_attr($shortcode)."'/></li>";
		}
		$output .= "<ul>";
		echo $output;
		wp_die();
	}

	// The ajax function that's called on clicking the generate urls button, it generates the urls obviously.
	public function utf_save_urls(){
		$url = esc_url($_POST['url']);
		$urls = get_option('utf_urls');
		if($urls != "" && is_array($urls)){
			$urls[] = $url;
			update_option('utf_urls',$urls);
		}else{
			add_option('utf_urls',array($url));
		}
		$urls = get_option('utf_urls');
		$urls = array_reverse($urls);
		$output .= "<ul>";
		foreach($urls as $url){
			$url = str_replace('\\','',$url);
			$output .= "<li><input type='text' disabled value='".esc_attr($url)."'/></li>";
		}
		$output .= "<ul>";
		echo $output;
		wp_die();
	}



	public function utf_load_widget() {
		register_widget( 'Ultimate_Twitter_Feed_Public' );
	}

}
