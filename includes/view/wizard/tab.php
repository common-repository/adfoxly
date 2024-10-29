<?php

class wizardTab {
	private $places_controller;

	function __construct( $banner_id = null ) {
		$this->places_controller = new AdfoxlyPlacesController();
		$this->places_model      = new AdfoxlyPlacesModel();
	}

	public function render( $output, $meta_field ) {

		if ( isset( $meta_field[ 'id' ] ) && $meta_field[ 'id' ] === 'adfoxly-ad-campaign-post-pages-categories' ) {

			if ( isset( $meta_field[ 'group' ] ) && ! empty( $meta_field[ 'group' ] ) ) {
				$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . ' ad-format-group-' . $meta_field[ 'group' ] . '">';
			} else {
				$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . '">';
			}

			$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ] . '</label>';
			$output .= '<div class="col-sm-9 col-form-label">';

			$listOfPostAndPagesCategories = $this->places_model->listOfPostAndPagesCategories();

			if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) {
				$campaignID = $_GET[ 'edit' ];
			}

			$output .= '<ul class="nav nav-tabs" id="myTab2-categories" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2-categories" data-toggle="tab" href="#home2-categories" role="tab" aria-controls="home-categories" aria-selected="false">Exclude Categories</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2-categories" data-toggle="tab" href="#profile2-categories" role="tab" aria-controls="profile-categories" aria-selected="true">Allowed Categories</a>
                      </li>                      
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content-categories">
                      <div class="tab-pane fade active show" id="home2-categories" role="tabpanel" aria-labelledby="home-tab2-categories">';

			$output .= '<select name="adfoxly-campaign-excluded-categories[]" class="form-control select2 select2-adfoxly-campaign-excluded-categories" multiple="">';

