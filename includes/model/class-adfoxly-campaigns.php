<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class AdfoxlyCampaignModel
 * @see ?page=adfoxly-campaigns
 */
class AdfoxlyCampaignModel {

	public $meta_fields = array(
	);

	function __construct( $page = null ) {

		if ( $page === 'adCampaign' ) {
			$this->meta_fields = array(
				array(
					'label'      => 'Campaign exist or would you like create a new one?',
					'class'      => 'form-control',
					'id'         => 'adfoxly-campaign-exists',
					'default'    => 'no-campaign',
					'type'       => 'radio',
					'wrapper_id' => 'adfoxly-campaign-exists-wrapper',
					'options'    => array(
						'no-campaign' => 'The banner doesn\'t belong to any capaign. This is single ad.',
						'exists'      => 'Campaign already exists. Please let me choose.',
						'no-exists'   => 'I don\'t have campaign for this banner. But it will be part of a new.',
					),
				),
				array(
					'label'                   => 'Campaign name',
					'id'                      => 'adfoxly-campaign-name',
					'group'                   => 'adfoxly-campaign-new-campaign-wrapper',
					'wrapper_class'           => 'adfoxly-campaign-name',
					'adfoxly_validation_type' => 'invalid-feedback',
					'adfoxly_validation_text' => 'Campaign with this same name already exists.',
					'type'                    => 'text',
					'class'                   => 'form-control new-campaign'
				),
				array(
					'label'      => 'Devices',
					'class'      => 'form-control new-campaign',
					'id'         => 'adfoxly-campaign-devices',
					'wrapper_id' => 'adfoxly-campaign-devices-wrapper',
					'group'      => 'adfoxly-campaign-new-campaign-wrapper',
					'default'    => 'all',
					'type'       => 'radio',
					'options'    => array(
						'all'           => 'All devices',
						'only-mobile'   => 'Only Mobile',
						'only-desktop ' => 'Only Desktop',
					),
				),
				array(
					'label' => 'Post and Pages Categories',
					'id'    => 'adfoxly-ad-campaign-post-pages-categories',
					'group' => 'adfoxly-campaign-new-campaign-wrapper',
					'type'  => 'tab',
					'class' => 'form-control new-campaign'
				),
				array(
					'label' => 'Post and Pages Tags',
					'id'    => 'adfoxly-ad-campaign-post-pages-tags',
					'group' => 'adfoxly-campaign-new-campaign-wrapper',
					'type'  => 'tab',
					'class' => 'form-control new-campaign'
				),
				array(
					'label' => 'Posts or Pages',
					'id'    => 'adfoxly-ad-campaign-post-or-pages',
					'group' => 'adfoxly-campaign-new-campaign-wrapper',
					'type'  => 'tab',
					'class' => 'form-control new-campaign'
				),
				array(
					'label'      => 'Max ad views',
					'id'         => 'adfoxly-ad-options-maxviews',
					'group'      => 'adfoxly-campaign-new-campaign-wrapper',
					'type'       => 'number',
					'min'        => '0',
					'help-block' => 'If "0", ad doesnt have set maximal views, after which will be hided. Ad will be always visible until you manually remove it, or disable',
					'class'      => 'form-control new-campaign'
				),
				array(
					'label'      => 'Max ad clicks',
					'id'         => 'adfoxly-ad-options-maxclicks',
					'group'      => 'adfoxly-campaign-new-campaign-wrapper',
					'type'       => 'number',
					'min'        => '0',
					'help-block' => 'If "0", ad doesnt have set maximal clicks, after which will be hided. Ad will be always visible until you manually remove it, or disable',
					'class'      => 'form-control new-campaign'
				),
				array(
					'label'        => 'Campaign start',
					'id'           => 'adfoxly-ad-campaign-start',
					'group'        => 'adfoxly-campaign-new-campaign-wrapper',
					'type'         => 'text',
					'class'        => 'form-control new-campaign adfoxlydatepicker-campaign-start',
					'autocomplete' => 'off'
				),
				array(
					'label'        => 'Campaign ends',
					'id'           => 'adfoxly-ad-campaign-end',
					'group'        => 'adfoxly-campaign-new-campaign-wrapper',
					'type'         => 'text',
					'class'        => 'form-control new-campaign adfoxlydatepicker-campaign-end',
					'autocomplete' => 'off'
				),
				array(
					'label' => 'Countries / Region',
					'id'    => 'adfoxly-ad-campaign-countries',
					'group' => 'adfoxly-campaign-new-campaign-wrapper',
					'type'  => 'tab',
					'class' => 'form-control new-campaign'
				),
				array(
					'label' => 'Days and Hours',
					'id'    => 'adfoxly-ad-campaign-days-hours',
					'group' => 'adfoxly-campaign-new-campaign-wrapper',
					'type'  => 'campaign_days_and_hours',
					'class' => 'form-control new-campaign'
				),
				array(
					'label'      => 'Max views for one user per ad in campaign',
					'id'         => 'adfoxly-campaign-maxviews-user',
					'group'      => 'adfoxly-campaign-new-campaign-wrapper',
					'type'       => 'number',
					'min'        => '0',
					'help-block' => 'If "0", ad doesnt have set maximal views, after which will be hided. Ad will be always visible until you manually remove it, or disable',
					'class'      => 'form-control new-campaign',
					'is_premium' => true
				),
				array(
					'label'         => 'Only for test',
					'class'         => 'form-control',
					'id'            => 'adfoxly-campaign-show-admins',
					'wrapper_id'    => 'adfoxly-campaign-show-admins-wrapper',
					'question-mark' => '<span data-title=\'How works "Only for test"?\' data-content=\'Click "Yes", if you add your advertisement only for test. Your website visitors will not see that advert.\'  class="question-mark">(?)</span>',
					'help-block'    => 'Is this ad is only for testing purpose? It should be visible only for logged administrators?',
					'default'       => 'all',
					'type'          => 'radio',
					'options'       => array(
						'all'    => 'No. Show that campaign to all users',
						'admins' => 'Yes. Visible only for admins',
					),
				),
				array(
					'label'   => 'Select campaign',
					'class'   => 'form-control',
					'id'      => 'adfoxly-wizard-campaign-list',
					'group'   => 'adfoxly-campaign-choose-campaign-wrapper',
					'default' => '',
					'type'    => 'checkbox',
				),
			);
		} else {
			$this->meta_fields = array(
				array(
					'label'                   => 'Name',
					'class'                   => 'form-control',
					'id'                      => 'adfoxly-campaign-name',
					'wrapper_class'           => 'adfoxly-campaign-name',
					'adfoxly_validation_type' => 'invalid-feedback',
					'adfoxly_validation_text' => 'Campaign with this same name already exists.',
					'default'                 => '',
					'type'                    => 'text',
				),
				array(
					'label'      => 'Devices',
					'class'      => 'form-control',
					'id'         => 'adfoxly-campaign-devices',
					'wrapper_id' => 'adfoxly-campaign-devices-wrapper',
					'group'      => 'adfoxly-campaign-new-campaign-wrapper',
					'default'    => 'all',
					'type'       => 'radio',
					'options'    => array(
						'all'           => 'All devices',
						'only-mobile'   => 'Only Mobile',
						'only-desktop ' => 'Only Desktop',
					),
				),
				array(
					'label' => 'Post and Pages Categories',
					'id'    => 'adfoxly-ad-campaign-post-pages-categories',
					'group' => 'adfoxly-campaign-new-campaign-wrapper',
					'type'  => 'tab',
					'class' => 'form-control'
				),
				array(
					'label' => 'Post and Pages Tags',
					'id'    => 'adfoxly-ad-campaign-post-pages-tags',
					'group' => 'adfoxly-campaign-new-campaign-wrapper',
					'type'  => 'tab',
					'class' => 'form-control'
				),
				array(
					'label' => 'Posts or Pages',
					'id'    => 'adfoxly-ad-campaign-post-or-pages',
					'group' => 'adfoxly-campaign-new-campaign-wrapper',
					'type'  => 'tab',
					'class' => 'form-control'
				),
				array(
					'label'      => 'Max ad views',
					'id'         => 'adfoxly-ad-options-maxviews',
					'type'       => 'number',
					'min'        => '0',
					'help-block' => 'If "0", ad doesnt have set maximal views, after which will be hided. Ad will be always visible until you manually remove it, or disable',
					'class'      => 'form-control'
				),
				array(
					'label'      => 'Max ad clicks',
					'id'         => 'adfoxly-ad-options-maxclicks',
					'type'       => 'number',
					'min'        => '0',
					'help-block' => 'If "0", ad doesnt have set maximal clicks, after which will be hided. Ad will be always visible until you manually remove it, or disable',
					'class'      => 'form-control'
				),
				array(
					'label'        => 'Campaign start',
					'id'           => 'adfoxly-ad-campaign-start',
					'type'         => 'text',
					'class'        => 'form-control adfoxlydatepicker-campaign-start',
					'autocomplete' => 'off'
				),
				array(
					'label'        => 'Campaign ends',
					'id'           => 'adfoxly-ad-campaign-end',
					'type'         => 'text',
					'class'        => 'form-control adfoxlydatepicker-campaign-end',
					'autocomplete' => 'off'
				),
				array(
					'label' => 'Countries / Region',
					'id'    => 'adfoxly-ad-campaign-countries',
					'type'  => 'tab',
					'class' => 'form-control'
				),
				array(
					'label' => 'Days and Hours',
					'id'    => 'adfoxly-ad-campaign-days-hours',
					'type'  => 'campaign_days_and_hours',
					'class' => 'form-control'
				),
				array(
					'label'      => 'Max views for one user per ad in campaign',
					'id'         => 'adfoxly-campaign-maxviews-user',
					'type'       => 'number',
					'min'        => '0',
					'help-block' => 'If "0", ad doesnt have set maximal views, after which will be hided. Ad will be always visible until you manually remove it, or disable',
					'class'      => 'form-control',
					'is_premium' => true
				),
				array(
					'label'         => 'Only for test',
					'class'         => 'form-control',
					'id'            => 'adfoxly-campaign-show-admins',
					'wrapper_id'    => 'adfoxly-campaign-show-admins-wrapper',
					'question-mark' => '(?)',
					'help-block'    => 'Is this ad is only for testing purpose? It should be visible only for logged administrators?',
					'default'       => 'all',
					'type'          => 'radio',
					'options'       => array(
						'all'    => 'No. Show that campaign to all users',
						'admins' => 'Yes. Visible only for admins',
					),
				),
				array(
					'label'   => 'Included Ads',
					'class'   => 'form-control',
					'id'      => 'adfoxly-campaign-ads-list',
					'default' => '',
					'type'    => 'checkbox',
				),
			);
		}

		$this->edit( $page );
	}

