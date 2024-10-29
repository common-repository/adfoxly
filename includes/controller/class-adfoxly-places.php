<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class adfoxlyPlacesController
 */
class AdfoxlyPlacesController {
	/**
	 * @var array
	 */
	private $meta = NULL;

	/**
	 * @var null
	 */
	private $render;

	/**
	 * @var mixed
	 */
	private $settings;

	/**
	 * @var \AdfoxlyStatisticsController
	 */
	private $statistics;

	/**
	 * @var
	 */
	private $places;

	/**
	 * @var
	 */
	private $place;

	/**
	 * @var array|mixed|object
	 */
	private $visitor;

	/**
	 * @var
	 */
	private $context;

	/**
	 * @var null
	 */
	private $adType = null;

	/**
	 * @var \AdfoxlyPlacesModel
	 */
	private $placesModel;

	/**
	 * adfoxlyPlacesController constructor.
	 */
	public function __construct() {

		$this->placesModel = new AdfoxlyPlacesModel();

		$getPlacesArgs = array(
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1,
		);

		$getPlaces = get_posts( $getPlacesArgs );


		foreach ( $getPlaces as $place ) {
			$placeMeta = get_post_meta( $place->ID );
			$this->places[ $place->ID ][ "options" ][ "adfoxly-adzone-is-rotate" ]   = 'yes';

			if ( isset( $placeMeta[ 'adfoxly-adzone-how-rotate' ][ 0 ] ) && ! empty( $placeMeta[ 'adfoxly-adzone-how-rotate' ][ 0 ] ) ) {

				$this->places[ $place->ID ][ "options" ][ "adfoxly-adzone-how-rotate" ]  = $placeMeta[ 'adfoxly-adzone-how-rotate' ][ 0 ];
				if ( isset( $placeMeta[ 'adfoxly-adzone-rotate-time' ][ 0 ] ) && ! empty( $placeMeta[ 'adfoxly-adzone-rotate-time' ][ 0 ] ) ) {
					$this->places[ $place->ID ][ "options" ][ "adfoxly-adzone-rotate-time" ] = $placeMeta[ 'adfoxly-adzone-rotate-time' ][ 0 ];
				}
			}

			if ( isset( $placeMeta[ 'adfoxly_place_sticky_close' ][ 0 ] ) && ! empty( $placeMeta[ 'adfoxly_place_sticky_close' ][ 0 ] ) ) {
				$this->places[ $place->ID ][ "options" ][ "adfoxly_place_sticky_close" ]  = $placeMeta[ 'adfoxly_place_sticky_close' ][ 0 ];
			}

			if ( isset( $placeMeta[ 'adfoxly-adzone-popup-delay' ][ 0 ] ) && ! empty( $placeMeta[ 'adfoxly-adzone-popup-delay' ][ 0 ] ) ) {
				$this->places[ $place->ID ][ "options" ][ "adfoxly-adzone-popup-delay" ]  = $placeMeta[ 'adfoxly-adzone-popup-delay' ][ 0 ];
			}

			if ( isset( $placeMeta[ 'adfoxly-adzone-popup-repeat' ][ 0 ] ) && ! empty( $placeMeta[ 'adfoxly-adzone-popup-repeat' ][ 0 ] ) ) {
				$this->places[ $place->ID ][ "options" ][ "adfoxly-adzone-popup-repeat" ]  = $placeMeta[ 'adfoxly-adzone-popup-repeat' ][ 0 ];
			}
		}

		$this->meta   = array();
		$this->render = null;

		$settings = get_option( 'adfoxly_settings' );
		if ( ! isset( $settings[ 'redirect-slug' ] ) || empty( $settings[ 'redirect-slug' ] ) ) {
			$settings[ 'redirect-slug' ] = 'rdir-adfoxly';
		}

		$this->settings   = $settings;
		$this->statistics = new AdfoxlyStatisticsController();
	}

	/**
	 *
	 */
	public function setVisitor() {
		$this->visitor    = $this->getIpLocationJSON();
	}

	/**
	 * @return mixed
	 */
	public function getIpLocationJSON() {
		return json_decode( $this->getIpLocation() );
	}

