<?php


// For those who are object orientated. Add a class
// function as the menu callback and setup the
// menus automatically.

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AdfoxlyMenu {

	private static $instance;

	/**
	 * Main Instance
	 *
	 * @static var   array   $instance
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
			self::$instance->addAdminMenu();
		}

		return self::$instance;
	}

	public function adminMenu() {
		add_menu_page(
			'AdFoxly - Dashboard',
			'AdFoxly',
			'manage_options',
			'adfoxly',
			array(
				$this,
				'wpadsDashboardPage'
			),
			plugins_url( 'admin/img/icon.png', dirname( __FILE__ ) ),
			'80.321'
		);

		add_submenu_page(
			'adfoxly',
			__( 'New Ad - Wizard', 'adfoxly' ),
			__( 'New Ad - Wizard', 'adfoxly' ),
			'manage_options',
			'adfoxly-new',
			array(
				$this,
				'wpadsAdsNew'
			)
		);

		add_submenu_page(
			'adfoxly',
			__( 'Ads - What', 'adfoxly' ),
			__( 'Ads - What', 'adfoxly' ),
			'manage_options',
			'adfoxly-banners',
			array(
				$this,
				'wpadsBannersPage'
			)
		);

		add_submenu_page(
			'adfoxly',
			__( 'Places - Where', 'adfoxly' ),
			__( 'Places - Where', 'adfoxly' ),
			'manage_options',
			'adfoxly-places',
			array(
				$this,
				'wpadsPlacesPage'
			)
		);

		add_submenu_page(
			'adfoxly',
			__( 'Campaigns - When', 'adfoxly' ),
			__( 'Campaigns - When', 'adfoxly' ),
			'manage_options',
			'adfoxly-campaigns',
			array(
				$this,
				'wpadsCampaignsPage'
			)
		);

		add_submenu_page(
			'adfoxly',
			__( 'Analytics (beta)', 'adfoxly' ),
			__( 'Analytics (beta)', 'adfoxly' ),
			'manage_options',
			'adfoxly-analytics',
			array(
				$this,
				'wpadsStatisticsPage'
			)
		);

		add_submenu_page(
			'adfoxly',
			__( 'Settings', 'adfoxly' ),
			__( 'Settings', 'adfoxly' ),
			'manage_options',
			'adfoxly-settings',
			array(
				$this,
				'wpadsSettingsPage'
			)
		);
	}

	public function addAdminMenu() {
		add_action( 'admin_menu', array( $this, 'adminMenu' ) );
	}

	public function wpadsPlacesPage() {
		$places = new AdfoxlyPlacesController();
		$places->renderDashboardPlaces();
	}

	public function wpadsBannersPage() {
		require_once dirname( dirname( __FILE__ ) ) . '/includes/controller/class-adfoxly-new.php';
	}

	public function wpadsAdsNew() {
		require_once dirname( dirname( __FILE__ ) ) . '/includes/controller/class-adfoxly-new.php';
	}

	public function wpadsDashboardPage() {
		require_once dirname( dirname( __FILE__ ) ) . '/admin/partials/controllers/adfoxly-admin-display.php';
	}

	public function wpadsCampaignsPage() {
		$campaigns = new AdfoxlyCampaignController();
		$campaigns->renderDashboardCampaigns();
	}

	public function wpadsStatisticsPage() {
		require_once dirname( dirname( __FILE__ ) ) . '/admin/partials/controllers/adfoxly-admin-statistics.php';
	}

	public function wpadsSettingsPage() {
		require_once dirname( dirname( __FILE__ ) ) . '/admin/partials/controllers/adfoxly-admin-settings.php';
	}

}

// Call the class and add the menus automatically.
$adfoxlyMenu = AdfoxlyMenu::instance();

if ( ! function_exists( 'adfoxly_banners' ) ) {

// Register Custom Post Type
	function adfoxly_banners() {

		$labels = array(
			'name'                  => _x( 'Banners', 'Post Type General Name', 'adfoxly' ),
			'singular_name'         => _x( 'Banner', 'Post Type Singular Name', 'adfoxly' ),
			'menu_name'             => __( 'Ads Manager', 'adfoxly' ),
			'name_admin_bar'        => __( 'Ads Manager', 'adfoxly' ),
			'archives'              => __( 'Item Archives', 'adfoxly' ),
			'attributes'            => __( 'Item Attributes', 'adfoxly' ),
			'parent_item_colon'     => __( 'Parent Item:', 'adfoxly' ),
			'all_items'             => __( 'All Banners', 'adfoxly' ),
			'add_new_item'          => __( 'Add New Item', 'adfoxly' ),
			'add_new'               => __( 'Add Banner', 'adfoxly' ),
			'new_item'              => __( 'New Banner', 'adfoxly' ),
			'edit_item'             => __( 'Edit Banner', 'adfoxly' ),
			'update_item'           => __( 'Update Banner', 'adfoxly' ),
			'view_item'             => __( 'View Banner', 'adfoxly' ),
			'view_items'            => __( 'View Banner', 'adfoxly' ),
			'search_items'          => __( 'Search Banners', 'adfoxly' ),
			'not_found'             => __( 'Not found', 'adfoxly' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'adfoxly' ),
			'featured_image'        => __( 'Featured Image', 'adfoxly' ),
			'set_featured_image'    => __( 'Set featured image', 'adfoxly' ),
			'remove_featured_image' => __( 'Remove featured image', 'adfoxly' ),
			'use_featured_image'    => __( 'Use as featured image', 'adfoxly' ),
			'insert_into_item'      => __( 'Insert into item', 'adfoxly' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'adfoxly' ),
			'items_list'            => __( 'Items list', 'adfoxly' ),
			'items_list_navigation' => __( 'Items list navigation', 'adfoxly' ),
			'filter_items_list'     => __( 'Filter items list', 'adfoxly' ),
		);
		$args   = array(
			'label'               => __( 'Banner', 'adfoxly' ),
			'description'         => __( 'Post Type Description', 'adfoxly' ),
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'menu_position'       => 75,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
			'show_in_rest'        => false,
		);
		register_post_type( 'adfoxly_banners', $args );

	}

	add_action( 'init', 'adfoxly_banners', 0 );

}

$rr = new AdfoxlyPlacesModel();
$rr->registerPostType();
