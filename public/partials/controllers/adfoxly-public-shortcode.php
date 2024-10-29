<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class adfoxlyPublicShortcode
 *
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://adfoxly.com/
 * @since      1.4
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/public/partials
 */


class AdfoxlyPublicShortcodeController {

	/**
	 * @var \adfoxlyPlacesController
	 */
	public $places;

	/**
	 * adfoxlyPublicShortcode constructor.
	 */
	public function __construct() {
		add_shortcode( 'adfoxly', array( $this, 'adfoxly_shortcodes' ) );
	}

	/**
	 * @param string $attr
	 *
	 * @return bool|string
	 */
	function adfoxly_shortcodes( $attr = "" ) {
		if ( isset( $attr ) && ! empty( $attr ) ) {
			switch ( key( $attr ) ) {
				case 'place':
					$this->places = new AdfoxlyPlacesController();
					return $this->places->renderPlace( $attr[ 'place' ] );
					break;
			}
		}
	}
}
