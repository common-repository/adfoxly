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
 * @subpackage Adfoxly/includes/controller
 */
class AdfoxlyCampaignController {

	/**
	 * @var
	 */
	private $campaigns;
	/**
	 * @var
	 */
	private $campaign;
	/**
	 * @var array
	 */
	private $meta;
	/**
	 * @var null
	 */
	private $render;
	/**
	 * @var mixed
	 */
	private $settings;
	/**
	 * @var \StatisticsController
	 */
	private $statistics;

	/**
	 * CampaignController constructor.
	 */
	public function __construct() {
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
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getCampaign( $id ) {
		$campaign[ 'details' ] = get_post( $id );
		$campaign[ 'meta' ]    = get_post_meta( $id );

		return $campaign;
	}

	/**
	 * @param int $limit
	 *
	 * @return int[]|\WP_Post[]
	 */
	public function getCampaigns( $limit = - 1 ) {

		$args = array(
			'post_type'      => 'adfoxly_ad_campaign',
			'posts_per_page' => $limit
		);

		return get_posts( $args );
	}

	public function getCampaignsWithMetaForTwig( $limit = - 1 ) {

		$args = array(
			'post_type'      => 'adfoxly_ad_campaign',
			'posts_per_page' => $limit
		);

		$posts = get_posts( $args );
		$i = 0;
		$newPosts = array();
		foreach ($posts as $post) {
			$newPosts[$i][ 'details' ] = get_post( $post->ID );
			$newPosts[$i][ 'meta' ]    = get_post_meta( $post->ID );
			$newMeta = array();
			foreach ( $newPosts[$i][ 'meta' ] as $key => $value ) {
				$newKey = str_replace( '-', '_', $key );
				$newMeta[ $newKey ] = $value[0];
			}
			$newPosts[$i][ 'meta' ]    = $newMeta;
			$i++;
		}

		return $newPosts;
	}


	public function isEndingCampaigns() {
		foreach ( $this->getCampaignsWithMetaForTwig() as $item => $value ) {
			if (
				isset( $value[ 'meta' ][ 'adfoxly_ad_campaign_end' ] )
				&& ! empty( $value[ 'meta' ][ 'adfoxly_ad_campaign_end' ] )
			) {
				$earlier = new DateTime( $value[ 'meta' ][ 'adfoxly_ad_campaign_end' ] );
				$now     = new DateTime( date( 'Y-m-d' ) );

				$diff = $now->diff( $earlier )->format( "%a" );

				if ( $diff <= 7 ) {
					return $diff;
				}

			}
		}

	}

	/**
	 * @param $post
	 *
	 * @return int|\WP_Error
	 */
	public function insert( $post ) {
		$data = array(
			'post_title'  => sanitize_text_field( $post[ 'adfoxly-campaign-name' ] ),
			'post_status' => 'publish',
			'post_type'   => 'adfoxly_ad_campaign',
			'post_author' => get_current_user_id(),
		);

		$result = wp_insert_post( $data );

		return $result;
	}

	/**
	 * @param $post
	 *
	 * @return int|\WP_Error
	 */
	public function update( $post ) {

		$data = array(
			'ID'         => sanitize_text_field( $post[ 'adfoxly-campaign-id' ] ),
			'post_title' => sanitize_text_field( $post[ 'adfoxly-campaign-name' ] ),
		);

		$result = wp_update_post( $data );

		return $result;
	}

	/**
	 * @param $result
	 */
	public function insert_meta( $result ) {
		$post_id   = $result;

		if ( isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
			if ( isset( $_POST[ 'adfoxly-campaign-ads-list' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-ads-list' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_ads_list = array_map( 'intval', $_POST[ 'adfoxly-campaign-ads-list' ] );
				update_post_meta( $post_id, 'adfoxly-ad-campaign', $adfoxly_campaign_ads_list );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-ads-list' ] ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-ad-campaign' );
			}

			if ( isset( $_POST[ 'adfoxly-ad-options-maxviews' ] ) && ! empty( isset( $_POST[ 'adfoxly-ad-options-maxviews' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				update_post_meta( $post_id, 'adfoxly-ad-options-maxviews', sanitize_text_field( $_POST[ 'adfoxly-ad-options-maxviews' ] ) );
			}

			if ( isset( $_POST[ 'adfoxly-ad-options-maxclicks' ] ) && ! empty( isset( $_POST[ 'adfoxly-ad-options-maxclicks' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				update_post_meta( $post_id, 'adfoxly-ad-options-maxclicks', sanitize_text_field( $_POST[ 'adfoxly-ad-options-maxclicks' ] ) );
			}

			if ( isset( $_POST[ 'adfoxly-ad-campaign-start' ] ) && ! empty( isset( $_POST[ 'adfoxly-ad-campaign-start' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				update_post_meta( $post_id, 'adfoxly-ad-campaign-start', sanitize_text_field( $_POST[ 'adfoxly-ad-campaign-start' ] ) );
			}

			if ( isset( $_POST[ 'adfoxly-ad-campaign-end' ] ) && ! empty( isset( $_POST[ 'adfoxly-ad-campaign-end' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				update_post_meta( $post_id, 'adfoxly-ad-campaign-end', sanitize_text_field( $_POST[ 'adfoxly-ad-campaign-end' ] ) );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-excluded-categories' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-excluded-categories' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_excluded_categories = array_map( 'strval', $_POST[ 'adfoxly-campaign-excluded-categories' ] );
				update_post_meta( $post_id, 'adfoxly-campaign-excluded-categories', $adfoxly_campaign_excluded_categories );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-excluded-categories' ] ) || empty( $_POST[ 'adfoxly-campaign-excluded-categories' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-excluded-categories' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-allowed-categories' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-allowed-categories' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_allowed_categories = array_map( 'strval', $_POST[ 'adfoxly-campaign-allowed-categories' ] );
				update_post_meta( $post_id, 'adfoxly-campaign-allowed-categories', $adfoxly_campaign_allowed_categories );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-allowed-categories' ] ) || empty( $_POST[ 'adfoxly-campaign-allowed-categories' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-allowed-categories' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-excluded-tags' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-excluded-tags' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_excluded_tags = array_map( 'strval', $_POST[ 'adfoxly-campaign-excluded-tags' ] );
				update_post_meta( $post_id, 'adfoxly-campaign-excluded-tags', $adfoxly_campaign_excluded_tags );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-excluded-tags' ] ) || empty( $_POST[ 'adfoxly-campaign-excluded-tags' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-excluded-tags' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-allowed-tags' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-allowed-tags' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_allowed_tags = array_map( 'strval', $_POST[ 'adfoxly-campaign-allowed-tags' ] );
				update_post_meta( $post_id, 'adfoxly-campaign-allowed-tags', $adfoxly_campaign_allowed_tags );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-allowed-tags' ] ) || empty( $_POST[ 'adfoxly-campaign-allowed-tags' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-allowed-tags' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-excluded-post-or-page' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-excluded-post-or-page' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_excluded_tags = array_map( 'intval', $_POST[ 'adfoxly-campaign-excluded-post-or-page' ] );
				update_post_meta( $post_id, 'adfoxly_campaign_excluded_post_or_page', $adfoxly_campaign_excluded_tags );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-excluded-post-or-page' ] ) || empty( $_POST[ 'adfoxly-campaign-excluded-post-or-page' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly_campaign_excluded_post_or_page' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-allowed-post-or-page' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-allowed-post-or-page' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_allowed_post_or_page = array_map( 'intval', $_POST[ 'adfoxly-campaign-allowed-post-or-page' ] );
				update_post_meta( $post_id, 'adfoxly_campaign_allowed_post_or_page', $adfoxly_campaign_allowed_post_or_page );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-allowed-post-or-page' ] ) || empty( $_POST[ 'adfoxly-campaign-allowed-post-or-page' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly_campaign_allowed_post_or_page' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-excluded-countries' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-excluded-countries' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_excluded_countries = array_map( 'strval', $_POST[ 'adfoxly-campaign-excluded-countries' ] );
				update_post_meta( $post_id, 'adfoxly-campaign-excluded-countries', $adfoxly_campaign_excluded_countries );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-excluded-countries' ] ) || empty( $_POST[ 'adfoxly-campaign-excluded-countries' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-excluded-countries' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-allowed-countries' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-allowed-countries' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_allowed_countries = array_map( 'strval', $_POST[ 'adfoxly-campaign-allowed-countries' ] );
				update_post_meta( $post_id, 'adfoxly-campaign-allowed-countries', $adfoxly_campaign_allowed_countries );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-allowed-countries' ] ) || empty( $_POST[ 'adfoxly-campaign-allowed-countries' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-allowed-countries' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-excluded-region' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-excluded-region' ] ) ) && $_POST[ 'adfoxly-campaign-excluded-region' ] !== '' && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_excluded_region_array = explode(",", $_POST[ 'adfoxly-campaign-excluded-region' ] );
				$adfoxly_campaign_excluded_region = array_map( 'strval', $adfoxly_campaign_excluded_region_array );
				update_post_meta( $post_id, 'adfoxly-campaign-excluded-region', $adfoxly_campaign_excluded_region );
			} else if ( ( ! isset( $_POST[ 'adfoxly-campaign-excluded-region' ] ) || empty( $_POST[ 'adfoxly-campaign-excluded-region' ] ) || $_POST[ 'adfoxly-campaign-excluded-region' ] === '' ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-excluded-region' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-allowed-region' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-allowed-region' ] ) ) && $_POST[ 'adfoxly-campaign-allowed-region' ] !== '' && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_allowed_region_array = explode(",", $_POST[ 'adfoxly-campaign-allowed-region' ] );
				$adfoxly_campaign_allowed_region = array_map( 'strval', $adfoxly_campaign_allowed_region_array );
				update_post_meta( $post_id, 'adfoxly-campaign-allowed-region', $adfoxly_campaign_allowed_region );
			} else if ( ( ! isset( $_POST[ 'adfoxly-campaign-allowed-region' ] ) || empty( $_POST[ 'adfoxly-campaign-allowed-region' ] ) || $_POST[ 'adfoxly-campaign-excluded-region' ] === '' ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-allowed-region' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-days' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-days' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_days = array_map( 'strval', $_POST[ 'adfoxly-campaign-days' ] );
				update_post_meta( $post_id, 'adfoxly-campaign-days', $adfoxly_campaign_days );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-days' ] ) || empty( $_POST[ 'adfoxly-campaign-days' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-days' );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-specific-hours' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-specific-hours' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				$adfoxly_campaign_specific_hours = array_map( 'strval', $_POST[ 'adfoxly-campaign-specific-hours' ] );
				update_post_meta( $post_id, 'adfoxly-campaign-specific-hours', $adfoxly_campaign_specific_hours );
			} else if ( ! isset( $_POST[ 'adfoxly-campaign-specific-hours' ] ) || empty( $_POST[ 'adfoxly-campaign-specific-hours' ] ) ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-specific-hours' );
			}

			$days = array(
				'monday'    => 'Monday',
				'tuesday'   => 'Tuesday',
				'wednesday' => 'Wednesday',
				'thursday'  => 'Thursday',
				'friday'    => 'Friday',
				'saturday'  => 'Saturday',
				'sunday'    => 'Sunday'
			);

			foreach ( $days as $key => $day ) {
				delete_post_meta( $post_id, 'adfoxly-campaign-specific-hour-start-' . $key );
				delete_post_meta( $post_id, 'adfoxly-campaign-specific-hour-end-' . $key );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-specific-hours' ] ) && ! empty( $_POST[ 'adfoxly-campaign-specific-hours' ] ) ) {
				foreach ( $_POST[ 'adfoxly-campaign-specific-hours' ] as $day ) {
					$start = $_POST[ 'adfoxly-campaign-specific-hour-start-' . $day ];
					$end = $_POST[ 'adfoxly-campaign-specific-hour-end-' . $day ];

					if ( isset( $start ) && isset( $end ) && ! empty( $start ) && ! empty( $end ) ) {
						update_post_meta( $post_id, 'adfoxly-campaign-specific-hour-start-' . $day , $start );
						update_post_meta( $post_id, 'adfoxly-campaign-specific-hour-end-' . $day , $end );
					}
				}
			} else {
				foreach ( $days as $key => $day ) {
					delete_post_meta( $post_id, 'adfoxly-campaign-specific-hour-start-' . $key );
					delete_post_meta( $post_id, 'adfoxly-campaign-specific-hour-end-' . $key );
				}
			}

			if ( isset( $_POST[ 'adfoxly-campaign-maxviews-user' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-maxviews-user' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				update_post_meta( $post_id, 'adfoxly-campaign-maxviews-user', sanitize_text_field( $_POST[ 'adfoxly-campaign-maxviews-user' ] ) );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-show-admins' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-show-admins' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				update_post_meta( $post_id, 'adfoxly-campaign-show-admins', sanitize_text_field( $_POST[ 'adfoxly-campaign-show-admins' ] ) );
			}

			if ( isset( $_POST[ 'adfoxly-campaign-devices' ] ) && ! empty( isset( $_POST[ 'adfoxly-campaign-devices' ] ) ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {
				update_post_meta( $post_id, 'adfoxly-campaign-devices', sanitize_text_field( $_POST[ 'adfoxly-campaign-devices' ] ) );
			}

		}
	}

	public function renderDashboardCampaigns() {
		$campaign = new AdfoxlyCampaignController();
		$settings = get_option( 'adfoxly_settings' );
//		if ( isset( $settings[ 'adfoxly-navbar' ] ) && ! empty( $settings[ 'adfoxly-navbar' ] ) && $settings[ 'adfoxly-navbar' ] === 'true' ) {
			$navbar = new AdfoxlyAdminNavbarController();
			$navbar->render();
//		}

		if ( isset( $_POST ) && ! empty( $_POST ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {

			if ( isset( $_GET[ 'edit' ] ) && $_GET[ 'edit' ] === 'new' ) {
				$result = $campaign->insert( $_POST );
				$popup_content = "created";
			} else {
				$result = $campaign->update( $_POST );
				$popup_content = "edited";
			}

			if ( isset( $result ) && ! is_wp_error( $result ) ) {
				$campaign->insert_meta( $result );

				$redirect = admin_url( 'admin.php?page=adfoxly-campaigns' );
				echo '<script>window.location.href = "' . $redirect . '";</script>';
			}
		}

		if ( isset( $_GET[ 'remove' ] ) && ! empty( $_GET[ 'remove' ] ) ):

			wp_delete_post( $_GET[ 'remove' ] );

		endif;

		$campaigns = new AdfoxlyCampaignController();
		$banner    = new AdfoxlyBannerModel();
		$form    = new AdfoxlyFormController();
//??????

		if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ):
			$context[ 'title' ]    = 'Edit campaign';
			$context['campaigns_header'] = Timber::compile( 'group-header.twig', $context );
		elseif ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && $_GET[ 'edit' ] === 'new' ):

		else:
			$context[ 'title' ]    = 'Campaigns list';
			$context['campaigns_header'] = Timber::compile( 'group-header.twig', $context );
		endif;

		$context[ 'getCampaigns' ]   = $campaigns->getCampaignsWithMetaForTwig();
		$context[ 'endingCampaign' ] = $campaigns->isEndingCampaigns();
		$context[ 'getBanners' ]     = $banner->getBannersWithMetaForTwig();
		if ( isset( $_GET ) && isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) ) {
			$context[ 'edit' ] = $_GET[ 'edit' ];
		}
		$context[ 'campaigns' ]          = get_option( 'adfoxly_campaigns' );
		$context[ 'campaigns_settings' ] = $form->generate( array( 'type' => 'campaigns_settings' ) );

		if ( isset( $_GET ) && isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && $_GET[ 'edit' ] !== 'new' ):
			$context['g_id'] = $_GET[ 'edit' ];
		else:
			$context['g_id'] = 'new';
		endif;

		$context[ 'wp_create_nonce' ] = wp_create_nonce();

		Timber::$locations = array( realpath( dirname( dirname( __DIR__ ) ) ) . '/admin/partials/views' );
		Timber::render( 'adfoxly-admin-campaigns.twig', $context );

		?>

<?php
	}
}

