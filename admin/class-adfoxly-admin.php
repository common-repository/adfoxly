<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://adfoxly.com/
 * @since      1.0.0
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/admin
 * @author     AdFoxly <hello@adfoxly.com>
 */
class AdfoxlyAdmin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->load_timber_views();
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
		 * defined in AdfoxlyLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AdfoxlyLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$server_request_uri = $_SERVER[ 'REQUEST_URI' ];
		if (
			strpos( $server_request_uri, 'adfoxly' ) !== false
		) {
			// Stisla Admin Template - MIT
			// General CSS Files
//			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-bootstrap', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-fontawesome', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css', array(), $this->version, 'all' );
			// Plugins
			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-select2', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/select2/dist/css/select2.min.css"', array(), $this->version, 'all' );
//			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-bootstrap-timepicker', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css"', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-bootstrap-datepicker', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/bootstrap-daterangepicker/daterangepicker.css"', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-timepicki', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/timepicki/css/timepicki.css"', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-bootstrap-tagsinput', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css"', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-codemirror', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/codemirror/lib/codemirror.css"', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-codemirror-theme', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/codemirror/theme/duotone-dark.css"', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-iziToast', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/izitoast/css/iziToast.min.css"', array(), $this->version, 'all' );
			// Template CSS
//			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-style', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/css/style.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-style', plugin_dir_url( dirname( __FILE__ ) ) . 'dist/css/style.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-stisla-components', plugin_dir_url( dirname( __FILE__ ) ) . 'dist/css/components.css', array(), $this->version, 'all' );
//			wp_enqueue_style( $this->plugin_name . '-adfoxly-jquery-steps', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/jquery-steps/demo/css/jquery.steps.css', array(), $this->version, 'all' );
//			wp_enqueue_style( $this->plugin_name . '-adfoxly-jquery-steps-main', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/jquery-steps/demo/css/main.css', array(), $this->version, 'all' );
			// AdFoxly Assets
			wp_enqueue_style( $this->plugin_name . '-adfoxly-wizard', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/wizard/dist/css/smart_wizard_theme_arrows.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-adfoxly-admin', plugin_dir_url( __FILE__ ) . 'css/adfoxly-admin.css', array(), $this->version, 'all' );
//			wp_enqueue_style( $this->plugin_name . '-adfoxly-style-1', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/core.css', array(), $this->version, 'all' );
//			wp_enqueue_style( $this->plugin_name . '-adfoxly-style-2', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/style.css', array(), $this->version, 'all' );
		}
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
		 * defined in AdfoxlyLoader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AdfoxlyLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_media();
		// Stisla Admin Template - MIT
		// General JS Scripts
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-popper', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/popper.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-moment', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/moment.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-select2', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/select2/dist/js/select2.full.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-bootstrap-timepicker', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-bootstrap-datepicker', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/bootstrap-daterangepicker/daterangepicker.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-timepicki', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/timepicki/js/timepicki.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-bootstrap-tagsinput', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-tooltip', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/tooltip.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-bootstrap', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-nicescroll', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-sweetalerts', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/sweetalert/sweetalert.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/js/stisla.js', '', $this->version, true );

		// Plugins
		// Code Editor
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-codemirror-1', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/codemirror/lib/codemirror.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-codemirror-2', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/codemirror/mode/javascript/javascript.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-sparkline', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/jquery.sparkline.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-chart', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/chart.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-iziToast', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/modules/izitoast/js/iziToast.js', '', $this->version, true );

		// Template JS File
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-scripts', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/js/scripts.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-stisla-custom', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/stisla/dist/assets/js/custom.js', '', $this->version, true );

		// AdFoxly Assets
