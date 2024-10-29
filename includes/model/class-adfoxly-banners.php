<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AdfoxlyBannerModel {

	public function __construct() {
	}

	public function getBanner( $id ) {
		$banner[ 'details' ] = get_post( $id );
		$banner[ 'meta' ]    = get_post_meta( $id );

		return $banner;
	}

	public function getBanners( $limit = - 1 ) {

		$args = array(
			'post_type'      => 'adfoxly_banners',
			'posts_per_page' => $limit
		);

		return get_posts( $args );
	}


	public function countAds() {
		return count( $this->getBanners() );
	}

	public function getBannersWithMetaForTwig( $limit = - 1 ) {

		$placesModel = new AdfoxlyPlacesModel();
		$args = array(
			'post_type'      => 'adfoxly_banners',
			'posts_per_page' => $limit
		);

		$posts    = get_posts( $args );
		$i        = 0;
		$newPosts = array();

		foreach ( $posts as $post ) {
			$newPosts[ $i ][ 'details' ]             = get_post( $post->ID );
			$newPosts[ $i ][ 'meta' ]                = get_post_meta( $post->ID );
			$newPosts[ $i ][ 'meta' ][ 'campaigns' ] = array();
			$newPosts[ $i ][ 'meta' ][ 'place' ]     = array();

			$newMeta                     = array();
			foreach ( $newPosts[ $i ][ 'meta' ] as $key => $value ) {
				$newKey             = str_replace( '-', '_', $key );
				if ( isset( $value ) && isset( $value[ 0 ] ) && ! empty( $value[ 0 ] ) ) {
					$newMeta[ $newKey ] = $value[ 0 ];
				}
			}
			$newPosts[ $i ][ 'meta' ] = $newMeta;

			$getCampaignsByAdId = $placesModel->get_campaigns_by_ad_id( $post->ID );
			if ( is_array( $getCampaignsByAdId ) ) {
				$ci = 0;
				foreach ( $getCampaignsByAdId as $key => $value ) {
					$newPosts[ $i ][ 'meta' ][ 'campaigns' ][ $ci ][ 'id' ]         = $value->ID;
					$newPosts[ $i ][ 'meta' ][ 'campaigns' ][ $ci ][ 'post_title' ] = $value->post_title;
					$newPosts[ $i ][ 'meta' ][ 'campaigns' ][ $ci ][ 'end_date' ]   = get_post_meta( $value->ID, 'adfoxly-ad-campaign-end', true );
					$ci++;
				}
			}

			$getPlaceByBannerId = $placesModel->get_placeby_banner_id( $post->ID );
			if ( is_array( $getPlaceByBannerId ) || is_object( $getPlaceByBannerId ) ) {
				$ci = 0;
				foreach ( $getPlaceByBannerId as $key => $value ) {
					$newPosts[ $i ][ 'meta' ][ 'place' ][ $key ] = $value;
					$ci++;
				}
			}
			$i ++;
		}

		return $newPosts;
	}

	public function getAllBannersFromAdzoneByID( $id, $limit = - 1 ) {

		$args = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly-adzone',
					'value' => $id
				)
			),
			'post_type'      => 'adfoxly_banners',
			'posts_per_page' => $limit
		);

		return get_posts( $args );
	}

	public function insert( $post ) {

		$data = array(
			'post_title'  => sanitize_text_field( $post[ 'adfoxly-ad-name' ] ),
			'post_status' => 'publish',
			'post_type'   => 'adfoxly_banners',
			'post_author' => get_current_user_id(),
		);

		$result = wp_insert_post( $data );

		return $result;
	}

	public function update( $post ) {
		$data = array(
			'ID'          => sanitize_text_field( $post[ 'adfoxly-banner-id' ] ),
			'post_title'  => sanitize_text_field( $post[ 'adfoxly-ad-name' ] ),
		);

		$result = wp_update_post( $data );

		return $result;
	}

	public function insert_meta( $post_id, $result, $action ) {
		if ( adfoxly_wa_fs()->is__premium_only() ) {
			if ( adfoxly_wa_fs()->can_use_premium_code() ) {
				update_post_meta( $post_id, sanitize_text_field( 'adfoxly_force_ad_token' ), sanitize_text_field( sha1( date( 'U' ) ) ) );
			}
		}

		$image = new AdfoxlyFormatImageModel();
		foreach ( $image->meta_fields as $meta_field ):
			if ( $meta_field[ 'id' ] !== 'adfoxly-image_button' && $meta_field[ 'id' ] !== 'adfoxly-ad-preview' ) {
				if (
					isset( $_POST )
					&& !empty( $_POST )
					&& isset( $meta_field )
					&& ! empty( $meta_field )
					&& isset( $meta_field[ 'id' ] )
					&& ! empty ( $meta_field[ 'id' ] )
					&& isset( $_POST[ $meta_field[ 'id' ] ] )
					&& ! empty ( $_POST[ $meta_field[ 'id' ] ] )
				) {
					update_post_meta( $post_id, sanitize_text_field( $meta_field[ 'id' ] ), sanitize_text_field( $_POST[ $meta_field[ 'id' ] ] ) );
				} else {
					$error[ $meta_field[ 'id' ] ] = 'Empty value';
				}
			}

			if ( $meta_field[ 'id' ] === 'adfoxly-adsense-code' ) {
				update_post_meta( $post_id, sanitize_text_field( $meta_field[ 'id' ] ), $_POST[ $meta_field[ 'id' ] ] );
			}

			if ( $meta_field[ 'id' ] === 'adfoxly-custom-code' ) {
				update_post_meta( $post_id, sanitize_text_field( $meta_field[ 'id' ] ), $_POST[ $meta_field[ 'id' ] ] );
			}
		endforeach;

		$format = new AdfoxlyFormatsModel();
		foreach ( $format->meta_fields as $meta_field ):
			if ( empty ( $_POST[ $meta_field[ 'id' ] ] ) ) {
				$error[ $meta_field[ 'id' ] ] = 'Empty value';
			} else {
				update_post_meta( $post_id, sanitize_text_field( $meta_field[ 'id' ] ), sanitize_text_field( $_POST[ $meta_field[ 'id' ] ] ) );
			}
		endforeach;

		if ( isset( $action ) && $action === 'new' ) {
			update_post_meta( $post_id, sanitize_text_field( 'adfoxly-ad-status' ), 'active' );
		}
	}
}
