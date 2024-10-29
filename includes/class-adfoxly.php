<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://adfoxly.com/
 * @since      1.0.0
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/includes
 */

use geertw\IpAnonymizer\IpAnonymizer;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Adfoxly
 * @subpackage Adfoxly/includes
 * @author     AdFoxly <hello@adfoxly.com>
 */
class Adfoxly {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      AdfoxlyLoader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;


	/**
	 * @var string
	 */
	protected $custom_url;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->version     = ADFOXLY_VERSION;
		$this->plugin_name = 'adfoxly';
		$this->custom_url  = 'rdir-adfoxly';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		global $wp;

		/**
		 * redirecting init
		 */
		add_action( 'init', array( &$this, 'register_tags' ) );
		add_action( 'wp_head', array( &$this, 'adfoxly_flush_rules' ) );
		add_action( 'template_redirect', array( &$this, 'redirect' ) );
		add_filter( 'the_content', array( &$this, 'adfoxly_content' ) );
		add_action( 'wp_footer', array( &$this, 'adfoxly_sticky_ad' ) );
		add_action( 'wp_footer', array( &$this, 'adfoxly_footer_script' ) );
		add_action( 'wp_footer', array( &$this, 'adfoxly_popup_ad' ) );
		add_filter( 'admin_notices', array( &$this, 'adfoxly_admin_notice__success' ) );
        add_action( 'wp_head', array( &$this, 'adfoxly_ajaxurl' ) );
		add_action( 'admin_head', array( &$this, 'adfoxly_ajaxurl' ) );
		add_action( 'admin_print_scripts', array( &$this, 'adfoxly_ajaxurl' ) );
		add_action( 'the_content_more_link', array( &$this, 'adfoxly_the_post' ) );
		add_filter( 'wp_sitemaps_post_types', array( &$this, 'remove_adfoxly_from_wp_sitemap' ) );