	function getCampaignsIDs() {
		$campaignsAdsArgs = array(
			'post_type'      => 'adfoxly_ad_campaign',
			'posts_per_page' => -1,
			'fields'          => 'ids'
		);

		return get_posts( $campaignsAdsArgs );
	}

	function insert( $post, $result ) {

		if ( $post['adfoxly-campaign-exists'] === 'no-exists' ) {
			$campaigns = new AdfoxlyCampaignController();
			$campaignResult    = $campaigns->insert( $post );
			if ( isset( $campaignResult ) && ! is_wp_error( $campaignResult ) ) {
				$campaigns->insert_meta( $campaignResult );
				update_post_meta( $campaignResult, 'adfoxly-ad-campaign', array( $result ) );
			}
		} else if ( $post['adfoxly-campaign-exists'] === 'exists' ) {
			/*
			 * todo: check below, because is fixed
			 * for now in afoxly-banners&edit=XXX user cannot save unselected campaign. saves only selected.
			 * there is no such mechanism to remove if is unselected
			 **/

			if ( isset( $_GET ) && isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) {
				$g_id     = $_GET[ 'edit' ];
				$g_id_int = intval( $g_id );
			} else if ( isset( $_GET ) && ! isset( $_GET[ 'edit' ] ) ) {
				$g_id     = $result;
				$g_id_int = intval( $g_id );
			}


			$campaignsAds = $this->getCampaignsIDs();

			if ( isset( $campaignsAds ) && ! empty( $campaignsAds ) ) {
				foreach ( $campaignsAds as $campaign ):
					$campaign = intval( $campaign );
					$arrayOfAdsInCampaign = get_post_meta( $campaign, 'adfoxly-ad-campaign', true );
					if ( in_array( $g_id_int, $arrayOfAdsInCampaign ) ) {
						// banner is in the campaign db
						if ( isset( $post[ 'adfoxly-wizard-campaign-list' ] ) && ! empty( $post[ 'adfoxly-wizard-campaign-list' ] ) ) {
							// list is not empty. check and uncheck only this item which need be checked or unchecked
							foreach ( $arrayOfAdsInCampaign as $key => $value ):
								if ( $value === $g_id_int ):
									unset( $arrayOfAdsInCampaign[ $key ] );
								endif;
							endforeach;
							update_post_meta( $campaign, 'adfoxly-ad-campaign', $arrayOfAdsInCampaign );
						} else {
							// list is empty. remove from every meta
							foreach ( $arrayOfAdsInCampaign as $key => $value ):
								if ( $value === $g_id_int ):
									unset( $arrayOfAdsInCampaign[ $key ] );
								endif;
							endforeach;
							update_post_meta( $campaign, 'adfoxly-ad-campaign', $arrayOfAdsInCampaign );
						}
					}
				endforeach;
			}

			if ( ! empty( $post[ 'adfoxly-wizard-campaign-list' ] ) ) {
				foreach ( $post[ 'adfoxly-wizard-campaign-list' ] as $item ):
					$campaignAdsList = get_post_meta( $item, 'adfoxly-ad-campaign', true );
					// if campaign is not empty
					if ( isset( $campaignAdsList ) && ! empty( $campaignAdsList ) ) {
						// if banner is not in the campaign - add
//						if ( ! in_array( $post_id, $campaignAdsList ) ) {
						if ( ! in_array( $g_id_int, $campaignAdsList ) ) {
//							array_push( $campaignAdsList, $post_id );
							array_push( $campaignAdsList, $g_id_int );
							update_post_meta( $item, 'adfoxly-ad-campaign', $campaignAdsList );
						}
					} else {
						// if campaign is empty
//						$campaignAdsList = array( $post_id ); // todo here is adding int, in other places string
						$campaignAdsList = array( $g_id_int ); // todo here is adding int, in other places string
						update_post_meta( $item, 'adfoxly-ad-campaign', $campaignAdsList );
					}
				endforeach;
			}
		}
	}

