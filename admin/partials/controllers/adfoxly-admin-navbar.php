<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AdfoxlyAdminNavbarController {

	function __construct() {
	}

	function time_elapsed_string( $datetime, $full = false ) {
		$now  = new DateTime;
		$ago  = new DateTime( $datetime );
		$diff = $now->diff( $ago );

		$diff->w = floor( $diff->d / 7 );
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ( $string as $k => &$v ) {
			if ( $diff->$k ) {
				$v = $diff->$k . ' ' . $v . ( $diff->$k > 1 ? 's' : '' );
			} else {
				unset( $string[ $k ] );
			}
		}

		if ( ! $full ) {
			$string = array_slice( $string, 0, 1 );
		}

		return $string ? implode( ', ', $string ) . ' ago' : 'just now';
	}

	function render() {
		// todo check file_get_contents has no error
		// $urlAPI = @file_get_contents('http://api.adfoxly.com/index.php');

		// if ( isset( $urlAPI ) && $urlAPI !== false ) {
			// $jsonAPI = json_decode( $urlAPI );
		//}

		$context[ 'admin' ][ 'url' ] = admin_url();
//		Timber::render( basename(__FILE__, '.php') . '.twig', $context );
        Timber::$locations = array( realpath( dirname( __DIR__ ) ) . '/views', realpath( dirname( dirname( dirname( __DIR__ ) ) ) ) . '/includes/view' );
        Timber::render( basename( __FILE__, '.php' ) . '.twig', $context );
	}
}