		add_action( 'widgets_init', function() {
			return register_widget( "AdfoxlyWidget" );
		} );
//		add_filter( 'excerpt_more', array( &$this, 'adfoxly_the_post' ) );
	}

	/**
	 * @param $content
	 *
	 * @return bool
	 */
	static function remove_checks( $content ) {

		return false;
	}

	/**
	 *
	 */
	static function adfoxly_ajaxurl() {

		echo '<script type="text/javascript">
           var adfoxlyAjax = {"ajax_url":"\/wp-admin\/admin-ajax.php"};
         </script>';
	}

	/**
	 *
	 */
	static function adfoxly_admin_notice__success() {
		/**
		 * todo: developer docs
		 * notice debugger
		 *
		 * @param ?notice=show
		 */
		if ( isset( $_GET[ 'notice' ] ) && $_GET[ 'notice' ] === 'show' ) {
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php _e( 'Done!', 'adfoxly' ); ?></p>
			</div>
			<?php
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - AdfoxlyLoader. Orchestrates the hooks of the plugin.
	 * - adfoxly_i18n. Defines internationalization functionality.
	 * - adfoxly_Admin. Defines all hooks for the admin area.
	 * - adfoxly_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-adfoxly-ajax.php';
		$this->loader = new AdfoxlyLoader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the adfoxly_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$pluginI18n = new AdfoxlyI18n();

		$this->loader->add_action( 'plugins_loaded', $pluginI18n, 'load_plugin_adfoxly' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin       = new AdfoxlyAdmin( $this->get_plugin_name(), $this->get_version() );
		$server_request_uri = $_SERVER[ 'REQUEST_URI' ];

		if ( strpos( $server_request_uri, 'adfoxly' ) !== false && strpos( $server_request_uri, 'adfoxly-account' ) !== 25 ) {
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 0 );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts', 1 );
			$this->loader->add_action( 'admin_body_class', $plugin_admin, 'add_admin_adfoxly_body_classes', 0 );
		}
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'dashboard_enqueue_styles', 0 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'adfoxly_analytics_inline_enqueue_script', 0 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new AdfoxlyPublic( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_facebook_pixel' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    AdfoxlyLoader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 *
	 */
	public function register_tags() {
		$settings = get_option( 'adfoxly_settings' );
		if ( isset( $settings[ 'redirect-slug' ] ) && ! empty( $settings[ 'redirect-slug' ] ) ) {
			$this->custom_url = $settings[ 'redirect-slug' ];
		}

		$custom_url = $this->custom_url;
		add_rewrite_rule( $custom_url . '/([^/]*)', 'index.php?' . $custom_url . '=$matches[1]', 'top' );
		add_rewrite_tag( '%' . $custom_url . '%', '([^&]+)' );
	}

	/**
	 *
	 */
	public function adfoxly_flush_rules() {
		global $wp_rewrite;
		if ( $wp_rewrite->rules && ! array_key_exists( $this->custom_url . '/([^/]*)', $wp_rewrite->rules ) ) {
			$wp_rewrite->flush_rules();
		}
	}

	/**
	 *
	 */
	public function redirect() {
		global $wp_query;
		if ( isset( $wp_query->query_vars[ $this->custom_url ] ) ) {
			$id = $wp_query->query_vars[ $this->custom_url ];
			$this->parse_redirect( $id );
		}
	}

	/**
	 * @param $id
	 */
	public function parse_redirect( $id ) {
		$result = get_post_meta( $id, 'adfoxly-target-url', true );
		if ( $result && is_numeric( $id ) ) {
			global $wpdb;
			$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_clicks';


			$wpdb->insert( $dbStatisitcs, array(
				'id'          => null,
				'banner_id'   => $id,
				'date'        => date( "Y-m-d H:i:s" ),
				'fingerprint' => $this->getFingerPrint(),
			) );
			/*
			 * add here google analytics condition
			 * if ga than send to ga and use js redirect
			 * if else try wp_redirect
			 */
			if ( 1 !== 1 ) {
				// js code here
			} else {
				wp_redirect( $result );
			}

		} else {
			wp_redirect( get_home_url() );
		}
		exit;
	}

	/**
	 * @return string
	 */
	public function getFingerPrint() {
		$ip      = Adfoxly::ip();
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ! empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$browser = $_SERVER['HTTP_USER_AGENT'];
		} else {
			$browser = "unknown";
		}
		if ( isset( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) && ! empty( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ) {
			$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		} else {
			$language = "unknown";
		}

		$fingerprint = "$ip + $browser + $language";
		return md5( $fingerprint );
	}

	/**
	 * @return string
	 */
	static function ip() {
		if ( isset( $_SERVER[ 'HTTP_CLIENT_IP' ] ) && isset( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) ) {
			$client  = @$_SERVER[ 'HTTP_CLIENT_IP' ];
			$forward = @$_SERVER[ 'HTTP_X_FORWARDED_FOR' ];

			if ( filter_var( $client, FILTER_VALIDATE_IP ) ) {
				$ip = $client;
			} else if ( filter_var( $forward, FILTER_VALIDATE_IP ) ) {
				$ip = $forward;
			}
		} else if ( isset( $_SERVER['REMOTE_ADDR'] ) && ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$remote  = $_SERVER[ 'REMOTE_ADDR' ];
			$ip = $remote;
		} else {
			$ip = "0.0.0.0";
		}
		if ( 1 === 2 ) {
			return $ip;
		}

		$ipAnonymizer = new IpAnonymizer();
		return $ipAnonymizer->anonymize( $ip );
	}

    function remove_adfoxly_from_wp_sitemap( $post_types ) {
	    unset( $post_types['adfoxly_places'] );
	    unset( $post_types['adfoxly_banners'] );
	    unset( $post_types['adfoxly_ad_campaign'] );
	    return $post_types;
    }


	function adfoxly_footer_script() {

		$getFooterPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'post_and_pages'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getFooterPlaceID = get_posts( $getFooterPlaceIDArgs );

		if ( isset( $getFooterPlaceID ) && ! empty( $getFooterPlaceID ) ) {
			$places = new AdfoxlyPlacesController();
			echo $places->renderPlace( $getFooterPlaceID[0]->ID );
		}
	}

	/**
	 *
	 */
	function adfoxly_sticky_ad() {

		$settings = get_option( 'adfoxly_settings' );
		if ( is_404() === true && ( isset($settings['adfoxly-error-404']) && $settings['adfoxly-error-404'] === 'true' ) )  {
			exit();
		}

		$getStickyTopPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'sticky_top'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getStickyTopPlaceID = get_posts( $getStickyTopPlaceIDArgs );
		if ( isset( $getStickyTopPlaceID ) && ! empty( $getStickyTopPlaceID ) ) {
			$places = new AdfoxlyPlacesController();
			echo $places->renderPlace( $getStickyTopPlaceID[0]->ID );
		}


		$getStickyBottomPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'sticky_bottom'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getStickyBottomPlaceID = get_posts( $getStickyBottomPlaceIDArgs );
		if ( isset( $getStickyBottomPlaceID ) && ! empty( $getStickyBottomPlaceID ) ) {
			$places = new AdfoxlyPlacesController();
			echo $places->renderPlace( $getStickyBottomPlaceID[0]->ID );
		}

		$getStickyLeftPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'sticky_left'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getStickyLeftPlaceID = get_posts( $getStickyLeftPlaceIDArgs );
		if ( isset( $getStickyLeftPlaceID ) && ! empty( $getStickyLeftPlaceID ) ) {
			$places = new AdfoxlyPlacesController();
			echo $places->renderPlace( $getStickyLeftPlaceID[0]->ID );
		}

		$getStickyRightPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'sticky_right'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getStickyRightPlaceID = get_posts( $getStickyRightPlaceIDArgs );
		if ( isset( $getStickyRightPlaceID ) && ! empty( $getStickyRightPlaceID ) ) {
			$places = new AdfoxlyPlacesController();
			echo $places->renderPlace( $getStickyRightPlaceID[0]->ID );
		}

	}


	/**
	 *
	 */
	function adfoxly_popup_ad() {

		$getPopupPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'popup'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getPopupPlaceID = get_posts( $getPopupPlaceIDArgs );

		if ( isset( $getPopupPlaceID ) && ! empty( $getPopupPlaceID ) ) {
			$places = new AdfoxlyPlacesController();
			echo $places->renderPlace( $getPopupPlaceID[0]->ID );
		}

	}

	/**
	 * @param $content
	 *
	 * @return mixed|null|string
	 */
	static function adfoxly_content( $content ) {
		$textAdsList = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_type_of_ad',
					'value' => 'text'
				)
			),
			'post_type'      => 'adfoxly_banners',
			'posts_per_page' => - 1
		);

		if ( isset( $textAdsList ) && ! empty( $textAdsList ) ) {
			$textAds = get_posts( $textAdsList );
		}

		if ( is_single() ) {
			return self::singlePost( $content, $textAds );
		} else {
			return $content;
		}
	}

	static function adfoxly_the_post( $post_object ) {
		if ( ! is_single() ) {
			$places         = new AdfoxlyPlacesController();
			$getBetweenPostsPlaceIDArgs = array(
				'meta_query'     => array(
					array(
						'key'   => 'adfoxly_place_unique_id',
						'value' => 'homepage_posts'
					)
				),
				'post_type'      => 'adfoxly_places',
				'posts_per_page' => -1
			);

			$getBetweenPostsPlaceID = get_posts( $getBetweenPostsPlaceIDArgs );

			$this_post = $post_object;
			if (
					isset( $getBetweenPostsPlaceID )
					&& ! empty( $getBetweenPostsPlaceID )
					&& isset( $getBetweenPostsPlaceID[ 0 ] )
					&& ! empty( $getBetweenPostsPlaceID[ 0 ] )
					&& isset( $getBetweenPostsPlaceID[ 0 ]->ID )
					&& ! empty( $getBetweenPostsPlaceID[ 0 ]->ID )
			) {
				$this_post .= $places->renderPlace( $getBetweenPostsPlaceID[ 0 ]->ID );
			}

			return $this_post;
		}
	}

	static function addAdsBeforePost( $content ) {
		$placesModel = new AdfoxlyPlacesModel();

		$new_content = null;

		$getBeforeContentPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'before_post'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getBeforeContentPlaceID = get_posts($getBeforeContentPlaceIDArgs);

		if (
			isset( $getBeforeContentPlaceID )
			&& ! empty( $getBeforeContentPlaceID )
			&& isset( $getBeforeContentPlaceID[ 0 ] )
			&& ! empty( $getBeforeContentPlaceID[ 0 ] )
			&& ! empty( $placesModel->getBannersByPlace( $getBeforeContentPlaceID[ 0 ]->ID ) )
		):
			$places      = new AdfoxlyPlacesController();
			$new_content = $places->renderPlace( $getBeforeContentPlaceID[0]->ID );
			$new_content .= $content;
		else:
			$new_content = $content;
		endif;

		return $new_content;
	}
	static function addAdsAfterPost( $content ) {
		$getAfterContentPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'after_post'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getAfterContentPlaceID = get_posts($getAfterContentPlaceIDArgs);
		$placesModel = new AdfoxlyPlacesModel();

		$new_content = null;

		if ( isset( $getAfterContentPlaceID[ 0 ]->ID ) && ! empty( $placesModel->getBannersByPlace( $getAfterContentPlaceID[ 0 ]->ID ) ) ):
			$places      = new AdfoxlyPlacesController();
			$new_content .= $places->renderPlace( $getAfterContentPlaceID[0]->ID );
		else:
			$new_content .= '';
		endif;

		return $new_content;
	}

	static function singlePost( $content ) {
		$placesModel = new AdfoxlyPlacesModel();

		$getBeforeContentPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'before_post'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getBeforeContentPlaceID = get_posts($getBeforeContentPlaceIDArgs);

		$getInsideContentPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'inside_post_middle'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getInsideContentPlaceID = get_posts($getInsideContentPlaceIDArgs);

		$getAllInsideContentXParagraphPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_x_paragraph',
					'value' => 1
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getAllInsideContentXParagraphPlaceID = get_posts($getAllInsideContentXParagraphPlaceIDArgs);

		$ip = 0;
		foreach ( $getAllInsideContentXParagraphPlaceID as $getAllInsideContentXParagraphPlaceIDkey => $getAllInsideContentXParagraphPlaceIDvalue ) {

			$getInsideContentXParagraphPlaceXNumber = get_post_meta($getAllInsideContentXParagraphPlaceIDvalue->ID);

			$getAllInsideContentXParagraphPlaceIDArgs_123 = array(
				'meta_query'     => array(
					array(
						'key'   => 'adfoxly_place_x_number',
						'value' => $getInsideContentXParagraphPlaceXNumber[ 'adfoxly_place_x_number' ][ 0 ]
					)
				),
				'post_type'      => 'adfoxly_places',
				'posts_per_page' => -1
			);

			$getAllInsideContentXParagraphPlaceID_123[$ip]['data'] = get_posts($getAllInsideContentXParagraphPlaceIDArgs_123);
			$getAllInsideContentXParagraphPlaceID_123[$ip]['p'] = $getInsideContentXParagraphPlaceXNumber[ 'adfoxly_place_x_number' ][ 0 ];
			$ip++;
		}

		$getAfterContentPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'after_post'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getAfterContentPlaceID = get_posts($getAfterContentPlaceIDArgs);
		if (
			( isset( $getBeforeContentPlaceID[ 0 ]->ID ) && ! empty( $placesModel->getBannersByPlace( $getBeforeContentPlaceID[0]->ID ) ) )
			|| ( isset( $getInsideContentPlaceID[ 0 ]->ID ) && ! empty( $placesModel->getBannersByPlace( $getInsideContentPlaceID[0]->ID ) ) )
			|| ( isset( $getAllInsideContentXParagraphPlaceID_123[ 0 ] ) && ! empty( $getAllInsideContentXParagraphPlaceID_123[ 0 ] ) )
			|| ( isset( $getAfterContentPlaceID[ 0 ]->ID ) && ! empty( $placesModel->getBannersByPlace( $getAfterContentPlaceID[0]->ID ) ) )
		):
			$custom_content = null;
			$new_content    = $content;
			$new_content = self::addAdsBeforePost( $new_content );
			$new_content .= self::addAdsAfterPost( $new_content );
			$new_content = self::addAdsInsideMiddlePost( $new_content );
			$new_content = self::addAdsInsideXParagraphPost( $new_content );

			return $new_content;
		else:
			return $content;
		endif;


	}

	static function addAdsInsideMiddlePost( $content ) {
		$places      = new AdfoxlyPlacesController();
		$placesModel = new AdfoxlyPlacesModel();
		$custom_content = null;
		$new_content = null;

		$getInsideContentPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'inside_post_middle'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getInsideContentPlaceID = get_posts($getInsideContentPlaceIDArgs);

		if ( isset( $getInsideContentPlaceID[0]->ID ) && ! empty( $placesModel->getBannersByPlace( $getInsideContentPlaceID[0]->ID ) ) ):

			$paragraphs      = explode( '</p>', $content );
			$paragraph_count = count( $paragraphs );

			$paragraph_parts = ceil( ( $paragraph_count - 1 ) / 2 );

			foreach ( $paragraphs as $index => $paragraph ):

				if ( trim( $paragraph ) ) {
					$paragraphs[ $index ] .= '</p>';
				}

				$custom_content .= $paragraphs[ $index ];

				if ( ( $index + 1 ) == $paragraph_parts ):
					$places         = new AdfoxlyPlacesController();
					$custom_content .= $places->renderPlace( $getInsideContentPlaceID[0]->ID );
				endif;

			endforeach;

			return $custom_content;
			exit();
			$new_content = $custom_content;
			$middle = true;
		else:
			$new_content .= $content;
			$middle = false;
		endif;

		return $new_content;
	}

	static function addAdsInsideXParagraphPost( $content ) {
		$custom_content = null;
		$new_content = null;

		$getAllInsideContentXParagraphPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_x_paragraph',
					'value' => 1
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getAllInsideContentXParagraphPlaceID = get_posts($getAllInsideContentXParagraphPlaceIDArgs);
		$ip = 0;
		foreach ( $getAllInsideContentXParagraphPlaceID as $getAllInsideContentXParagraphPlaceIDkey => $getAllInsideContentXParagraphPlaceIDvalue ) {

			$getInsideContentXParagraphPlaceXNumber = get_post_meta($getAllInsideContentXParagraphPlaceIDvalue->ID);
			$getAllInsideContentXParagraphPlaceIDArgs_123 = array(
				'meta_query'     => array(
					array(
						'key'   => 'adfoxly_place_x_number',
						'value' => $getInsideContentXParagraphPlaceXNumber[ 'adfoxly_place_x_number' ][ 0 ]
					)
				),
				"order"          => "ASC",
				'post_type'      => 'adfoxly_places',
				'posts_per_page' => -1
			);

			$getAllInsideContentXParagraphPlaceID_123[$getInsideContentXParagraphPlaceXNumber[ 'adfoxly_place_x_number' ][ 0 ]]['data'] = get_posts($getAllInsideContentXParagraphPlaceIDArgs_123);
			$getAllInsideContentXParagraphPlaceID_123[$getInsideContentXParagraphPlaceXNumber[ 'adfoxly_place_x_number' ][ 0 ]]['p'] = $getInsideContentXParagraphPlaceXNumber[ 'adfoxly_place_x_number' ][ 0 ];

			$ip++;
		}

		$new_content = $content;

		if ( isset( $getAllInsideContentXParagraphPlaceID_123 ) && ! empty( $getAllInsideContentXParagraphPlaceID_123 ) ) {
			foreach ($getAllInsideContentXParagraphPlaceID_123 as $getAllInsideContentXParagraphPlaceID_123_Value) {
				$new_content = self::addAdsInsideXParagraphPostLooper($new_content, $getAllInsideContentXParagraphPlaceID_123_Value);
			}
		}

		return $new_content;

	}

	static function addAdsInsideXParagraphPostLooper( $content, $getAllInsideContentXParagraphPlaceID_123_Value ) {
		$placesModel = new AdfoxlyPlacesModel();

		if ( isset( $getAllInsideContentXParagraphPlaceID_123_Value['data'][0]->ID )
		     && ! empty( $placesModel->getBannersByPlace( $getAllInsideContentXParagraphPlaceID_123_Value['data'][0]->ID ) )
		):

			$paragraphs      = explode( '</p>', $content );
			$paragraph_count = count( $paragraphs );
			$custom_content = null;
			$custom_content = null;

			$paragraph_parts = $getAllInsideContentXParagraphPlaceID_123_Value[ 'p' ];

			foreach ( $paragraphs as $index => $paragraph ):

				if ( trim( $paragraph ) ) {
					$paragraphs[ $index ] .= '</p>';
				}

				$custom_content .= $paragraphs[ $index ];

				if ( ( $index + 1 ) == $paragraph_parts ):
					$places         = new AdfoxlyPlacesController();
					$custom_content .= $places->renderPlace( $getAllInsideContentXParagraphPlaceID_123_Value['data'][0]->ID );
				endif;

			endforeach;

			return $custom_content;
		else:
			return $content;
		endif;
	}

	static function addAdsInsidePost( $content ) {
	}

	static function singlePostOld( $content, $textAds ) {

		$places      = new AdfoxlyPlacesController();
		$placesModel = new AdfoxlyPlacesModel();

		$getBeforeContentPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'before_post'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getBeforeContentPlaceID = get_posts($getBeforeContentPlaceIDArgs);

		$getInsideContentPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'inside_post_middle'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getInsideContentPlaceID = get_posts($getInsideContentPlaceIDArgs);

		$getAllInsideContentXParagraphPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_x_paragraph',
					'value' => 1
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getAllInsideContentXParagraphPlaceID = get_posts($getAllInsideContentXParagraphPlaceIDArgs);

		$ip = 0;
		foreach ( $getAllInsideContentXParagraphPlaceID as $getAllInsideContentXParagraphPlaceIDkey => $getAllInsideContentXParagraphPlaceIDvalue ) {

			$getInsideContentXParagraphPlaceXNumber = get_post_meta($getAllInsideContentXParagraphPlaceIDvalue->ID);

			$getAllInsideContentXParagraphPlaceIDArgs_123 = array(
				'meta_query'     => array(
					array(
						'key'   => 'adfoxly_place_x_number',
						'value' => $getInsideContentXParagraphPlaceXNumber[ 'adfoxly_place_x_number' ][ 0 ]
					)
				),
				'post_type'      => 'adfoxly_places',
				'posts_per_page' => -1
			);

			$getAllInsideContentXParagraphPlaceID_123[$ip]['data'] = get_posts($getAllInsideContentXParagraphPlaceIDArgs_123);
			$getAllInsideContentXParagraphPlaceID_123[$ip]['p'] = $getInsideContentXParagraphPlaceXNumber[ 'adfoxly_place_x_number' ][ 0 ];

			$ip++;
		}

		$getAfterContentPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => 'after_post'
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1
		);

		$getAfterContentPlaceID = get_posts($getAfterContentPlaceIDArgs);

		// why here is that statement?
		if ( isset( $getBeforeContentPlaceID[ 0 ]->ID )
		     && ! empty( $placesModel->getBannersByPlace( $getBeforeContentPlaceID[0]->ID ) )
		):
			$custom_content = null;
			$new_content    = null;

			if ( ! empty( $placesModel->getBannersByPlace( $getBeforeContentPlaceID[0]->ID ) ) ):
				$places      = new AdfoxlyPlacesController();
				$new_content .= $places->renderPlace( $getBeforeContentPlaceID[0]->ID );
			endif;

			if ( isset( $getInsideContentPlaceID[0]->ID ) && ! empty( $placesModel->getBannersByPlace( $getInsideContentPlaceID[0]->ID ) ) ):

				$paragraphs      = explode( '</p>', $content );
				$paragraph_count = count( $paragraphs );

				$paragraph_parts = ceil( ( $paragraph_count - 1 ) / 2 );

				foreach ( $paragraphs as $index => $paragraph ):

					if ( trim( $paragraph ) ) {
						$paragraphs[ $index ] .= '</p>';
					}

					$custom_content .= $paragraphs[ $index ];

					if ( ( $index + 1 ) == $paragraph_parts ):
						$places         = new AdfoxlyPlacesController();
						$custom_content .= $places->renderPlace( $getInsideContentPlaceID[0]->ID );
					endif;

				endforeach;

				$new_content .= $custom_content;
				$middle = true;
			else:
				$new_content .= $content;
				$middle = false;
			endif;

			if ( isset( $getAllInsideContentXParagraphPlaceID_123 ) && ! empty( $getAllInsideContentXParagraphPlaceID_123 ) ) {
				foreach ($getAllInsideContentXParagraphPlaceID_123 as $getAllInsideContentXParagraphPlaceID_123_Value) {

					if ( isset( $getAllInsideContentXParagraphPlaceID_123_Value['data'][0]->ID ) && ! empty( $placesModel->getBannersByPlace( $getAllInsideContentXParagraphPlaceID_123_Value['data'][0]->ID ) ) ):

						$paragraphs      = explode( '</p>', $new_content );
						$paragraph_count = count( $paragraphs );

						$paragraph_parts = $getAllInsideContentXParagraphPlaceID_123_Value[ 'p' ];

						foreach ( $paragraphs as $index => $paragraph ):

							if ( trim( $paragraph ) ) {
								$paragraphs[ $index ] .= '</p>';
							}

							$custom_content .= $paragraphs[ $index ];

							if ( ( $index + 1 ) == $paragraph_parts ):
								$places         = new AdfoxlyPlacesController();
								$custom_content .= $places->renderPlace( $getAllInsideContentXParagraphPlaceID_123_Value['data'][0]->ID );
							endif;

						endforeach;


						if ( isset( $middle ) && $middle === true ) {
							echo('2');
							$new_content = $custom_content;
						} else {
							echo('3');
							$new_content = $custom_content;
						}

					else:
						echo('4');
						$new_content .= $new_content;
					endif;

				}
			}

			foreach ( $textAds as $ads ) {
				$metaTextAds = get_post_meta( $ads->ID );

				if ( ! empty( $metaTextAds[ 'adfoxly-text-to-link' ][ 0 ] ) ) {
					if ( ! empty( $metaTextAds[ 'adfoxly-image' ] ) ) {
						$new_content = str_replace( $metaTextAds[ 'adfoxly-text-to-link' ][ 0 ], "<a href='" . get_home_url() . '/' . Adfoxly::adfoxlyCustomUrl() . "/" . $ads->ID . "' target='_blank' class='tooltip-ad' style='border-bottom: 1px dotted black;'>" . $metaTextAds[ 'adfoxly-text-to-link' ][ 0 ] . "<span><img src='" . $metaTextAds[ 'adfoxly-image' ][ 0 ] . "' /></span></a>", $new_content );
					} else {
						$new_content = str_replace( $metaTextAds[ 'adfoxly-text-to-link' ][ 0 ], "<a href='" . get_home_url() . '/' . Adfoxly::adfoxlyCustomUrl() . "/" . $ads->ID . "' target='_blank'>" . $metaTextAds[ 'adfoxly-text-to-link' ][ 0 ] . "</a>", $new_content );
					}
				}

			}

			if ( isset( $getAfterContentPlaceID[0]->ID ) && ! empty( $placesModel->getBannersByPlace( $getAfterContentPlaceID[0]->ID ) ) ):
				$places      = new AdfoxlyPlacesController();
				$new_content .= $places->renderPlace( $getAfterContentPlaceID[0]->ID );
			endif;

			return $new_content;
		else:
			return $content;
		endif;

	}
	/**
	 * @return string
	 */
	static function adfoxlyCustomUrl() {

		$customUrl  = 'rdir-adfoxly';
		$settings = get_option( 'adfoxly_settings' );
		if ( isset( $settings[ 'redirect-slug' ] ) && ! empty( $settings[ 'redirect-slug' ] ) ) {
			$customUrl = $settings[ 'redirect-slug' ];
		}


		return $customUrl;
	}
}