	/**
	 * @return bool|mixed
	 */
	public function getIpLocation() {
		$ip          = Adfoxly::ip();

		if ( $ip === '::1' || $ip === '::' ) {
			$ip = '127.0.0.1';
		}
		$ipApi = wp_remote_get( 'http://ip-api.com/json/' . $ip . '?fields=status,message,country,countryCode,region,regionName,city,zip,timezone' );

		if ( isset( $ipApi ) && is_array( $ipApi ) && ( ! empty( $ipApi ) ) && isset( $ipApi[ 'body' ] ) && ! empty( $ipApi[ 'body' ] ) ) {
			return $ipApi[ 'body' ];
		}

		return false;
	}

	/**
	 * @return mixed
	 */
	public function getCityFromIP() {
		$json = json_decode( $this->getIpLocation() );

		return $json[ 'body' ];
	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateStatus( $value ) {
		$status = get_post_meta( $value->ID, 'adfoxly-ad-status', true );
		if ( $status === 'active' ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateCampaignDate( $value ) {

		$start = get_post_meta( $value->ID, 'adfoxly-ad-campaign-start', true );
		$end   = get_post_meta( $value->ID, 'adfoxly-ad-campaign-end', true );

		$today = date( 'Y-m-d' );

		$placesModel = new AdfoxlyPlacesModel();
		$ads = $placesModel->get_campaigns_by_ad_id( $value->ID );

		if ( isset( $ads ) && empty( $ads ) ) {
			if ( ( empty( $start ) && empty( $end ) ) || ( $start <= $today && $end >= $today ) ) {
				return true;
			}
		} else {
			$campaignStart = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-ad-campaign-start', true );
			$campaignEnd   = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-ad-campaign-end', true );

			if ( ( empty( $campaignStart ) && empty( $campaignStart ) ) || ( $campaignStart <= $today && $campaignEnd >= $today ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateCategory( $value ) {

//		$placesModel = new AdfoxlyPlacesModel();
		$ads = $this->placesModel->get_campaigns_by_ad_id( $value->ID );

		if ( ! is_single() ) {
			return true;
		} else if ( ! empty( $ads ) ) {

			$excludedCategories = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-excluded-categories', true );
			$allowedCategories   = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-allowed-categories', true );

			$categories = get_the_category();

			if ( empty( $excludedCategories ) && empty( $allowedCategories ) ) {
				return true;
			} else {
				if ( ! empty( $excludedCategories ) && ! empty( $categories ) ) {
					foreach ( $categories as $category ) {
						if ( in_array( $category->name, $excludedCategories ) ) {
							return false;
						}
					}
				}

				if ( ! empty( $allowedCategories ) && ! empty( $categories ) ) {
					foreach ( $categories as $category ) {
						if ( in_array( $category->name, $allowedCategories ) ) {
							return true;
						}
					}
				}
			}
		} else if ( empty( $ads ) ) {
			return true;
		}

		return false;
	}


	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateTag( $value ) {

		$placesModel = new AdfoxlyPlacesModel();
		$ads         = $placesModel->get_campaigns_by_ad_id( $value->ID );

		if ( ! is_single() ) {
			return true;
		} else if ( ! empty( $ads ) ) {

			$excludedTags = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-excluded-tags', true );
			$allowedTags  = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-allowed-tags', true );

			$tags = get_the_tags();

			if ( empty( $excludedTags ) && empty( $allowedTags ) ) {
				return true;
			} else {
				if ( ! empty( $excludedTags ) && ! empty( $tags ) ) {
					foreach ( $tags as $tag ) {
						if ( in_array( $tag->name, $excludedTags ) ) {
							return false;
						}
					}
				}

				if ( ! empty( $allowedTags ) && ! empty( $tags ) ) {
					foreach ( $tags as $tag ) {
						if ( in_array( $tag->name, $allowedTags ) ) {
							return true;
						}
					}
				}
			}
		} else if ( empty( $ads ) ) {
			return true;
		}

		return false;
	}

	public function validateDevice( $value ) {

		$placesModel    = new AdfoxlyPlacesModel();
		$ads            = $placesModel->get_campaigns_by_ad_id( $value->ID );
		if ( isset( $ads ) && ! empty( $ads ) && ! empty( $ads[ 0 ] ) ) {
			$acceptedDevice = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-devices', true );
			$detect         = new Mobile_Detect;

			if ( isset( $acceptedDevice ) && ! empty( $acceptedDevice ) ) {
				if ( $detect->isMobile() ) {
					if ( $acceptedDevice === 'all' || $acceptedDevice === 'only-mobile' ) {
						return true;
					} else {
						return false;
					}
				} else {
					if ( $acceptedDevice === 'all' || $acceptedDevice === 'only-desktop' ) {
						return true;
					} else {
						return false;
					}
				}
			} else {
				return true;
			}
		} else {
			return true;
		}



	}
	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validatePostOrPage( $value ) {

		$placesModel = new AdfoxlyPlacesModel();
		$ads         = $placesModel->get_campaigns_by_ad_id( $value->ID );

		if ( ! is_single() ) {
			return true;
		} else if ( ! empty( $ads ) ) {

			$excludedPostOrPage = get_post_meta( $ads[ 0 ]->ID, 'adfoxly_campaign_excluded_post_or_page', true );
			$allowedPostOrPage  = get_post_meta( $ads[ 0 ]->ID, 'adfoxly_campaign_allowed_post_or_page', true );
			$currentPost = get_post();

			if ( empty( $excludedPostOrPage ) && empty( $allowedPostOrPage ) ) {
				return true;
			} else {
				if ( ! empty( $excludedPostOrPage ) ) {
					if ( in_array( $currentPost->ID, $excludedPostOrPage ) ) {
						return false;
					} else {
						return true;
					}
				}

				if ( ! empty( $allowedPostOrPage ) ) {
					if ( in_array( $currentPost->ID, $allowedPostOrPage ) ) {
						return true;
					}
				}
			}
		} else if ( empty( $ads ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateCountry( $value ) {

		$placesModel = new AdfoxlyPlacesModel();
		$ads = $placesModel->get_campaigns_by_ad_id( $value->ID );

		if ( ! empty( $ads ) ) {

			$excludedCountries = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-excluded-countries', true );
			$allowedCountries   = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-allowed-countries', true );
			$excludedRegion = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-excluded-region', true );
			$allowedRegion   = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-allowed-region', true );

			if ( empty( $excludedCountries ) && empty( $allowedCountries ) && empty( $excludedRegion ) && empty( $allowedRegion ) ) {
				return true;
			}

			$stats = new AdfoxlyStatisticsController();
			$stats->setVisitor();
			$this->visitor = $stats->getIpLocationJSON();

			if ( isset( $this->visitor ) && ! empty( $this->visitor ) ) {
				if ( ! empty( $allowedCountries ) &&  in_array( $this->visitor->country, $allowedCountries ) ) {
					return true;
				}

				if ( ! empty( $excludedCountries ) && ! in_array( $this->visitor->country, $excludedCountries ) ) {
					return true;
				}

				if ( ! empty( $allowedRegion ) && ( in_array( $this->visitor->city, $allowedRegion ) || in_array( $this->visitor->regionName, $allowedRegion ) ) ) {
					return true;
				}

				if ( ! empty( $excludedRegion ) && ( ! in_array( $this->visitor->city, $excludedRegion ) && ! in_array( $this->visitor->regionName, $excludedRegion ) ) ) {
					return true;
				}
			}

		} else if ( empty( $ads ) ) {
			return true;
		}

		return false;

	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateOnlyAdmins( $value ) {

		$placesModel = new AdfoxlyPlacesModel();
		$ads = $placesModel->get_campaigns_by_ad_id( $value->ID );

		if ( ! empty( $ads ) ) {

			$getOnlyAdminsValue = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-show-admins', true );

			if ( empty( $getOnlyAdminsValue ) ) {
				return true;
			}

			if (
				isset( $getOnlyAdminsValue )
				&& ! empty( $getOnlyAdminsValue )
				&& (
					current_user_can( 'administrator' ) && $getOnlyAdminsValue === 'admins'
				)
			) {
				return true;
			} else if (
				isset( $getOnlyAdminsValue )
				&& ! empty( $getOnlyAdminsValue )
				&& ( $getOnlyAdminsValue === 'all' )
			) {
				return true;
			}

		} else if ( empty( $ads ) ) {
			return true;
		}

		return false;

	}
	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateCampaignDays( $value ) {
		$placesModel = new AdfoxlyPlacesModel();
		$ads = $placesModel->get_campaigns_by_ad_id( $value->ID );

		if ( ! empty( $ads ) ) {
			$adfoxlyCampaignDays = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-days', true );
			$adfoxlyCampaignHours = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-specific-hours', true );

			if ( empty( $adfoxlyCampaignDays ) ) {
				return true;
			}

			$today = strtolower( date('l') );

			if ( ! empty( $adfoxlyCampaignDays ) && in_array( $today, $adfoxlyCampaignDays ) ) {

				if ( empty( $adfoxlyCampaignHours ) ) {
					return true;
				}

				if ( ! empty( $adfoxlyCampaignHours ) && ! in_array( $today, $adfoxlyCampaignHours ) ) {
					return true;
				}

				if ( ! empty( $adfoxlyCampaignHours ) && in_array( $today, $adfoxlyCampaignHours ) ) {
					// todo: check timezone instead of server time
					$hour = date("g:i A");
					$adfoxlyCampaignHourStart = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-specific-hour-start-' . $today, true );
					$adfoxlyCampaignHourEnd = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-specific-hour-end-' . $today, true );

					if ( strtotime($adfoxlyCampaignHourStart) <= strtotime($hour) && strtotime($adfoxlyCampaignHourEnd) >= strtotime($hour) ) {
						return true;
					}
				}
			}

			return false;
		}
	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateUserViews( $value ) {

		$stats = new AdfoxlyStatisticsController();
		$stats->getFingerPrint();

		$placesModel = new AdfoxlyPlacesModel();
		$ads = $placesModel->get_campaigns_by_ad_id( $value->ID );

		if ( ! empty( $ads ) ) {
			$adfoxlyCampaignUserViews = get_post_meta( $ads[ 0 ]->ID, 'adfoxly-campaign-maxviews-user', true );

			if ( isset( $adfoxlyCampaignUserViews ) && ( ! empty( $adfoxlyCampaignUserViews ) || $adfoxlyCampaignUserViews != 0 ) ) {
				global $wpdb;
				$countFingerPrint = $wpdb->get_var( "SELECT count(*) FROM " . $wpdb->prefix . "adfoxly_statistics_views WHERE banner_id = '" . $value->ID . "' AND fingerprint = '" . $stats->getFingerPrint() . "'" );
				if ( $countFingerPrint > $adfoxlyCampaignUserViews ) {
					return false;
				}
			}
		}
	}

	/**
	 * @param $value
	 */
	public function addAdInArrayPlace( $value ) {
		array_push( $this->meta, array(
			'id'         => $value->ID,
			'post_title' => $value->post_title,
			'meta'       => get_post_meta( $value->ID )
		) );
	}

	/**
	 * @param $id
	 */
	public function validateAdInPlace( $id ) {
		$placesModel = new AdfoxlyPlacesModel();

		foreach ( $placesModel->getBannersByPlace( $id ) as $key => $value ) {

			if ( adfoxly_wa_fs()->is__premium_only() ) {
				if ( adfoxly_wa_fs()->can_use_premium_code() ) {
					$getForceAdToken = get_post_meta( $value->ID, 'adfoxly_force_ad_token', true );
				}
			}

			if ( isset( $_GET ) && isset( $getForceAdToken ) && ! empty( $getForceAdToken ) && ! empty( $_GET[ 'adfoxly_force_ad_token' ] ) && $_GET[ 'adfoxly_force_ad_token' ] === $getForceAdToken ) {
				$this->addAdInArrayPlace( $value );
			} else {
				$this->validateCountry( $value );

				if ( $this->validateOnlyAdmins( $value ) !== false ) {

					if ( $this->validateStatus( $value ) !== false ) {

						if ( $this->validateCategory( $value ) !== false ) {

							if ( $this->validateTag( $value ) !== false ) {

								if ( $this->validatePostOrPage( $value ) !== false ) {

									if ( $this->validateDevice( $value ) !== false ) {

										if ( adfoxly_wa_fs()->is__premium_only() ) {

											if ( adfoxly_wa_fs()->can_use_premium_code() ) {

												if ( $this->validateCampaignDate( $value ) !== false && $this->validateCountry( $value ) !== false
												     && $this->validateCampaignDays( $value ) !== false && $this->validateUserViews( $value ) !== false ) {

													$this->addAdInArrayPlace( $value );
												}

											} else {

												$this->addAdInArrayPlace( $value );

											}

										}

										if ( ! adfoxly_wa_fs()->is__premium_only() ) {

											if ( $this->validateCampaignDate( $value ) !== false ) {

												$this->addAdInArrayPlace( $value );
											}
										}

									}
								}
							}
						}
					}

				}
			}



		}
	}

	/**
	 * @param $adType
	 * @param $getPopupPlaceID
	 *
	 * verify popup cookies. if exists (user close ad before), that return false and do not show popup
	 *
	 * @return bool
	 */
	public function verifyPopupCookie( $adType, $getPopupPlaceID ) {
		if ( isset( $adType ) && ! empty( $adType ) && ( $adType === 'popup' || $adType === 'popup-v3' ) && isset( $getPopupPlaceID ) && ! empty( $getPopupPlaceID ) && is_array( $getPopupPlaceID ) ) {
			foreach ( $getPopupPlaceID as $popupAdzoneId ) {
				if ( isset( $_COOKIE ) && isset( $_COOKIE[ "adfoxly_$popupAdzoneId" ] ) && $_COOKIE[ "adfoxly_$popupAdzoneId" ] == 'true' ) {
					if ( isset( $_COOKIE[ "adfoxly_number_$popupAdzoneId" ] ) && $_COOKIE[ "adfoxly_number_$popupAdzoneId" ] < $this->places[ $popupAdzoneId ][ "options" ][ "adfoxly-adzone-popup-repeat" ] ) {
						return true;
					} else {
						return false;
					}
				} else {
					return true;
				}
			}
		}
	}

	/**
	 * @param $id
	 *
	 * @return bool
	 */
	public function verifyPlaceID( $id ) {
		if ( isset( $this->places[ $id ] ) && ! empty( $this->places[ $id ] ) ) {
			$this->place = $this->places[ $id ];
		} else {
			return false;
		}
	}

	/**
	 * @param $id
	 *
	 * todo: move to model
	 *
	 */
	public function getStickyTopPlaceID( $id ) {
		$placesModel = new AdfoxlyPlacesModel();
		if ( is_array( $placesModel->getPlaceIDArgs( 'sticky_top' ) ) && in_array( $id, $placesModel->getPlaceIDArgs( 'sticky_top' ) ) ) {
			$this->adType = 'sticky sticky-top';
		}
	}

	/**
	 * @param $id
	 *
	 * todo: move to model
	 *
	 */
	public function getStickyBottomPlaceID( $id ) {
		$placesModel = new AdfoxlyPlacesModel();
		if ( is_array( $placesModel->getPlaceIDArgs( 'sticky_bottom' ) ) && in_array( $id, $placesModel->getPlaceIDArgs( 'sticky_bottom' ) ) ) {
			$this->adType = 'sticky sticky-bottom';
		}
	}

	/**
	 * @param $id
	 *
	 * todo: move to model
	 *
	 */
	public function getStickyLeftPlaceID( $id ) {
		$placesModel = new AdfoxlyPlacesModel();
		if ( is_array( $placesModel->getPlaceIDArgs( 'sticky_left' ) ) && in_array( $id, $placesModel->getPlaceIDArgs( 'sticky_left' ) ) ) {
			$this->adType = 'sticky sticky-left';
		}
	}

	/**
	 * @param $id
	 *
	 * todo: move to model
	 *
	 */
	public function getStickyRightPlaceID( $id ) {
		$placesModel = new AdfoxlyPlacesModel();
		if ( is_array( $placesModel->getPlaceIDArgs( 'sticky_right' ) ) && in_array( $id, $placesModel->getPlaceIDArgs( 'sticky_right' ) ) ) {
			$this->adType = 'sticky sticky-right';
		}
	}

	/**
	 * @param $id
	 *
	 * todo: move to model
	 *
	 * @return int[]|\WP_Post[]
	 */
	public function getPopupPlaceID( $id ) {
		$placesModel = new AdfoxlyPlacesModel();
		if ( is_array( $placesModel->getPlaceIDArgs( 'popup' ) ) && in_array( $id, $placesModel->getPlaceIDArgs( 'popup' ) ) ) {
			$this->adType = 'popup';
//			$this->adType = 'popup-v3';
		}

		return $placesModel->getPlaceIDArgs( 'popup' );
	}


	/**
	 * edit place
	 */
	public function edit() {
		$place = new AdfoxlyPlacesModel();

		if ( isset( $_GET[ 'edit' ] ) ) {
			$this->context[ 'edit' ] = $_GET['edit'];
		}

		if ( isset( $_GET[ 'edit' ] ) && $_GET[ 'edit' ] !== 'new' ) {
			$this->context[ 'g_id' ] = $_GET[ 'edit' ];
		} else {
			$this->context[ 'g_id' ] = 'new';
		}

		if ( isset( $_POST ) && ! empty( $_POST ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
			if ( isset( $_GET[ 'edit' ] ) && $_GET[ 'edit' ] === 'new' ) {
				$result = $place->insert( $_POST );
				$data = array();
				$data[ 'options' ][ 'adfoxly-place-category' ] = 'custom';
				if ( isset( $result ) && ! is_wp_error( $result ) ) {
					$place->insert_meta( $result, $_POST, $data[ 'options' ] );
				}
				$popup_content = "created";
			} else {
				$result = $place->update( $_POST );
				$place->insert_meta( $_GET[ 'edit' ], $_POST );
				$popup_content = "edited";
			}

			$redirect = admin_url( 'admin.php?page=adfoxly-places' );
			echo '<script>window.location.href = "' . $redirect . '";</script>';
		}

		if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ):
			$this->context[ 'title' ]    = 'Edit place';
			$this->context[ 'places_header' ] = Timber::compile( 'group-header.twig', $this->context );

			$places = new AdfoxlyPlacesModel();
			$form = new AdfoxlyFormController();

			$this->context['test'] = $places->get_place( $_GET['edit'] );
			$this->context['places_settings'] = $form->generate( array( 'type' => 'places_settings' ) );
		elseif ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && $_GET[ 'edit' ] === 'new' ):
			$form = new AdfoxlyFormController();
			$this->context['places_settings'] = $form->generate( array( 'type' => 'places_settings' ) );
		else:
			$this->context[ 'title' ]         = 'Places';
			$this->context[ 'places_header' ] = Timber::compile( 'group-header.twig', $this->context );

			$places = new AdfoxlyPlacesModel();
			$this->context['getCustomPlaces'] = $places->get_custom_places();
			$this->context['getPlaces'] = $places->get_places();
		endif;
	}

	/**
	 * remove place from get url
	 */
	public function remove() {
		if ( isset( $_GET[ 'remove' ] ) && ! empty( $_GET[ 'remove' ] ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ):
			$redirect = admin_url( 'admin.php?page=adfoxly-places' );
			if ( is_numeric( $_GET[ 'remove' ] ) ) {
				wp_delete_post( $_GET[ 'remove' ] );
				$statistics = new AdfoxlyStatisticsModel();
				$statistics->removeViews( htmlspecialchars( $_GET[ 'remove' ] ) );
			}
			echo '<script>window.location.href = "' . $redirect . '";</script>';
		endif;
	}

	/**
	 * @param $id
	 *
	 * @return bool|string
	 */
	public function renderPlace( $id ) {

		// verify specific custom places
		$this->getStickyTopPlaceID( $id );
		$this->getStickyBottomPlaceID( $id );
		$this->getStickyLeftPlaceID( $id );
		$this->getStickyRightPlaceID( $id );
		$this->getPopupPlaceID( $id );

		if ( $this->verifyPlaceID( $id ) === false ) {
			return false;
		}

		if ( $this->verifyPopupCookie( $this->adType, $this->getPopupPlaceID( $id ) ) === false ) {
			return false;
		}

		$this->validateAdInPlace( $id );

		$shuffleMeta = $this->meta;
		shuffle( $shuffleMeta );

		if ( isset( $this->meta ) && ! empty( $this->meta[ 0 ] ) ) {
			$currentBannerMeta = get_post_meta( $this->meta[ 0 ][ 'id' ] );
		}

		if ( ! empty( $currentBannerMeta ) ):
			$options = (object) array(
				'id'          => $id,
				'meta'        => $shuffleMeta,
				'place'       => $this->place,
				'place_type'  => $this->adType
			);

			$public  = new AdfoxlyPublicDisplayController();
			$this->statistics->saveView( $id );
            if( adfoxly_wa_fs()->can_use_premium_code__premium_only() ) {
                $this->statistics->saveSingleAdView($options->meta[0]['id']);
            }
			return $public->render( $options );
		endif;

		return false;
	}

	/**
	 * create context for admin url for twig files
	 */
	public function setContextAdminURL() {
		$this->context[ 'admin' ][ 'url' ] = admin_url();
	}

	/**
	 * create context for _nonce for twig files
	 */
	public function setContextNonce() {
		$this->context[ 'wp_create_nonce' ] = wp_create_nonce();
	}

	/**
	 * render dashboard places
	 * admin.php?page=adfoxly-places (...)
	 */
	public function renderDashboardPlaces() {
//		$places = new adfoxlyPlaces();

		$place = new AdfoxlyPlacesModel();
		$this->edit();
		$this->remove();

		$settings = get_option( 'adfoxly_settings' );
//		if ( isset( $settings[ 'adfoxly-navbar' ] ) && ! empty( $settings[ 'adfoxly-navbar' ] ) && $settings[ 'adfoxly-navbar' ] === 'true' ) {
			$navbar = new AdfoxlyAdminNavbarController();
			$navbar->render();
//		}

//		todo: ???
//		if ( isset( $_POST ) && ! empty( $_POST[ 'adfoxly-place-id' ] ) && is_numeric( $_POST[ 'adfoxly-place-id' ] ) ) {
//			if ( isset( $places ) && ! empty( $places ) ) {
//				$placeSettings = $places;
//			} else {
//				$placeSettings = array();
//			}
//
//			$placeSettings[ sanitize_text_field( $_POST[ 'adfoxly-place-id' ] ) ] = array(
//				'options' => array(
//					// 'adfoxly-adzone-width'       => sanitize_text_field( $_POST[ 'adfoxly-adzone-width' ] ),
//					// 'adfoxly-adzone-height'      => sanitize_text_field( $_POST[ 'adfoxly-adzone-height' ] ),
//					'adfoxly-adzone-is-rotate'      => sanitize_text_field( $_POST[ 'adfoxly-adzone-is-rotate' ] ),
//					'adfoxly-adzone-how-rotate'     => sanitize_text_field( $_POST[ 'adfoxly-adzone-how-rotate' ] ),
//					'adfoxly-adzone-rotate-time'    => sanitize_text_field( $_POST[ 'adfoxly-adzone-rotate-time' ] ),
//					'adfoxly-place-sticky-position' => sanitize_text_field( $_POST[ 'adfoxly-place-sticky-position' ] ),
//					'adfoxly-place-sticky-close'    => sanitize_text_field( $_POST[ 'adfoxly-place-sticky-close' ] )
//				)
//			);
//		}
//		todo: end ???

//		Timber::$locations = array( realpath( dirname( dirname( __DIR__ ) ) ) . '/includes/view' );

		$this->setContextAdminURL();
		$this->setContextNonce();

		if ( ! isset( $_GET[ 'edit' ] ) ):
		else:
			$this->context[ 'title' ]    = 'Add new place';
			$this->context['content_new_place'] = Timber::compile( 'group-header.twig', $this->context );
		endif;

		Timber::render( basename( __FILE__, '.php' ) . '.twig', $this->context );
	}
}
