<?php

add_action( "wp_ajax_adfoxly_place_name_availability", "adfoxly_place_name_availability" );
add_action( "wp_ajax_nopriv_adfoxly_place_name_availability", "adfoxly_place_name_availability" );

add_action( "wp_ajax_adfoxly_ad_name_availability", "adfoxly_ad_name_availability" );
add_action( "wp_ajax_nopriv_adfoxly_ad_name_availability", "adfoxly_ad_name_availability" );

add_action( "wp_ajax_adfoxly_campaign_name_availability", "adfoxly_campaign_name_availability" );
add_action( "wp_ajax_nopriv_adfoxly_campaign_name_availability", "adfoxly_campaign_name_availability" );

function adfoxly_place_name_availability() {
	$place_name = $_POST['place_name'];
	if ( isset( $_POST[ 'current_place_id' ] ) && ! empty( $_POST[ 'current_place_id' ] ) ) {
		$current_place_id = $_POST['current_place_id'];
	}

	$args = array("post_type" => "adfoxly_places", "name" => $place_name);
	$query = get_posts( $args );
	if ( isset( $query ) && ! empty( $query ) && ! empty( $query[ 0 ] ) ) {
		foreach ( $query as $item => $value ) {
			if ( $value->ID != $current_place_id ) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	} else {
		echo 'false';
	}

	exit();
	wp_die();
}

function adfoxly_ad_name_availability() {
	$ad_name = $_POST['ad_name'];
	$current_ad_id = $_POST['current_ad_id'];

	$args = array( "post_type" => "adfoxly_banners", "name" => $ad_name );
	$query = get_posts( $args );
	if ( isset( $query ) && ! empty( $query ) ) {
		foreach ( $query as $item => $value ) {
			if ( $value->ID != $current_ad_id ) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	} else {
		echo 'false';
	}

	exit();
	wp_die();
}

function adfoxly_campaign_name_availability() {
	$campaign_name = $_POST['campaign_name'];
	$current_campaign_id = $_POST['current_campaign_id'];

	$args = array( "post_type" => "adfoxly_ad_campaign", "name" => $campaign_name );
	$query = get_posts( $args );
	if ( isset( $query ) && ! empty( $query ) && ! empty( $query[ 0 ] ) ) {
		foreach ( $query as $item => $value ) {
			if ( $value->ID != $current_campaign_id ) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	} else {
		echo 'false';
	}

	exit();
	wp_die();
}

add_action( "wp_ajax_adfoxly_ad_status", "adfoxly_ad_status" );
add_action( "wp_ajax_nopriv_adfoxly_ad_status", "adfoxly_ad_status" );

function adfoxly_ad_status() {
	$post_id = $_POST['post_id'];
	update_post_meta( $post_id, sanitize_text_field( 'adfoxly-ad-status' ), sanitize_text_field( $_POST[ 'status' ] ) );
	wp_die();
}

add_action( "wp_ajax_adfoxly_campaign_excluded_categories", "adfoxly_campaign_excluded_categories" );
add_action( "wp_ajax_nopriv_adfoxly_campaign_excluded_categories", "adfoxly_campaign_excluded_categories" );

function adfoxly_campaign_excluded_categories(  ) {
	$data = array();

	$places_model      = new AdfoxlyPlacesModel();
	$listOfPostAndPagesCategories = $places_model->listOfPostAndPagesCategories();

	$i=0;
	foreach ( $listOfPostAndPagesCategories as $category ):
		$data[ $i ]['id'] = $category->name;
		$data[ $i ]['text'] = $category->name;
		$i++;
	endforeach;

	echo json_encode($data);
	wp_die();
}

add_action( "wp_ajax_adfoxly_campaign_allowed_categories", "adfoxly_campaign_allowed_categories" );
add_action( "wp_ajax_nopriv_adfoxly_campaign_allowed_categories", "adfoxly_campaign_allowed_categories" );

function adfoxly_campaign_allowed_categories(  ) {
	$data = array();

	$places_model      = new AdfoxlyPlacesModel();
	$listOfPostAndPagesCategories = $places_model->listOfPostAndPagesCategories();

	$i=0;
	foreach ( $listOfPostAndPagesCategories as $category ):
		$data[ $i ]['id'] = $category->name;
		$data[ $i ]['text'] = $category->name;
		$i++;
	endforeach;

	echo json_encode($data);
	wp_die();
}

add_action( "wp_ajax_adfoxly_campaign_excluded_tags", "adfoxly_campaign_excluded_tags" );
add_action( "wp_ajax_nopriv_adfoxly_campaign_excluded_tags", "adfoxly_campaign_excluded_tags" );

function adfoxly_campaign_excluded_tags(  ) {
	$data = array();

	$places_model      = new AdfoxlyPlacesModel();
	$listOfPostAndPagesTags = $places_model->listOfPostAndPagesTags();

	$i=0;
	foreach ( $listOfPostAndPagesTags as $tag ):
		$data[ $i ]['id'] = $tag->name;
		$data[ $i ]['text'] = $tag->name;
		$i++;
	endforeach;

	echo json_encode($data);
	wp_die();
}

add_action( "wp_ajax_adfoxly_campaign_allowed_tags", "adfoxly_campaign_allowed_tags" );
add_action( "wp_ajax_nopriv_adfoxly_campaign_allowed_tags", "adfoxly_campaign_allowed_tags" );

function adfoxly_campaign_allowed_tags(  ) {
	$data = array();

	$places_model      = new AdfoxlyPlacesModel();
	$listOfPostAndPagesTags = $places_model->listOfPostAndPagesTags();

	$i=0;
	foreach ( $listOfPostAndPagesTags as $tag ):
		$data[ $i ]['id'] = $tag->name;
		$data[ $i ]['text'] = $tag->name;
		$i++;
	endforeach;

	echo json_encode($data);
	wp_die();
}

add_action( "wp_ajax_adfoxly_campaign_excluded_post_or_page", "adfoxly_campaign_excluded_post_or_page" );
add_action( "wp_ajax_nopriv_adfoxly_campaign_excluded_post_or_page", "adfoxly_campaign_excluded_post_or_page" );

function adfoxly_campaign_excluded_post_or_page(  ) {
	$data = array();

	$places_model      = new AdfoxlyPlacesModel();
	$listOfPostOrPages = $places_model->listOfPostOrPages();

	$i=0;
	foreach ( $listOfPostOrPages as $postOrPages ):
		$data[ $i ]['id'] = $postOrPages->ID;
		$data[ $i ]['text'] = $postOrPages->post_title;
		$i++;
	endforeach;

	echo json_encode($data);
	wp_die();
}

add_action( "wp_ajax_adfoxly_campaign_allowed_post_or_page", "adfoxly_campaign_allowed_post_or_page" );
add_action( "wp_ajax_nopriv_adfoxly_campaign_allowed_post_or_page", "adfoxly_campaign_allowed_post_or_page" );

function adfoxly_campaign_allowed_post_or_page(  ) {
	$data = array();

	$places_model      = new AdfoxlyPlacesModel();
	$listOfPostOrPages = $places_model->listOfPostOrPages();

	$i=0;
	foreach ( $listOfPostOrPages as $postOrPages ):
		$data[ $i ]['id'] = $postOrPages->post_title;
		$data[ $i ]['text'] = $postOrPages->post_title;
		$i++;
	endforeach;

	echo json_encode($data);
	wp_die();
}

add_action( "wp_ajax_adfoxlySaveBannerView", "adfoxlySaveBannerView" );
add_action( "wp_ajax_nopriv_adfoxlySaveBannerView", "adfoxlySaveBannerView" );

function adfoxlySaveBannerView() {

	$settings = get_option( 'adfoxly_settings' );
	if ( ! isset( $settings[ 'statistics-saving-view-interval' ] ) || empty( $settings[ 'statistics-saving-view-interval' ] ) ) {
		$settings[ 'statistics-saving-view-interval' ] = 10;
	}

	global $wpdb;
	$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_views';
	$getLastView  = $wpdb->prefix . 'adfoxly_statistics' . '_views';
	$ad_id        = $_POST[ 'post_id' ];

	$lastAdViewDate    = $wpdb->get_var( "SELECT `date` FROM " . $wpdb->prefix . "adfoxly_statistics_views WHERE `banner_id` = '" . $ad_id . "' ORDER BY id desc LIMIT 1" );
	$currentAdViewDate = date( "Y-m-d H:i:s" );
	$lastAdViewDate    = date_create( $lastAdViewDate );
	$currentAdViewDate = date_create( $currentAdViewDate );
	$interval          = date_diff( $lastAdViewDate, $currentAdViewDate );

	$stats = new AdfoxlyStatisticsController();
		$wpdb->insert( $dbStatisitcs, array(
			'id'          => null,
			'banner_id'   => $ad_id,
			'date'        => date( "Y-m-d H:i:s" ),
			'fingerprint' => $stats->getFingerPrint(),
		) );
	wp_die();
}