			if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
				$campaignExcludedCategories = get_post_meta( $campaignID, 'adfoxly-campaign-excluded-categories', true );
			}

			foreach ( $listOfPostAndPagesCategories as $category ):
				if ( isset( $campaignExcludedCategories ) && ! empty( $campaignExcludedCategories ) && in_array( $category->name, $campaignExcludedCategories ) ) {
					$output .= '<option value="' . $category->name . '"';
					$output .= ' selected ';
					$output .= '>' . $category->name . '</option>';
				}
			endforeach;

			$output .= '</select>
	                    
                      </div>
                      <div class="tab-pane fade" id="profile2-categories" role="tabpanel" aria-labelledby="profile-tab2-categories">
                        <select name="adfoxly-campaign-allowed-categories[]" class="form-control select2 select2-adfoxly-campaign-allowed-categories" multiple="">';

			if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
				$campaignAllowedCategories = get_post_meta( $campaignID, 'adfoxly-campaign-allowed-categories', true );
			}

			foreach ( $listOfPostAndPagesCategories as $category ):
				if ( isset( $campaignAllowedCategories ) && ! empty( $campaignAllowedCategories ) && in_array( $category->name, $campaignAllowedCategories ) ) {
					$output .= '<option value="' . $category->name . '"';
					$output .= ' selected ';
					$output .= '>' . $category->name . '</option>';
				}
			endforeach;

			$output .= '</select>
                      </div>';


			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';



		} else if ( isset( $meta_field[ 'id' ] ) && $meta_field[ 'id' ] === 'adfoxly-ad-campaign-post-pages-tags' ) {

			if ( isset( $meta_field[ 'group' ] ) && ! empty( $meta_field[ 'group' ] ) ) {
				$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . ' ad-format-group-' . $meta_field[ 'group' ] . '">';
			} else {
				$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . '">';
			}

			$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ] . '</label>';
			$output .= '<div class="col-sm-9 col-form-label">';

			$listOfPostAndPagesTags = $this->places_model->listOfPostAndPagesTags();

			if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) {
				$campaignID = $_GET[ 'edit' ];
			}

			$output .= '<ul class="nav nav-tabs" id="myTab2-tags" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2-tags" data-toggle="tab" href="#home2-tags" role="tab" aria-controls="home-tags" aria-selected="false">Exclude Tags</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2-tags" data-toggle="tab" href="#profile2-tags" role="tab" aria-controls="profile-tags" aria-selected="true">Allowed Tags</a>
                      </li>                      
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content-tags">
                      <div class="tab-pane fade active show" id="home2-tags" role="tabpanel" aria-labelledby="home-tab2-tags">
                                       
	                      <select name="adfoxly-campaign-excluded-tags[]" class="form-control select2 select2-adfoxly-campaign-excluded-tags" multiple="">';

			if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
				$campaignExcludedTags = get_post_meta( $campaignID, 'adfoxly-campaign-excluded-tags', true );
			}

			foreach ( $listOfPostAndPagesTags as $tag ):
				if ( isset( $campaignExcludedTags ) && ! empty( $campaignExcludedTags ) && in_array( $tag->name, $campaignExcludedTags ) ) {
					$output .= '<option value="' . $tag->name . '"';
					$output .= ' selected ';
					$output .= '>' . $tag->name . '</option>';
				}
			endforeach;

			$output .= '</select>
	                    
                      </div>
                      <div class="tab-pane fade" id="profile2-tags" role="tabpanel" aria-labelledby="profile-tab2-tags">
                        <select name="adfoxly-campaign-allowed-tags[]" class="form-control select2 select2-adfoxly-campaign-allowed-tags" multiple="">';

			if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
				$campaignAllowedTags = get_post_meta( $campaignID, 'adfoxly-campaign-allowed-tags', true );
			}

			foreach ( $listOfPostAndPagesTags as $tag ):
				if ( isset( $campaignAllowedTags ) && ! empty( $campaignAllowedTags ) && in_array( $tag->name, $campaignAllowedTags ) ) {
					$output .= '<option value="' . $tag->name . '"';
					$output .= ' selected ';
					$output .= '>' . $tag->name . '</option>';
				}
			endforeach;
			$output .= '</select>
                      </div>';


			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';

		} else if ( isset( $meta_field[ 'id' ] ) && $meta_field[ 'id' ] === 'adfoxly-ad-campaign-post-or-pages' ) {

			if ( isset( $meta_field[ 'group' ] ) && ! empty( $meta_field[ 'group' ] ) ) {
				$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . ' ad-format-group-' . $meta_field[ 'group' ] . '">';
			} else {
				$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . '">';
			}

			$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ] . '</label>';
			$output .= '<div class="col-sm-9 col-form-label">';

			$listOfPostOrPages = $this->places_model->listOfPostOrPages();

			if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) {
				$campaignID = $_GET[ 'edit' ];
			}

			$output .= '<ul class="nav nav-tabs" id="myTab2-post-or-page" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2-post-or-page" data-toggle="tab" href="#home2-post-or-page" role="tab" aria-controls="home-post-or-page" aria-selected="false">Exclude Post or Page</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2-post-or-page" data-toggle="tab" href="#profile2-post-or-page" role="tab" aria-controls="profile-post-or-page" aria-selected="true">Allowed Post or Page</a>
                      </li>                      
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content-post-or-page">
                      <div class="tab-pane fade active show" id="home2-post-or-page" role="tabpanel" aria-labelledby="home-tab2-post-or-page">
                                       
	                      <select name="adfoxly-campaign-excluded-post-or-page[]" class="form-control select2 select2-adfoxly-campaign-excluded-post-or-page" multiple="">';

			if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
				$campaignExcludedPostOrPage = get_post_meta( $campaignID, 'adfoxly_campaign_excluded_post_or_page', true );
			}

			foreach ( $listOfPostOrPages as $postOrPage ):
				if ( isset( $campaignExcludedPostOrPage ) && ! empty( $campaignExcludedPostOrPage ) && in_array( $postOrPage->ID, $campaignExcludedPostOrPage ) ) {
					$output .= '<option value="' . $postOrPage->ID . '"';
					$output .= ' selected ';
					$output .= '>' . $postOrPage->post_title . '</option>';
				}
			endforeach;
				
			$output .= '</select>	                   
                      </div>
                      <div class="tab-pane fade" id="profile2-post-or-page" role="tabpanel" aria-labelledby="profile-tab2-post-or-page">
                        <select name="adfoxly-campaign-allowed-post-or-page[]" class="form-control select2 select2-adfoxly-campaign-allowed-post-or-page" multiple="">';

			if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
				$campaignAllowedPostOrPage = get_post_meta( $campaignID, 'adfoxly_campaign_allowed_post_or_page', true );
			}

			foreach ( $listOfPostOrPages as $postOrPage ):
				if ( isset( $campaignAllowedPostOrPage ) && ! empty( $campaignAllowedPostOrPage ) && in_array( $postOrPage->ID, $campaignAllowedPostOrPage ) ) {
					$output .= '<option value="' . $postOrPage->ID . '"';
					$output .= ' selected ';
					$output .= '>' . $postOrPage->post_title . '</option>';
				}
			endforeach;

			$output .= '</select>
                      </div>';

			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';

		} else {
			if ( adfoxly_wa_fs()->is__premium_only() ) {

				if ( adfoxly_wa_fs()->can_use_premium_code() ) {

					if ( isset( $meta_field[ 'group' ] ) && ! empty( $meta_field[ 'group' ] ) ) {
						$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . ' ad-format-group-' . $meta_field[ 'group' ] . '">';
					} else {
						$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . '">';
					}

					$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ] . '</label>';
					$output .= '<div class="col-sm-9 col-form-label">';

					$listOfCountries = $this->places_model->listOfCountries();

					if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) {
						$campaignID = $_GET[ 'edit' ];
					}

					$output .= '<ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="false">Exclude Countries</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="true">Allowed countries</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Region / City</a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade active show" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                       
	                      <select name="adfoxly-campaign-excluded-countries[]" class="form-control select2" multiple="">';

					if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
						$campaignExcludedCountries = get_post_meta( $campaignID, 'adfoxly-campaign-excluded-countries', true );
					}

					foreach ( $listOfCountries as $country ):
						$output .= '<option value="' . $country . '"';
						if ( isset( $campaignExcludedCountries ) && ! empty( $campaignExcludedCountries ) && in_array( $country, $campaignExcludedCountries ) ) {
							$output .= ' selected ';
						}
						$output .= '>' . $country . '</option>';
					endforeach;


					$output .= '</select>
	                    
                      </div>
                      <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                        <select name="adfoxly-campaign-allowed-countries[]" class="form-control select2" multiple="">';

					if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
						$campaignAllowedCountries = get_post_meta( $campaignID, 'adfoxly-campaign-allowed-countries', true );
					}

					foreach ( $listOfCountries as $country ):
						$output .= '<option value="' . $country . '"';
						if ( isset( $campaignAllowedCountries ) && ! empty( $campaignAllowedCountries ) && in_array( $country, $campaignAllowedCountries ) ) {
							$output .= ' selected ';
						}
						$output .= '>' . $country . '</option>';
					endforeach;

					$output .= '</select>
                      </div>
                      <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
                        <p>Excluded Regions / Cities</p>
                        <input type="text" name="adfoxly-campaign-excluded-region" class="form-control inputtags"';

					if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
						$campaignExcludedRegion = get_post_meta( $campaignID, 'adfoxly-campaign-excluded-region', true );

						if ( isset( $campaignExcludedRegion ) && ! empty( $campaignExcludedRegion ) ) {
							$campaignExcludedRegionString = implode( ",", $campaignExcludedRegion );
							$output                       .= ' value="' . $campaignExcludedRegionString . '"';
						}
					}
					$output .= '><br/><br/>
                        <p>Allowed Regions / Cities</p>
                        <input type="text" name="adfoxly-campaign-allowed-region" class="form-control inputtags"';

					if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
						$campaignAllowedRegion = get_post_meta( $campaignID, 'adfoxly-campaign-allowed-region', true );

						if ( isset( $campaignAllowedRegion ) && ! empty( $campaignAllowedRegion ) ) {
							$campaignAllowedRegionString = implode( ",", $campaignAllowedRegion );
							$output                      .= ' value="' . $campaignAllowedRegionString . '"';
						}
					}
					$output .= '>
                                              
                      </div>
                    </div>';

					$output .= '</div>';
					$output .= '</div>';
				}

			}

			if ( ! adfoxly_wa_fs()->is__premium_only() ) {
				if ( isset( $meta_field[ 'group' ] ) && ! empty( $meta_field[ 'group' ] ) ) {
					$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . ' ad-format-group-' . $meta_field[ 'group' ] . '">';
				} else {
					$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . '">';
				}

				$output .= '<label class="col-sm-3 col-form-label" style="color: #aaa;">' . $meta_field[ 'label' ] . ' <small>(PRO)</small><br/><a href="' . admin_url( 'admin.php?billing_cycle=annual&trial=true&page=adfoxly-pricing' ) . '" class="pro-link" style="color: #aaa; font-size: 10px; line-height: 1;">This feature is available only in pro version. Start free 7-day trial. No hidden fees. No credit card required.</a></label>';
				$output .= '<div class="col-sm-9 col-form-label">';
				$output .= '<ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="false" style="color: #aaa;">Exclude Countries <small>(PRO)</small></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="true" style="color: #aaa;">Allowed countries <small>(PRO)</small></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false" style="color: #aaa;">Region / City <small>(PRO)</small></a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade active show" id="home2" role="tabpanel" aria-labelledby="home-tab2">
						<p><a href="' . admin_url( 'admin.php?billing_cycle=annual&trial=true&page=adfoxly-pricing' ) . '" class="pro-link">This feature is available only in pro version. Start free 7-day trial. No hidden fees. No credit card required.</a></p>
						<select class="form-control select2" multiple="" disabled></select>	                   
                      </div>
                      <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                        <p><a href="' . admin_url( 'admin.php?billing_cycle=annual&trial=true&page=adfoxly-pricing' ) . '" class="pro-link">This feature is available only in pro version. Start free 7-day trial. No hidden fees. No credit card required.</a></p>
                        <select class="form-control select2" multiple="" disabled></select>
                      </div>
                      <div class="tab-pane fade disabled" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">                        
                        <p style="margin-bottom: 0;">Excluded Regions / Cities</p>                                               
                        <p><a href="' . admin_url( 'admin.php?billing_cycle=annual&trial=true&page=adfoxly-pricing' ) . '" class="pro-link">This feature is available only in pro version. Start free 7-day trial. No hidden fees. No credit card required.</a></p>
                        <input disabled type="text" class="form-control inputtags"><br/><br/>
                        <p style="margin-bottom: 0;">Allowed Regions / Cities</p>
                        <p><a href="' . admin_url( 'admin.php?billing_cycle=annual&trial=true&page=adfoxly-pricing' ) . '" class="pro-link">This feature is available only in pro version. Start free 7-day trial. No hidden fees. No credit card required.</a></p>
                        <input disabled type="text" name="adfoxly-campaign-allowed-region" class="form-control inputtags">                                             
                      </div>
                    </div>';

				$output .= '</div>';
				$output .= '</div>';
			}
		}

		return $output;
	}
}
