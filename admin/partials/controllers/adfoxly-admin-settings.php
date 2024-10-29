<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://adfoxly.com/
 * @since      1.0.0
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/admin/partials
 */

$settings = get_option( 'adfoxly_settings' );

if ( isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {

	if ( isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {

		if ( isset( $_POST ) && ! empty( $_POST ) && isset( $_POST[ 'remove-adfoxly-data' ] ) ) {
			global $wpdb;
			$statistics_clics = "{$wpdb->prefix}adfoxly_statistics_clicks";
			$statistics_views = "{$wpdb->prefix}adfoxly_statistics_views";

			delete_option( 'adfoxly_settings' );

			$adfoxly_campaigns = get_posts( array( 'post_type' => 'adfoxly_ad_campaign', 'posts_per_page' => -1 ) );
			$adfoxly_banners   = get_posts( array( 'post_type' => 'adfoxly_banners', 'posts_per_page' => -1 ) );
			$adfoxly_places    = get_posts( array( 'post_type' => 'adfoxly_places', 'posts_per_page' => -1 ) );

			if ( isset( $adfoxly_campaigns ) && ! empty( $adfoxly_campaigns ) ) {
				foreach ( $adfoxly_campaigns as $adfoxly_campaign ) {
					wp_delete_post( $adfoxly_campaign->ID, true );
				}
			}

			if ( isset( $adfoxly_banners ) && ! empty( $adfoxly_banners ) ) {
				foreach ( $adfoxly_banners as $adfoxly_banner ) {
					wp_delete_post( $adfoxly_banner->ID, true );
				}
			}

			if ( isset( $adfoxly_places ) && ! empty( $adfoxly_places ) ) {
				foreach ( $adfoxly_places as $adfoxly_place ) {
					wp_delete_post( $adfoxly_place->ID, true );
				}
			}

			$wpdb->query( "TRUNCATE TABLE `$statistics_clics`" );
			$wpdb->query( "TRUNCATE TABLE `$statistics_views`" );

		} else {

			if ( isset( $_POST[ 'adfoxly-redirect-slug' ] ) ) {
				if ( ! isset( $settings[ 'redirect-slug' ] ) || empty( $settings[ 'redirect-slug' ] ) || $_POST[ 'adfoxly-redirect-slug' ] !== $settings[ 'redirect-slug' ] ) {
					$settings[ 'redirect-slug' ] = sanitize_text_field( $_POST[ 'adfoxly-redirect-slug' ] );
					update_option( 'adfoxly_settings', $settings );
					flush_rewrite_rules( true );
					global $wp_rewrite;
					$wp_rewrite->flush_rules();
				}
			}

			if ( isset( $_POST[ 'adfoxly-facebook-pixel-code' ] ) ) {
				// here we need add html code, cannot use sanitize_text_field
//			$settings[ 'adfoxly-facebook-pixel-code' ] = wp_kses_post( $_POST[ 'adfoxly-facebook-pixel-code' ] );
				$settings[ 'adfoxly-facebook-pixel-code' ] = $_POST[ 'adfoxly-facebook-pixel-code' ];
				update_option( 'adfoxly_settings', $settings );

			}

			if ( isset( $_POST[ 'adfoxly-adstxt-code' ] ) ) {
				$fp = fopen( '../ads.txt', 'w' );
				fwrite( $fp, $_POST[ 'adfoxly-adstxt-code' ] );
				fclose( $fp );
			}

            if ( isset( $_POST[ 'adfoxly-privacy-freshpaint' ] ) ) {
                // here we need add html code, cannot use sanitize_text_field
                $settings[ 'adfoxly-privacy-freshpaint' ] = wp_kses_post( $_POST[ 'adfoxly-privacy-freshpaint' ] );
                update_option( 'adfoxly_settings', $settings );
            }

            if ( isset( $_POST[ 'adfoxly-privacy-smartlook' ] ) ) {
                // here we need add html code, cannot use sanitize_text_field
                $settings[ 'adfoxly-privacy-smartlook' ] = wp_kses_post( $_POST[ 'adfoxly-privacy-smartlook' ] );
                update_option( 'adfoxly_settings', $settings );
            }

            if ( isset( $_POST[ 'adfoxly-privacy-sentry' ] ) ) {
                // here we need add html code, cannot use sanitize_text_field
                $settings[ 'adfoxly-privacy-sentry' ] = wp_kses_post( $_POST[ 'adfoxly-privacy-sentry' ] );
                update_option( 'adfoxly_settings', $settings );
            }

            if ( isset( $_POST[ 'adfoxly-privacy-bugsnag' ] ) ) {
                // here we need add html code, cannot use sanitize_text_field
                $settings[ 'adfoxly-privacy-bugsnag' ] = wp_kses_post( $_POST[ 'adfoxly-privacy-bugsnag' ] );
                update_option( 'adfoxly_settings', $settings );
            }

			if ( isset( $_POST[ 'adfoxly-statistics-status' ] ) ) {
				if ( ! isset( $settings[ 'statistics-status' ] ) || empty( $settings[ 'statistics-status' ] ) || $_POST[ 'adfoxly-statistics-status' ] !== $settings[ 'statistics-status' ] ) {
					$settings[ 'statistics-status' ] = sanitize_text_field( $_POST[ 'adfoxly-statistics-status' ] );
					update_option( 'adfoxly_settings', $settings );

					if ( $_POST[ 'adfoxly-statistics-status' ] === 'enabled' ) {
						$statistics = new AdfoxlyStatisticsController();
						$statistics->insertTables();
					}
				}
			}

			if ( isset( $_POST[ 'adfoxly-statistics-type' ] ) && ! empty( $_POST[ 'adfoxly-statistics-type' ] ) ) {
				if ( ! isset( $settings[ 'statistics-type' ] ) || $_POST[ 'adfoxly-statistics-type' ] !== $settings[ 'statistics-type' ] ) {
					$settings[ 'statistics-type' ] = $_POST[ 'adfoxly-statistics-type' ];
					update_option( 'adfoxly_settings', $settings );
				}
			}

			if ( ! isset( $_POST[ 'adfoxly-statistics-type' ] ) || empty( $_POST[ 'adfoxly-statistics-type' ] ) ) {
				$settings[ 'statistics-type' ] = array( 'internal' );
				update_option( 'adfoxly_settings', $settings );
			}

			if ( isset( $_POST[ 'adfoxly-statistics-gaid-select' ] ) && ! empty( $_POST[ 'adfoxly-statistics-gaid-select' ] ) ) {
				if ( isset( $_POST[ 'adfoxly-statistics-gaid-select' ] )
				     && ! empty( $_POST[ 'adfoxly-statistics-gaid-select' ] )
				     && $_POST[ 'adfoxly-statistics-gaid-select' ] !== $settings[ 'statistics-gaid-select' ]
				) {
					$settings[ 'statistics-gaid-select' ] = sanitize_text_field( $_POST[ 'adfoxly-statistics-gaid-select' ] );
					update_option( 'adfoxly_settings', $settings );
				}
			}

			if ( isset( $_POST[ 'adfoxly-statistics-custom-gaid' ] ) && ! empty( $_POST[ 'adfoxly-statistics-custom-gaid' ] ) ) {
				if ( isset( $_POST[ 'adfoxly-statistics-custom-gaid' ] )
				     && ! empty( $_POST[ 'adfoxly-statistics-custom-gaid' ] )
				     && $_POST[ 'adfoxly-statistics-custom-gaid' ] !== $settings[ 'statistics-custom-gaid' ]
				) {
					$settings[ 'statistics-custom-gaid' ] = sanitize_text_field( $_POST[ 'adfoxly-statistics-custom-gaid' ] );
					update_option( 'adfoxly_settings', $settings );
				}
			}

			if (
				isset( $_POST[ 'adfoxly-statistics-saving-view-interval' ] )
				&& (
					! empty( $_POST[ 'adfoxly-statistics-saving-view-interval' ] )
					|| $_POST[ 'adfoxly-statistics-saving-view-interval' ] === '0'
				)
			) {
				if (
					! isset( $settings[ 'statistics-saving-view-interval' ] )
					|| sanitize_text_field( $_POST[ 'adfoxly-statistics-saving-view-interval' ] ) !== $settings[ 'statistics-saving-view-interval' ]
				) {
					$settings[ 'statistics-saving-view-interval' ] = sanitize_text_field( $_POST[ 'adfoxly-statistics-saving-view-interval' ] );
					update_option( 'adfoxly_settings', $settings );
				}
			}

			if ( isset( $_POST[ 'adfoxly-navbar' ] ) ) {
				$settings[ 'adfoxly-navbar' ] = sanitize_text_field( $_POST[ 'adfoxly-navbar' ] );
				update_option( 'adfoxly_settings', $settings );
			}

			if ( isset( $_POST[ 'adfoxly-error-404' ] ) ) {
				$settings[ 'adfoxly-error-404' ] = sanitize_text_field( $_POST[ 'adfoxly-error-404' ] );
				update_option( 'adfoxly_settings', $settings );
			}

//			if ( isset( $_POST[ 'adfoxly-default-ui' ] ) ) {
//				$settings[ 'adfoxly-default-ui' ] = sanitize_text_field( $_POST[ 'adfoxly-default-ui' ] );
//				update_option( 'adfoxly_settings', $settings );
//			}

			if ( isset( $_POST[ 'adfoxly-wizard' ] ) ) {
				$settings[ 'adfoxly-wizard' ] = sanitize_text_field( $_POST[ 'adfoxly-wizard' ] );
				update_option( 'adfoxly_settings', $settings );
			}
		}
	}

}

$form     = new AdfoxlyFormController();
$settings = get_option( 'adfoxly_settings' );
//if ( isset( $settings[ 'adfoxly-navbar' ] ) && ! empty( $settings[ 'adfoxly-navbar' ] ) && $settings[ 'adfoxly-navbar' ] !== 'true' ) {
	$navbar = new AdfoxlyAdminNavbarController();
	$navbar->render();
//}


$settings = get_option( 'adfoxly_settings' );

$context[ 'admin' ][ 'url' ]      = admin_url();
$context[ 'wp_create_nonce' ]     = wp_create_nonce();
//if ( isset( $settings[ 'adfoxly-default-ui' ] ) && ! empty( $settings[ 'adfoxly-default-ui' ] ) ) {
//	$context[ 'ui' ] = $settings[ 'adfoxly-default-ui' ];
//}

$context[ 'settings_redirect' ]   = $form->generate( array( 'type' => 'settings_redirect' ) );
$context[ 'settings_statistics' ] = $form->generate( array( 'type' => 'settings_statistics' ) );
$context[ 'settings_adstxt' ]     = $form->generate( array( 'type' => 'settings_adstxt' ) );
$context[ 'settings_pixel' ]      = $form->generate( array( 'type' => 'settings_pixel' ) );
$context[ 'settings_privacy' ]    = $form->generate( array( 'type' => 'settings_privacy' ) );
$context[ 'settings_core' ]       = $form->generate( array( 'type' => 'settings_core' ) );

if ( isset( $_GET ) && isset( $_GET[ 'debug_mode' ] ) && $_GET[ 'debug_mode' ] === 'true' ) {
	$context[ 'debug_mode' ] = 'true';
}

Timber::$locations = array( realpath( dirname( __DIR__ ) ) . '/views' );
Timber::render( basename( __FILE__, '.php' ) . '.twig', $context );