//		wp_enqueue_script( $this->plugin_name . '-adfoxly-jquery-steps', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/jquery-steps/build/jquery.steps.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-smartwizard', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/wizard/dist/js/jquery.smartWizard.min.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-parsley', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendors/parsley/dist/parsley.min.js', '', $this->version, true );
		// todo: only when loaded settings or banner form
		wp_enqueue_script( $this->plugin_name . '-adblockDetector', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/adblockDetector.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adblockDetectorWithGA', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/adblockDetectorWithGA.js', '', $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-admin-common', plugin_dir_url( __FILE__ ) . 'js/adfoxly-admin-common.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . '-adfoxly-admin-wizard', plugin_dir_url( __FILE__ ) . 'js/adfoxly-admin-wizard.js', array( 'jquery' ), $this->version, true );
	}

	public function add_admin_adfoxly_body_classes() {
		return 'adfoxly-admin-page layout-2 sidebar-gone';
	}

	public function dashboard_enqueue_styles() {
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

		wp_enqueue_style( $this->plugin_name . '-adfoxly-dashboard', plugin_dir_url( __FILE__ ) . 'css/adfoxly-dashboard.css', array(), $this->version, 'all' );
	}

	public function adfoxly_analytics_inline_enqueue_script() {
		$this->settings = get_option( 'adfoxly_settings' );

		$server_request_uri = $_SERVER[ 'REQUEST_URI' ];
		if (
			strpos( $server_request_uri, 'adfoxly' ) !== false
		) {
			if ( ( defined( 'ADFOXLY_FRESHPAINT_OPTIN' ) && ADFOXLY_FRESHPAINT_OPTIN === true )
			     || ( isset( $this->settings[ 'adfoxly-privacy-freshpaint' ] ) && $this->settings[ 'adfoxly-privacy-freshpaint' ] === 'yes' )
			     || ( adfoxly_wa_fs()->is_registered() && adfoxly_wa_fs()->is_tracking_allowed() && ! isset( $this->settings[ 'adfoxly-privacy-freshpaint' ] ) )
			) {
				wp_enqueue_script( $this->plugin_name . '-adfoxly-freshpaint', plugin_dir_url( __FILE__ ) . 'js/adfoxly-admin-freshpaint.js' );
				wp_add_inline_script( $this->plugin_name . '-adfoxly-freshpaint', '(function(c,a){if(!a.__SV){var b=window;try{var d,m,j,k=b.location,f=k.hash;d=function(a,b){return(m=a.match(RegExp(b+"=([^&]*)")))?m[1]:null};f&&d(f,"fpState")&&(j=JSON.parse(decodeURIComponent(d(f,"fpState"))),"fpeditor"===j.action&&(b.sessionStorage.setItem("_fpcehash",f),history.replaceState(j.desiredHash||"",c.title,k.pathname+k.search)))}catch(n){}var l,h;window.freshpaint=a;a._i=[];a.init=function(b,d,g){function c(b,i){var a=i.split(".");2==a.length&&(b=b[a[0]],i=a[1]);b[i]=function(){b.push([i].concat(Array.prototype.slice.call(arguments, 0)))}}var e=a;"undefined"!==typeof g?e=a[g]=[]:g="freshpaint";e.people=e.people||[];e.toString=function(b){var a="freshpaint";"freshpaint"!==g&&(a+="."+g);b||(a+=" (stub)");return a};e.people.toString=function(){return e.toString(1)+".people (stub)"};l="disable time_event track track_pageview track_links track_forms track_with_groups add_group set_group remove_group register register_once alias unregister identify name_tag set_config reset opt_in_tracking opt_out_tracking has_opted_in_tracking has_opted_out_tracking clear_opt_in_out_tracking people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user people.remove people group page alias ready addEventProperties addInitialEventProperties removeEventProperty addPageviewProperties".split(" ");for(h=0;h<l.length;h++)c(e,l[h]);var f="set set_once union unset remove delete".split(" ");e.get_group=function(){function a(c){b[c]=function(){call2_args=arguments;call2=[c].concat(Array.prototype.slice.call(call2_args,0));e.push([d,call2])}}for(var b={},d=["get_group"].concat(Array.prototype.slice.call(arguments,0)),c=0;c<f.length;c++)a(f[c]);return b};a._i.push([b,d,g])};a.__SV=1.4;b=c.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof FRESHPAINT_CUSTOM_LIB_URL? FRESHPAINT_CUSTOM_LIB_URL:"//perfalytics.com/static/js/freshpaint.js";(d=c.getElementsByTagName("script")[0])?d.parentNode.insertBefore(b,d):c.head.appendChild(b)}})(document,window.freshpaint||[]);freshpaint.init("4341ee4d-74f8-41d6-8b04-8292413a9f52");freshpaint.page();' );
			}

			if (
				( defined( 'ADFOXLY_SMARTLOOK_OPTIN' ) && ADFOXLY_SMARTLOOK_OPTIN === true )
				|| ( isset( $this->settings[ 'adfoxly-privacy-smartlook' ] ) && $this->settings[ 'adfoxly-privacy-smartlook' ] === 'yes' )
				|| ( adfoxly_wa_fs()->is_registered() && adfoxly_wa_fs()->is_tracking_allowed() && ! isset( $this->settings[ 'adfoxly-privacy-smartlook' ] ) )
			) {
				wp_enqueue_script( $this->plugin_name . '-adfoxly-smartlook', plugin_dir_url( __FILE__ ) . 'js/adfoxly-admin-smartlook.js' );
				wp_add_inline_script( $this->plugin_name . '-adfoxly-smartlook', 'window.smartlook||(function(d) { var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName(\'head\')[0]; var c=d.createElement(\'script\');o.api=new Array();c.async=true;c.type=\'text/javascript\'; c.charset=\'utf-8\';c.src=\'https://rec.smartlook.com/recorder.js\';h.appendChild(c); })(document); smartlook(\'init\', \'686d389faa8e7e66ec50daf6b71b61c182bd24c4\');' );
			}
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
