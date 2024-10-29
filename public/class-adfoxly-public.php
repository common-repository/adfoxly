<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       https://adfoxly.com/
 * @since      1.0.0
 * @package    Adfoxly
 * @subpackage Adfoxly/public
 * @author     AdFoxly <hello@adfoxly.com>
 */
class AdfoxlyPublic {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The settings of this plugin.
	 *
	 * @since    1.2.4
	 * @access   private
	 * @var      string $settings The current settings from wp_options table.
	 */
	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->settings = get_option( 'adfoxly_settings' );

		new AdfoxlyPublicShortcodeController();
		$this->load_timber_views();
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AdfoxlyLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AdfoxlyLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

//		wp_enqueue_style( $this->plugin_name . '-adfoxly-jquery-confirm', plugin_dir_url( __FILE__ ) . 'vendor/jquery-confirm/jquery-confirm.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-adfoxly-public', plugin_dir_url( __FILE__ ) . 'css/adfoxly-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AdfoxlyLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AdfoxlyLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
//		wp_enqueue_script( $this->plugin_name . '-adfoxly-jquery-confirm', plugin_dir_url( __FILE__ ) . 'vendor/jquery-confirm/jquery-confirm.min.js', array( 'jquery' ), $this->version, false );

		if ( isset( $this->settings[ 'statistics-status' ] )
		     && isset( $this->settings[ 'statistics-type' ] )
		     && isset( $this->settings[ 'statistics-custom-gaid' ] )
		     && !empty( $this->settings[ 'statistics-custom-gaid' ] )
		     && $this->settings[ 'statistics-status' ] === 'enabled'
		     && in_array( 'google-analytics', $this->settings[ 'statistics-type' ] )
		) {
			wp_enqueue_script( $this->plugin_name . '-adfoxly-ga-inline', plugin_dir_url( __FILE__ ) . 'js/adfoxly-public-ga.js' );
			wp_add_inline_script( $this->plugin_name . '-adfoxly-ga-inline', "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create', '".$this->settings[ 'statistics-custom-gaid' ]."', 'auto');" );
		}

		wp_enqueue_script( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'js/adfoxly-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . "+ajax", plugin_dir_url( __FILE__ ) . 'js/adfoxly-public-ajax.js', array( 'jquery' ), $this->version, false );
	}

	public function enqueue_facebook_pixel() {
		if ( isset( $this->settings ) && isset( $this->settings[ 'adfoxly-facebook-pixel-code' ] ) && ! empty( $this->settings[ 'adfoxly-facebook-pixel-code' ] ) ) {
			echo "\n<!-- Facebook Pixel Code -->\n";
			echo $this->settings[ 'adfoxly-facebook-pixel-code' ];
			echo "\n<!-- End Facebook Pixel Code -->\n";
		}
	}

	public function load_timber_views() {
		$timber = new \Timber\Timber();
		Timber::$locations = array(
			realpath( dirname( __FILE__ ) ) . '/partials/views',
			realpath( dirname( __DIR__ ) ) . '/includes/view'
		);
	}
}
