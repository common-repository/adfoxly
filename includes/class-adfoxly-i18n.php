<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://adfoxly.com/
 * @since      1.0.0
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Adfoxly
 * @subpackage Adfoxly/includes
 * @author     AdFoxly <hello@adfoxly.com>
 */
class AdfoxlyI18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_adfoxly() {
		load_plugin_textdomain(
			'adfoxly',
			false,
			basename( dirname ( dirname( __FILE__ ) ) ) . '/languages/'
		);
	}
}