	function edit( $page = null ) {
		if ( $page === 'adCampaign' ) {
			if ( isset( $_GET[ 'edit' ] ) ) {

				$campaign = new AdfoxlyCampaignController();

				if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) ) {
					$g_id     = $_GET[ 'edit' ];
					$g_id_int = intval( $g_id );

					$campaignsAdsArgs = array(
						'meta_query'     => array(
							array(
								'key'     => 'adfoxly-ad-campaign',
								'value'   => $g_id_int,
								'compare' => 'LIKE'
							)
						),
						'post_type'      => 'adfoxly_ad_campaign',
						'posts_per_page' => - 1
					);

					$campaignsAds = get_posts( $campaignsAdsArgs );
				}

				if ( isset( $campaignsAds ) && ! empty( $campaignsAds ) ) {
					$this->meta_fields[ 0 ][ 'default' ] = 'exists';
				}

				if ( isset( $campaign->getCampaign( $g_id )[ 'details' ]->post_title ) && ! empty( $campaign->getCampaign( $g_id )[ 'details' ]->post_title ) ) {
					$this->meta_fields[ 1 ][ 'value' ] = $campaign->getCampaign( $g_id )[ 'details' ]->post_title;
				}

				$ad_campaign_maxviews      = get_post_meta( $g_id, 'adfoxly-ad-options-maxviews', true );
				$ad_campaign_maxclicks     = get_post_meta( $g_id, 'adfoxly-ad-options-maxclicks', true );
				$ad_campaign_start         = get_post_meta( $g_id, 'adfoxly-ad-campaign-start', true );
				$ad_campaign_end           = get_post_meta( $g_id, 'adfoxly-ad-campaign-end', true );
				$adfoxlyCampaignOnlyAdmins = get_post_meta( $g_id, 'adfoxly-campaign-show-admins', true );
				$adfoxlyCampaignDevices    = get_post_meta( $g_id, 'adfoxly-campaign-devices', true );

				if ( isset( $adfoxlyCampaignDevices ) && ! empty( $adfoxlyCampaignDevices ) ) {
					$this->meta_fields[ 2 ][ 'value' ] = $adfoxlyCampaignDevices;
				}

				if ( isset( $ad_campaign_maxviews ) && ! empty( $ad_campaign_maxviews ) ) {
					$this->meta_fields[ 5 ][ 'value' ] = $ad_campaign_maxviews;
				}

				if ( isset( $ad_campaign_maxclicks ) && ! empty( $ad_campaign_maxclicks ) ) {
					$this->meta_fields[ 6 ][ 'value' ] = $ad_campaign_maxclicks;
				}

				if ( isset( $ad_campaign_start ) && ! empty( $ad_campaign_start ) ) {
					$this->meta_fields[ 7 ][ 'value' ] = $ad_campaign_start;
				}

				if ( isset( $ad_campaign_end ) && ! empty( $ad_campaign_end ) ) {
					$this->meta_fields[ 8 ][ 'value' ] = $ad_campaign_end;
				}

				if ( isset( $adfoxlyCampaignMaxviewsUser ) && ! empty( $adfoxlyCampaignMaxviewsUser ) ) {
					$this->meta_fields[ 11 ][ 'value' ] = $adfoxlyCampaignMaxviewsUser;
				}

				if ( isset( $adfoxlyCampaignOnlyAdmins ) && ! empty( $adfoxlyCampaignOnlyAdmins ) ) {
					$this->meta_fields[ 12 ][ 'value' ] = $adfoxlyCampaignOnlyAdmins;
				}

			}
		} else {
			if ( isset( $_GET[ 'edit' ] ) ) {
				if ( $_GET[ 'edit' ] !== 'new' ) {
					$campaign = new AdfoxlyCampaignController();
					$g_id     = $_GET[ 'edit' ];

					if ( isset( $campaign->getCampaign( $g_id )[ 'details' ]->post_title ) && ! empty( $campaign->getCampaign( $g_id )[ 'details' ]->post_title ) ) {
						$this->meta_fields[ 0 ][ 'value' ] = $campaign->getCampaign( $g_id )[ 'details' ]->post_title;
					}

					$ad_campaign_maxviews        = get_post_meta( $g_id, 'adfoxly-ad-options-maxviews', true );
					$ad_campaign_maxclicks       = get_post_meta( $g_id, 'adfoxly-ad-options-maxclicks', true );
					$ad_campaign_start           = get_post_meta( $g_id, 'adfoxly-ad-campaign-start', true );
					$ad_campaign_end             = get_post_meta( $g_id, 'adfoxly-ad-campaign-end', true );
					$adfoxlyCampaignMaxviewsUser = get_post_meta( $g_id, 'adfoxly-campaign-maxviews-user', true );
					$adfoxlyCampaignOnlyAdmins   = get_post_meta( $g_id, 'adfoxly-campaign-show-admins', true );
					$adfoxlyCampaignDevices      = get_post_meta( $g_id, 'adfoxly-campaign-devices', true );

					if ( isset( $adfoxlyCampaignDevices ) && ! empty( $adfoxlyCampaignDevices ) ) {
						$this->meta_fields[ 1 ][ 'value' ] = $adfoxlyCampaignDevices;
					}

					if ( isset( $ad_campaign_maxviews ) && ! empty( $ad_campaign_maxviews ) ) {
						$this->meta_fields[ 5 ][ 'value' ] = $ad_campaign_maxviews;
					}

					if ( isset( $ad_campaign_maxclicks ) && ! empty( $ad_campaign_maxclicks ) ) {
						$this->meta_fields[ 6 ][ 'value' ] = $ad_campaign_maxclicks;
					}

					if ( isset( $ad_campaign_start ) && ! empty( $ad_campaign_start ) ) {
						$this->meta_fields[ 7 ][ 'value' ] = $ad_campaign_start;
					}

					if ( isset( $ad_campaign_end ) && ! empty( $ad_campaign_end ) ) {
						$this->meta_fields[ 8 ][ 'value' ] = $ad_campaign_end;
					}

					if ( isset( $adfoxlyCampaignMaxviewsUser ) && ! empty( $adfoxlyCampaignMaxviewsUser ) ) {
						$this->meta_fields[ 11 ][ 'value' ] = $adfoxlyCampaignMaxviewsUser;
					}

					if ( isset( $adfoxlyCampaignOnlyAdmins ) && ! empty( $adfoxlyCampaignOnlyAdmins ) ) {
						$this->meta_fields[ 12 ][ 'value' ] = $adfoxlyCampaignOnlyAdmins;
					}
				}
			}
		}
	}
}
