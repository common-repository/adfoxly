<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class wizardCheckbox {
	public function render( $output, $meta_field ) {
		if ( isset( $meta_field[ 'group' ] ) && ! empty( $meta_field[ 'group' ] ) ) {
			$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . ' ad-format-group-' . $meta_field[ 'group' ];
		} else {
			$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ];
		}

		if ( isset( $meta_field[ 'wrapper_class' ] ) && ! empty( $meta_field[ 'wrapper_class' ] ) ) {
			$output .= ' ' . $meta_field[ 'wrapper_class' ] ;
		}

		$output .= '"';

		if ( isset( $meta_field[ 'wrapper_id' ] ) && ! empty( $meta_field[ 'wrapper_id' ] ) ) {
			$output .= ' id="' . $meta_field[ 'wrapper_id' ] . '" ';
		}

		if ( isset( $meta_field[ 'show' ] ) && $meta_field[ 'show' ] === false ) {
			$output .= ' style="display: none;" ';
		}
		$output .= '>';

		$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ] . '</label>';
		$output .= '<div class="col-sm-9 col-form-label">';

		if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
			$output .= '<div id="alert-' . $meta_field[ "id" ] . '"></div>';
		endif;


		// todo remove adfoxly-place-ads-list - DEPRICATED
		if ( $meta_field[ 'id' ] === 'adfoxly-group-ads-list' || $meta_field[ 'id' ] === 'adfoxly-campaign-ads-list' || $meta_field[ 'id' ] === 'adfoxly-wizard-campaign-list' || $meta_field[ 'id' ] === 'adfoxly-place-ads-list' ) {
			if ( $meta_field[ 'id' ] === 'adfoxly-group-ads-list' ) {

				$bannerArgs = array(
					'meta_query'     => array(
						array(
							'key'     => 'adfoxly-adzone-place',
							'value'   => sprintf( ':"%s";', 7 ),
							'compare' => 'LIKE'
						),
						array(
							'relation' => 'OR',
							array(
								array(
									'key'     => 'adfoxly-ad-campaign-start',
									'compare' => 'NOT EXISTS'
								),
								array(
									'key'     => 'adfoxly-ad-campaign-end',
									'compare' => 'NOT EXISTS'
								)
							),
							array(
								array(
									'key'     => 'adfoxly-ad-campaign-start',
									'value'   => date( "Y-m-d" ),
									'compare' => '<=',
									'type'    => 'DATE'
								),
								array(
									'key'     => 'adfoxly-ad-campaign-end',
									'value'   => date( "Y-m-d" ),
									'compare' => '>=',
									'type'    => 'DATE'
								),
							)
						)
					),
					'post_type'      => 'adfoxly_banners',
					'posts_per_page' => - 1
				);


				$banners = get_posts( $bannerArgs );

				if ( isset( $_GET[ 'edit' ] ) ) {
					$groups = get_post_meta( $_GET[ 'edit' ], 'adfoxly-ad-group', true );
				}

			} else if ( $meta_field[ 'id' ] === 'adfoxly-campaign-ads-list' ) {
				$bannerArgs = array(
					'meta_query'     => array(
						array(
							'relation' => 'OR',
							array(
								array(
									'key'     => 'adfoxly-ad-campaign-start',
									'compare' => 'NOT EXISTS'
								),
								array(
									'key'     => 'adfoxly-ad-campaign-end',
									'compare' => 'NOT EXISTS'
								)
							),
							array(
								array(
									'key'     => 'adfoxly-ad-campaign-start',
									'value'   => date( "Y-m-d" ),
									'compare' => '<=',
									'type'    => 'DATE'
								),
								array(
									'key'     => 'adfoxly-ad-campaign-end',
									'value'   => date( "Y-m-d" ),
									'compare' => '>=',
									'type'    => 'DATE'
								),
							)
						)
					),
					'post_type'      => 'adfoxly_banners',
					'posts_per_page' => - 1
				);


				$banners = get_posts( $bannerArgs );

				if ( isset( $_GET[ 'edit' ] ) ) {
					$g_id     = $_GET[ 'edit' ];
					$g_id_int = intval( $g_id );
					$selectedAdsConnectedToPlace = get_post_meta( $g_id_int, 'adfoxly-ad-campaign', true );
				}

			} else if ( $meta_field[ 'id' ] === 'adfoxly-wizard-campaign-list' ) {

				$bannerArgs = array(
					'meta_query'     => array(
						array(
							'relation' => 'OR',
							array(
								array(
									'key'     => 'adfoxly-ad-campaign-start',
									'compare' => 'NOT EXISTS'
								),
								array(
									'key'     => 'adfoxly-ad-campaign-end',
									'compare' => 'NOT EXISTS'
								)
							),
							array(
								array(
									'key'     => 'adfoxly-ad-campaign-start',
									'value'   => date( "Y-m-d" ),
									'compare' => '<=',
									'type'    => 'DATE'
								),
								array(
									'key'     => 'adfoxly-ad-campaign-end',
									'value'   => date( "Y-m-d" ),
									'compare' => '>=',
									'type'    => 'DATE'
								),
							)
						)
					),
					'post_type'      => 'adfoxly_banners',
					'posts_per_page' => - 1
				);


				$campaignArgs = array(
					'post_type'      => 'adfoxly_ad_campaign',
					'posts_per_page' => - 1
				);
				$banners      = get_posts( $campaignArgs );

				if ( isset( $_GET[ 'edit' ] ) ) {
					$g_id     = $_GET[ 'edit' ];
					$g_id_int = intval( $g_id );

					$selectedCampaignsArgs = array(
						'meta_query'     => array(
							array(
								'key'     => 'adfoxly-ad-campaign',
								'value'   => $g_id_int,
								'compare' => 'LIKE'
							)
						),
						'post_type'      => 'adfoxly_ad_campaign',
						'posts_per_page' => - 1,
						'fields'         => 'ids'
					);

					$selectedAdsConnectedToPlace = get_posts( $selectedCampaignsArgs );
				}

			} else if ( $meta_field[ 'id' ] === 'adfoxly-place-ads-list' ) {

				$campaignArgs = array(
					'post_type'      => 'adfoxly_banners',
					'posts_per_page' => - 1
				);
				$banners      = get_posts( $campaignArgs );

				if ( isset( $_GET[ 'edit' ] ) && $_GET['edit'] !== 'new' ) {
					$g_id     = $_GET[ 'edit' ];
					$g_id_int = intval( $g_id );

					$selectedAdsConnectedToPlaceArgs = array(
						'meta_query' => array(
							array(
								'key'     => 'adfoxly-adzone-place',
								'value'   => $g_id_int,
								'compare' => 'LIKE'
							)
						),

						'posts_per_page' => - 1,
						'post_type'      => 'adfoxly_banners',
						'fields'         => 'ids'
					);
					$selectedAdsConnectedToPlace = get_posts( $selectedAdsConnectedToPlaceArgs );
				}

			}

			// todo
			// display ads to include
			$output .= '<div class="form-group">';
			foreach ( $banners as $banner ):
				$output .= '<div class="custom-control custom-checkbox">';
				$output .= '<input type="checkbox" name="' . $meta_field[ 'id' ] . '[]" class="custom-control-input" id="' . $banner->ID . '" value="' . $banner->ID . '"';
				if (
				( isset( $selectedAdsConnectedToPlace ) && ! empty( $selectedAdsConnectedToPlace ) && array_search( $banner->ID, $selectedAdsConnectedToPlace ) !== false )
				) {
					$output .= ' checked ';
				}

				if (
				( isset( $selectedAdsConnectedToPlace ) && ! empty( $selectedAdsConnectedToPlace ) && array_search( $banner->ID, $selectedAdsConnectedToPlace ) !== false )
				) {
					$output .= ' checked ';
				}

				$output .= '><label class="custom-control-label" for="' . $banner->ID . '">' . $banner->post_title . '</label>';
				$output .= '</div>';
			endforeach;
			$output .= '</div>';
			if ( isset( $meta_field[ 'help-block' ] ) && ! empty( $meta_field[ 'help-block' ] ) ) {
				$output .= '<p class="help-block">';
				$output .= '<em>' . $meta_field[ 'help-block' ] . '</em>';
				$output .= '</p>';
			}
			// display ads to include
			// todo end
		} else if ( $meta_field[ 'id' ] === 'adfoxly-groups-list' ) {
			$output .= '<div class="form-group">';
//			$groupsController = new GroupController();
//			$groups = $groupsController->getGroups();


			// new group
			$output .= '<div class="custom-control custom-checkbox">';
			$output .= '<input type="checkbox" name="' . $meta_field[ 'id' ] . '[]" class="custom-control-input" id="new_group" value="new_group"';
			$output .= '><label class="custom-control-label" for="new_group"> ' . __('Create new group', 'adfoxly') . '</label>';
			$output .= '</div>';

			$output .= '<div class="custom-control custom-checkbox">';
			$output .= '<strong>' . __( 'or add into existing group', 'adfoxly') . '</strong>';
			$output .= '</div>';


//			foreach ( $groups as $group ):
//				$output .= '<div class="custom-control custom-checkbox">';
//				$output .= '<input type="checkbox" name="' . $meta_field[ 'id' ] . '[]" class="custom-control-input" id="' . $group->ID . '" value="' . $group->ID . '"';
//				if (
//					( ! empty( $group ) && array_search( $group->ID, $groups, true ) !== false )
//					|| ( isset( $selectedCampaigns ) && ! empty( $selectedCampaigns ) && array_search( $group->ID, $selectedCampaigns, true ) !== false )
//				) {
//					$output .= ' checked ';
//				}
//				$output .= '><label class="custom-control-label" for="' . $group->ID . '">' . $group->post_title . ' <code>[adfoxly group="' . $group->ID . '"]</code></label>';
//				$output .= '</div>';
//			endforeach;

			$output .= '</div>';

			if ( isset( $meta_field[ 'help-block' ] ) && ! empty( $meta_field[ 'help-block' ] ) ) {
				$output .= '<p class="help-block">';
				$output .= '<em>' . $meta_field[ 'help-block' ] . '</em>';
				$output .= '</p>';
			}
		}

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}
