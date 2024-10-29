<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://adfoxly.com/
 * @since      1.0.0
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/public/partials
 */

class AdfoxlyPublicDisplayController {

	/**
	 * @var null
	 */
	private $render;
	/**
	 * @var mixed
	 */
	private $settings;

	/**
	 * adfoxlyPublic constructor.
	 */
	function __construct() {
		$this->render = null;
		$settings = get_option( 'adfoxly_settings' );
		if ( ! isset( $settings[ 'redirect-slug' ] ) || empty( $settings[ 'redirect-slug' ] ) ) {
			$settings[ 'redirect-slug' ] = 'rdir-adfoxly';
		}

		$this->settings   = $settings;
	}

	/**
	 * @param $id
	 * @param $shuffleMeta
	 * @param $place
	 * @param $place_type
	 *
	 * @return mixed
	 */
	public function renderPlace( $id, $shuffleMeta, $place, $place_type ) {
		$context[ 'site' ][ 'url' ] = get_home_url();
		$context[ 'settings' ]      = $this->settings;

		if (
			isset( $place[ 'options' ] )
			&& isset( $place[ 'options' ][ 'adfoxly-adzone-how-rotate' ] )
			&& $place[ 'options' ][ 'adfoxly-adzone-how-rotate' ] === 'refresh'
		) {
			$context[ 'shuffleMeta' ] = array( $shuffleMeta[ 0 ] );
		} else {
			$context[ 'shuffleMeta' ] = $shuffleMeta;
		}

		$context[ 'place' ]         = $place;
		$context[ 'first' ]         = 'true';
		$context[ 'id' ]            = $id;
		$context[ 'place_type' ]    = $place_type;

		return Timber::compile( basename( __FILE__, '.php' ) . '.twig', $context );
	}

	/**
	 * @param $options
	 *
	 * @return mixed|string
	 */
	public function render( $options ) {
		return $this->renderPlace( $options->id, $options->meta, $options->place, $options->place_type );
	}
}
