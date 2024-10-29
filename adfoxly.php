<?php
/**
 === AdFoxly - Ad Manager, AdSense Ads & Ads.txt ===
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://adfoxly.com/
 * @since             1.0.0
 * @package           Adfoxly
 *
 * @wordpress-plugin
 * Plugin Name:     AdFoxly - Ad Manager, AdSense Ads & Ads.txt
 * Plugin URI:      https://adfoxly.com/
 * Description:     Easy, Easier, Easiest... AdFoxly! Manage Ads Fast and Easily. Make Your Blog or Website Profitable - in Just Few Clicks. Look, how ads management could be easy and intuitive.
 * Version:         1.8.5
 * Author:          AdFoxly
 * Author URI:      https://adfoxly.com/
 * License:         GPL-2.0+ License
 * URI:             http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     adfoxly
 * Domain Path:     /languages
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'adfoxly_wa_fs' ) ) {
	adfoxly_wa_fs()->set_basename( true, __FILE__ );
	return;
}

if ( ! function_exists( 'adfoxly_wa_fs' ) ) {
	// Create a helper function for easy SDK access.
	function adfoxly_wa_fs() {
		global $adfoxly_wa_fs;

		if ( ! isset( $adfoxly_wa_fs ) ) {
			// Include Freemius SDK.
			require_once dirname(__FILE__) . '/includes/freemius/start.php';

			$adfoxly_wa_fs = fs_dynamic_init( array(
				'id'                  => '2534',
				'slug'                => 'adfoxly',
				'type'                => 'plugin',
				'public_key'          => 'pk_495ebb5235d61f2d62335055dd443',
				'is_premium'          => false,
				'premium_suffix'      => 'PRO',
				// If your plugin is a serviceware, set this option to false.
				'has_premium_version' => true,
				'has_addons'          => false,
				'has_paid_plans'      => true,
				'trial'               => array(
					'days'               => 7,
					'is_require_payment' => false,
				),
				'menu'                => array(
					'slug'           => 'adfoxly',
					'support'        => false,
				),
				// Set the SDK to work in a sandbox mode (for development & testing).
				// IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
				'secret_key'          => 'sk_{]b_+e.;pII<2_p%grRr)-BrGQl@T',
			) );
		}

		return $adfoxly_wa_fs;
	}

	// Init Freemius.
	adfoxly_wa_fs();
	// Signal that SDK was initiated.
	do_action( 'adfoxly_wa_fs_loaded' );

	function adfoxly_wa_fs_add_custom_permission( $permissions ) {
        $permissions['sentry'] = array(
            'icon-class' => 'dashicons dashicons-chart-bar',
            'label'      => adfoxly_wa_fs()->get_text_inline( 'Sentry', 'adfoxly' ),
            'desc'       => adfoxly_wa_fs()->get_text_inline( 'Anonymous collection of data to improve plugin', 'adfoxly' ),
            'priority'   => 100,
            'tooltip'    => adfoxly_wa_fs()->get_text_inline( 'To help us troubleshoot any potential issues that may arise from other plugin or theme conflicts.', 'permissions-events_tooltip' ),
            'optional'   => true,
        );

        $permissions['bugsnag'] = array(
            'icon-class' => 'dashicons dashicons-chart-pie',
            'label'      => adfoxly_wa_fs()->get_text_inline( 'Bugsnag', 'adfoxly' ),
            'desc'       => adfoxly_wa_fs()->get_text_inline( 'Help me to develop better AdFoxly', 'adfoxly' ),
            'priority'   => 100,
            'tooltip'    => adfoxly_wa_fs()->get_text_inline( 'To help us troubleshoot any potential issues that may arise from other plugin or theme conflicts.', 'permissions-events_tooltip' ),
            'optional'   => true,
        );

        $permissions['freshpaint'] = array(
            'icon-class' => 'dashicons dashicons-chart-bar',
            'label'      => adfoxly_wa_fs()->get_text_inline( 'Plugin usage statistics', 'adfoxly' ),
            'desc'       => adfoxly_wa_fs()->get_text_inline( 'Anonymous collection of data to improve plugin', 'adfoxly' ),
            'priority'   => 100,
            'tooltip'    => adfoxly_wa_fs()->get_text_inline( 'To help us troubleshoot any potential issues that may arise from other plugin or theme conflicts.', 'permissions-events_tooltip' ),
            'optional'   => true,
        );

        $permissions['smartlook'] = array(
            'icon-class' => 'dashicons dashicons-chart-pie',
            'label'      => adfoxly_wa_fs()->get_text_inline( 'Smartlook', 'adfoxly' ),
            'desc'       => adfoxly_wa_fs()->get_text_inline( 'Help me to develop better AdFoxly', 'adfoxly' ),
            'priority'   => 100,
            'tooltip'    => adfoxly_wa_fs()->get_text_inline( 'To help us troubleshoot any potential issues that may arise from other plugin or theme conflicts.', 'permissions-events_tooltip' ),
            'optional'   => true,
        );

		return $permissions;
	}

	adfoxly_wa_fs()->add_filter( 'permission_list', 'adfoxly_wa_fs_add_custom_permission' );


	adfoxly_wa_fs()->override_i18n( array(
		'symbol_arrow-left' => '',
		'symbol_arrow-right' => '',
	) );

	define( 'ADFOXLY_VERSION', '1.8.5' );

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-adfoxly-activator.php
	 */

	if ( ! function_exists( 'activateAdfoxly' ) ) {
		function activateAdfoxly() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-adfoxly-activator.php';
			AdfoxlyActivator::activate();
		}
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-adfoxly-deactivator.php
	 */
	if ( ! function_exists( 'deactivateAdfoxly' ) ) {
		function deactivateAdfoxly() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-adfoxly-deactivator.php';
			AdfoxlyDeactivator::deactivate();
		}
	}
	register_activation_hook( __FILE__, 'activateAdfoxly' );
	register_deactivation_hook( __FILE__, 'deactivateAdfoxly' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-adfoxly.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function runAdfoxly() {

		$plugin = new Adfoxly();

        $settings = get_option( 'adfoxly_settings' );

        $server_request_uri = $_SERVER[ 'REQUEST_URI' ];
        if (
            strpos( $server_request_uri, 'adfoxly' ) !== false
        ) {
            if ( ( defined( 'ADFOXLY_SENTRY_OPTIN' ) && ADFOXLY_SENTRY_OPTIN === true )
                || ( isset( $settings[ 'adfoxly-privacy-sentry' ] ) && $settings[ 'adfoxly-privacy-sentry' ] === 'yes' )
                || ( adfoxly_wa_fs()->is_registered() && adfoxly_wa_fs()->is_tracking_allowed() && ! isset( $settings[ 'adfoxly-privacy-sentry' ] ) )
            ) {
                \Sentry\init(['dsn' => 'https://5a258ae135a14afe95cc683ae6d6d41c@o247548.ingest.sentry.io/5763292' ]);
            }

            if (
                ( defined( 'ADFOXLY_BUGSNAG_OPTIN' ) && ADFOXLY_BUGSNAG_OPTIN === true )
                || ( isset( $settings[ 'adfoxly-privacy-bugsnag' ] ) && $settings[ 'adfoxly-privacy-bugsnag' ] === 'yes' )
                || ( adfoxly_wa_fs()->is_registered() && adfoxly_wa_fs()->is_tracking_allowed() && ! isset( $settings[ 'adfoxly-privacy-bugsnag' ] ) )
            ) {
                $bugsnag = Bugsnag\Client::make('1b94f0609e8068d180fa59d2fc579808');
                Bugsnag\Handler::register($bugsnag);
            }
        }
		$plugin->run();

	}
	runAdfoxly();
}
