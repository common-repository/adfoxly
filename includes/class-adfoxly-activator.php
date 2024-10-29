<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fired during plugin activation
 *
 * @link       https://adfoxly.com/
 * @since      1.0.0
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Adfoxly
 * @subpackage Adfoxly/includes
 * @author     AdFoxly <hello@adfoxly.com>
 */
class AdfoxlyActivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		flush_rewrite_rules( true );
		$custom_url = new Adfoxly();
		$custom_url->adfoxly_flush_rules();

		global $wpdb;
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "adfoxly_statistics_clicks` ( `id` INT( 11 ) NOT NULL AUTO_INCREMENT,
			  `banner_id` INT( 11 ) NOT NULL,
			  `ad_id` INT( 11 ) NOT NULL,
			  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `ip` VARCHAR( 15 ) NULL,
			  `fingerprint` VARCHAR( 50 ) NOT NULL,
			  PRIMARY KEY( `id` )
			) ENGINE = InnoDB  DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;" );

		// db views statistics
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "adfoxly_statistics_views` ( `id` INT NOT NULL AUTO_INCREMENT,
				`banner_id` INT NOT NULL,
				`ad_id` INT NOT NULL,
				`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`ip` VARCHAR( 50 ) NULL,
				`fingerprint` VARCHAR( 50 ) NOT NULL,
				PRIMARY KEY( `id` )
			) ENGINE = InnoDB  DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;" );

		$settings[ 'adfoxly-wizard' ] = 'false';
		$settings[ 'statistics-status' ] = 'enabled';
		$settings[ 'statistics-type' ] = 'internal';
		$settings[ 'statistics-saving-view-interval' ] = '10';
		update_option( 'adfoxly_settings', $settings );
	}

	static public function addPredefinedPlaces( $slug, $name ) {
		$args      = array(
			'name'           => $slug,
			'post_type'      => 'adfoxly_places',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'numberposts'    => 1
		);
		$getPlaces = get_posts( $args );

		if ( isset( $getPlaces ) && ( empty( $getPlaces ) || $getPlaces[ 0 ]->post_name !== $slug ) ) {
			$data = array();
			$data[ 'adfoxly-place-name' ] = $name;
			$data[ 'options' ][ 'adfoxly-place-category' ] = 'predefined';
			$data[ 'options' ][ 'adfoxly-place-slug' ] = $slug;
			$data[ 'options' ][ 'adfoxly-place-order' ] = 1;
			$data[ 'options' ][ 'type' ] = 'img';
			$data[ 'options' ][ 'image' ] = $slug . '.svg';

			$places = new AdfoxlyPlacesModel();
			$result = $places->insert( $data );

			if ( isset( $result ) && ! is_wp_error( $result ) ) {
				$places->insert_meta( $result, $data, $data[ 'options' ] );
			}
		}
	}
}
