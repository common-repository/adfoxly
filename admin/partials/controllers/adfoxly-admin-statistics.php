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
//if ( isset( $settings[ 'adfoxly-navbar' ] ) && ! empty( $settings[ 'adfoxly-navbar' ] ) && $settings[ 'adfoxly-navbar' ] === 'true' ) {
	$navbar = new AdfoxlyAdminNavbarController();
	$navbar->render();
//}

$form            = new AdfoxlyFormController();
$banners         = new AdfoxlyBannerModel();
$places          = new AdfoxlyPlacesModel();
$statisticsModel = new AdfoxlyStatisticsModel();

$context[ 'countAdsClicks' ] = $statisticsModel->countAdsClicks();
$context[ 'countAdsViews' ]  = $statisticsModel->countAdsViews();
$context[ 'countAds' ]       = $banners->countAds();


$i                = 0;
$arrayClicks      = '';
$arrayBannersID   = '';
$arrayBannersName = '';
$numOfClicks      = 10;
foreach ( $statisticsModel->countTopClicks( $numOfClicks ) as $ad ):

	if ( $i == 0 ) {
		$color = 'success';
	} else if ( $i == 1 ) {
		$color = 'danger';
	} else {
		$color = 'secondary';
	}

	if ( $arrayClicks === '' ) {
		$arrayClicks = $ad->clicks;
	} else {
		$arrayClicks .= "," . $ad->clicks;
	}
	if ( $arrayBannersID === '' ) {
		$arrayBannersID = $ad->banner_id;
	} else {
		$arrayBannersID .= "," . $ad->banner_id;
	}
	if ( $arrayBannersName === '' ) {
		$arrayBannersName = "'" . $ad->post_title . "'";
	} else {
		$arrayBannersName .= "," . "'" . $ad->post_title . "'";
	}

	$i ++;

endforeach;

$i = 0;
foreach ( $statisticsModel->countTopClicks( 10 ) as $ad ):
	if ( $i == 0 ) {
		$color = 'success';
	} else if ( $i == 1 ) {
		$color = 'danger';
	} else {
		$color = 'secondary';
	}

	$context[ 'ads' ][ $i ][ 'post_title' ] = $ad->post_title;
	$context[ 'ads' ][ $i ][ 'banner_id' ]  = $ad->banner_id;
	$context[ 'ads' ][ $i ][ 'clicks' ]     = $ad->clicks;
	$context[ 'ads' ][ $i ][ 'percent' ]    = round( ( $ad->clicks / $statisticsModel->countAdsClicks() * 100 ), 2 );

	$i ++;
endforeach;


$context[ 'numOfClicks' ]      = $numOfClicks;
$context[ 'arrayBannersID' ]   = $arrayBannersID;
$context[ 'arrayBannersName' ] = $arrayBannersName;
$context[ 'arrayClicks' ]      = $arrayClicks;


$i2                = 0;
$arrayClicks2      = '';
$arrayBannersName2 = '';
$arrayBannersID2   = '';
$numOfViews2       = 10;
foreach ( $statisticsModel->countTopViews( $numOfViews2 ) as $ad2 ):
	if ( $i2 == 0 ) {
		$color2 = 'success';
	} else if ( $i2 == 1 ) {
		$color2 = 'danger';
	} else {
		$color2 = 'secondary';
	}

	if ( $arrayClicks2 === '' ) {
		$arrayClicks2 = $ad2->adviews;
	} else {
		$arrayClicks2 .= "," . $ad2->adviews;
	}
	if ( $arrayBannersID2 === '' ) {
		$arrayBannersID2 = $ad2->banner_id;
	} else {
		$arrayBannersID2 .= "," . $ad2->banner_id;
	}
	if ( $arrayBannersName2 === '' ) {
		$arrayBannersName2 = "'" . $ad2->post_title . "'";
	} else {
		$arrayBannersName2 .= "," . "'" . $ad2->post_title . "'";
	}

	$i2++;

endforeach;


$context[ 'numOfViews2' ]       = $numOfViews2;
$context[ 'arrayBannersID2' ]   = $arrayBannersID2;
$context[ 'arrayBannersName2' ] = $arrayBannersName2;
$context[ 'arrayClicks2' ]      = $arrayClicks2;


$i2 = 0;
foreach ( $statisticsModel->countTopViews( 10 ) as $ad2 ):
	if ( $i2 == 0 ) {
		$color2 = 'success';
	} else if ( $i2 == 1 ) {
		$color2 = 'danger';
	} else {
		$color2 = 'secondary';
	}

//	$percent2 = ( $ad2->adviews / $statisticsModel->countAdsViews() * 100 );
	if ( isset( $ad2 ) && ! empty( $ad2 ) ) {

		if ( isset( $ad2->post_title ) && ! empty( $ad2->post_title ) ) {
			$context[ 'ads2' ][ $i2 ][ 'post_title' ] = $ad2->post_title;
		}

		if ( isset( $ad2->banner_id ) && ! empty( $ad2->banner_id ) ) {
			$context[ 'ads2' ][ $i2 ][ 'banner_id' ]  = $ad2->banner_id;
		}

		if ( isset( $ad2->clicks ) && ! empty( $ad2->clicks ) ) {
			$context[ 'ads2' ][ $i2 ][ 'clicks' ]     = $ad2->clicks;
		}

		if ( isset( $ad2->adviews ) && ! empty( $ad2->adviews ) ) {
			$context[ 'ads2' ][ $i2 ][ 'percent' ]    = round( ( $ad2->adviews / $statisticsModel->countAdsViews() * 100 ), 2 );
		}

		$i2++;
	}

endforeach;


$bannersList = $banners->getBanners();
$placesList = $places->get_places();

foreach ( $bannersList as $key => $banner ) {
	$bannersList[ $key ]->clicks = $statisticsModel->getAdClicksByID( $banner->ID );
    if( adfoxly_wa_fs()->can_use_premium_code__premium_only() ) {
        $bannersList[$key]->adViews = $statisticsModel->getSingleAdViewByID($banner->ID);
    } else {
        $bannersList[$key]->adViews = "<a href='" . admin_url( 'admin.php?billing_cycle=annual&trial=true&page=adfoxly-pricing' ) . "' style='color: #6c757d'><small class='blur'>available in pro</small></a>";
    }
}
$context[ 'adsList' ] = $bannersList;

foreach ( $placesList as $key => $place ) {
	$placesList[ $key ]->views = $statisticsModel->getPlaceViewsByID( $place->ID );
}
$context[ 'placesList' ] = $placesList;

Timber::$locations = array( realpath( dirname( __DIR__ ) ) . '/views' );
Timber::render( basename( __FILE__, '.php' ) . '.twig', $context );
