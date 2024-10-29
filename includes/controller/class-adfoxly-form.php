<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class adfoxlyForm
 */
class AdfoxlyFormController {

	/**
	 * @var null
	 */
	public $banner_id;

	/**
	 * @var
	 */
	public $banner;

	/**
	 * @var \BannerController
	 */
	public $banners;

	/**
	 * @var \adfoxlySpot
	 */
	public $spot;

	/**
	 * @var \adfoxlyFormats
	 */
	public $format;

	/**
	 * @var \adfoxlyFormatImage
	 */
	public $image;

	/**
	 * @var \adfoxlyAdCampaign
	 */
	public $campaign;

	/**
	 * @var
	 */
	public $banner_data;

	/**
	 * @var \adfoxlySettingsRedirect
	 */
	public $settings_redirect;

	/**
	 * @var \adfoxlySettingsStatistics
	 */
	public $settings_statistics;

	/**
	 * @var \adfoxlyPlacesSettings
	 */
	public $places_settings;

	/**
	 * @var \AdfoxlyCampaignModel
	 */
	public $campaigns_settings;
	/**
	 * @var \AdfoxlySettingsPixelModel
	 */
	public $settings_pixel;

	/**
	 * @var \AdfoxlySettingsPixelModel
	 */
	public $settings_adstxt;

	/**
	 * @var \AdfoxlySettingsPixelModel
	 */
	public $settings_privacy;

	/**
	 * @var \adfoxlySettingsCore
	 */
	public $settings_core;

	/**
	 * @var \adfoxlyadfoxlyPlacesController
	 */
	public $places_controller;

	/**
	 * adfoxlyForm constructor.
	 *
	 * @param null $banner_id
	 */
	function __construct( $banner_id = null ) {
		$this->banner_id          = $banner_id;
		$this->spot               = new AdfoxlySpotModel();

		$this->format             = new AdfoxlyFormatsModel();
		$this->image              = new AdfoxlyFormatImageModel();
		$this->campaign           = new AdfoxlyCampaignModel('adCampaign');
		$this->places_settings    = new AdfoxlyPlacesSettingsController();
		$this->campaigns_settings = new AdfoxlyCampaignModel();
		// model
		$this->banners             = new AdfoxlyBannerModel();

		// settings
		$this->settings_redirect   = new AdfoxlySettingsRedirectModel();
		$this->settings_statistics = new AdfoxlySettingsStatisticsModel();
		$this->settings_pixel      = new AdfoxlySettingsPixelModel();
		$this->settings_adstxt     = new AdfoxlySettingsAdstxtModel();
		$this->settings_core       = new AdfoxlySettingsCoreModel();
		$this->settings_privacy    = new AdfoxlySettingsPrivacyModel();

		//
		$this->places_controller   = new AdfoxlyPlacesController();
	}

	/**
	 * @param array $arguments
	 *
	 * This method generate form based on config arrays which are above
	 * Forms are used in all places in dashboard
	 *
	 * @return string
	 */
	public function generate( array $arguments = array() ) {
		if ( ! empty( $arguments ) ) {
			foreach ( $arguments as $property => $argument ) {
				$this->{$property} = $argument;
			}

			if ( ! empty( $arguments[ 'type' ] ) ) {
				$output = '';
				foreach ( $this->{$arguments[ 'type' ]}->meta_fields as $meta_field ) {
					if ( ! empty( $arguments[ 'banner_id' ] ) ) {
						$bannerController  = new AdfoxlyBannerModel();
						$this->banner_data = $bannerController->getBanner( $this->banner_id );
					}
					$output .= $this->generate_field( $meta_field );
				}

				return $output;
			}
		}
	}

	/**
	 * @param $meta_field
	 *
	 * @return string
	 */
	public function generate_field( $meta_field ) {

		Timber::$locations = array( realpath( dirname( __DIR__ ) ) . '/view' );

		$output = '';
		$output1 = '';
		$output2 = '';
		if ( isset( $meta_field ) && isset( $meta_field[ 'type' ] ) ):
			switch ( $meta_field[ 'type' ] ):
				case ( $meta_field[ 'type' ] == "image_checkbox" || $meta_field[ 'type' ] == "image_radio" || $meta_field['type'] === 'image_radio_label'):

					if ( isset( $meta_field ) && ! empty( $meta_field ) && ! empty( $meta_field[ 'options' ] ) ) {

						if ( $meta_field['id'] === 'adfoxly-adzone-place' ) {

//							$content[ 'title' ]    = 'Custom Places';
//							$content[ 'subtitle' ] = 'If you choose a custom place, at the end you will get generated shortcode, which you can use on every spot on the site by inserting generated code in PHP file.';
//							$output .= $groupHeader->render( $content );

							$output .= $this->generate_options( $output2, $meta_field, array( 'category' => 'custom' ) );

							$output .= '<div class="new-place-wrapper col-md-12 col-lg-12 grid-margin stretch-card">';
							$output .= '<div class="row">';

							$context[ 'title' ]    = 'Create new place';
							$context[ 'subtitle' ] = 'Here you can select a place on your site, and an ad will be visible automatically without using any shortcode or other steps. Just choose one of these places and rest of will be done without your effort.';
							$output .= Timber::compile( 'group-header.twig', $context );

							$output .= $this->generate_options( $output1, $meta_field, array( 'category' => 'predefined' ) );
							$output .= '</div>';
							$output .= '</div>';
						} else {
							$output  = $this->generate_options( $output, $meta_field );
						}

					}

					break;
				case 'checkbox':

					if ( $meta_field['id'] === 'adfoxly-statistics-type' ) {
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

						$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ];
						if ( isset( $meta_field[ 'question-mark' ] ) && ! empty( $meta_field[ 'question-mark' ] ) ) {
							$output .= '<em class="question-mark">' . $meta_field[ 'question-mark' ] . '</em>';
						}
						$output .='</label>';
						$output .= '<div class="col-sm-9 col-form-label">';

						switch ( $meta_field[ 'type' ] ):
							case 'checkbox':
								foreach ( $meta_field[ 'options' ] as $key => $value ):
									$output .= '<div class="custom-control custom-checkbox">';
									$output .= '<input type="checkbox" id="' . $meta_field[ 'id' ] . '_' . $key . '" name="' . $meta_field[ 'id' ] . '[]" class="custom-control-input" value="' . $key . '"';
									if ( ( isset( $meta_field[ 'default' ] ) && ! empty( $meta_field[ 'default' ] ) && $meta_field[ 'default' ] === $key )
									     || ( isset( $meta_field[ 'value' ] ) && ! empty( $meta_field[ 'value' ] ) && is_array( $meta_field[ 'value' ] ) && in_array( $key, $meta_field[ 'value' ] ) )
									     || (
										     ! empty( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] )
										     && $key === intval( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] )
									     ) ) {
										$output .= ' checked ';
									}
									$output .= '>';
									$output .= '<label class="custom-control-label" for="' . $meta_field[ 'id' ] . '_' . $key . '">' . $value . '</label>';
									$output .= '</div>';
								endforeach;
								break;
							default:
								if ( $meta_field[ 'id' ] !== 'adfoxly-ad-preview' ) {

									if ( ! isset( $meta_field[ 'class' ] ) ) {
										$meta_field[ 'class' ] = '';
									}
									$output .= '<input name="' . $meta_field[ 'id' ] . '" type="' . $meta_field[ 'type' ] . '" class="' . $meta_field[ 'class' ] . '" id="' . $meta_field[ 'id' ] . '"';

									if ( isset( $meta_field[ 'required' ] ) && ! empty( $meta_field[ 'required' ] ) && $meta_field[ 'required' ] === true ):
										$output .= " required ";
									endif;

									if ( isset( $meta_field[ 'data-parsley-mincheck' ] ) && ! empty( $meta_field[ 'data-parsley-mincheck' ] ) ):
										$output .= " data-parsley-multiple=" . $meta_field[ 'data-parsley-mincheck' ] . " ";
									endif;

									if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
										$output .= " data-parsley-errors-container=" . $meta_field[ 'data-parsley-errors-container' ] . " ";
									endif;
									if ( ! empty( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] ) ):
										$output .= " value='" . $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] . "' ";
									elseif ( isset( $meta_field[ 'value' ] ) && ! empty( $meta_field[ 'value' ] ) ):
										$input_default_value = $meta_field[ 'value' ];
										$output              .= " value='" . $input_default_value . "' ";
									endif;

									if ( isset( $meta_field[ 'data-media-uploader-target' ] ) && ! empty( $meta_field[ 'data-media-uploader-target' ] ) ):
										$output .= " data-media-uploader-target=" . $meta_field[ 'data-media-uploader-target' ] . " ";
									endif;

									if ( isset( $meta_field[ 'autocomplete' ] ) && ! empty( $meta_field[ 'autocomplete' ] ) ):
										$output .= " autocomplete=" . $meta_field[ 'autocomplete' ] . " ";
									endif;

									$output .= '/>';
								} else {
									$output .= '<img id="' . $meta_field[ 'id' ] . '" src="' . $meta_field[ 'value' ] . '" style="max-height: 100px;" />';
								}

								break;
						endswitch;

						if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
							$output .= '<div id="alert-' . $meta_field[ "id" ] . '"></div>';
						endif;

						if ( isset( $meta_field[ 'help-block' ] ) && ! empty( $meta_field[ 'help-block' ] ) ) {
							$output .= '<p class="help-block">';
							$output .= '<em>' . $meta_field[ 'help-block' ] . '</em>';
							$output .= '</p>';
						}
						$output .= '</div>';
						$output .= '</div>';
					} else {
						$checkbox = new wizardCheckbox();
						$output = $checkbox->render( $output, $meta_field );
					}


					break;

				case 'tab':

					$tab = new wizardTab();
					$output = $tab->render( $output, $meta_field );

					break;

				case 'campaign_days_and_hours':

					$cmpaignDaysAndHours = new wizardCmpaignDaysAndHours();
					$output = $cmpaignDaysAndHours->render( $output, $meta_field );

					break;
				case 'textarea':

					$textarea = new wizardTextarea( $this->banner_data );
					$output = $textarea->render( $output, $meta_field );

					break;
				default:

					if ( isset( $meta_field[ 'is_premium' ] ) && ! empty( $meta_field[ 'is_premium' ] ) && $meta_field[ 'is_premium' ] === true ) {
						if ( adfoxly_wa_fs()->is__premium_only() ) {
							if ( adfoxly_wa_fs()->can_use_premium_code() ) {
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

//								$output .= '>';

								$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ];
								if ( isset( $meta_field[ 'question-mark' ] ) && ! empty( $meta_field[ 'question-mark' ] ) ) {
									$output .= '<em class="question-mark">' . $meta_field[ 'question-mark' ] . '</em>';
								}
								$output .='</label>';
								$output .= '<div class="col-sm-9 col-form-label">';

								switch ( $meta_field[ 'type' ] ):
									case 'radio':
										foreach ( $meta_field[ 'options' ] as $key => $value ):
											$output .= '<div class="custom-control custom-radio">';
											$output .= '<input type="radio" id="' . $meta_field[ 'id' ] . '_' . $key . '" name="' . $meta_field[ 'id' ] . '" class="custom-control-input" value="' . $key . '"';
											if ( ( isset( $meta_field[ 'default' ] ) && ! empty( $meta_field[ 'default' ] ) && $meta_field[ 'default' ] === $key )
											     || ( isset( $meta_field[ 'value' ] ) && ! empty( $meta_field[ 'value' ] ) && $meta_field[ 'value' ] === $key )
											     || (
												     ! empty( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] )
												     && $key === intval( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] )
											     ) ) {
												$output .= ' checked ';
											}
											$output .= '>';
											$output .= '<label class="custom-control-label" for="' . $meta_field[ 'id' ] . '_' . $key . '">' . $value . '</label>';
											$output .= '</div>';
										endforeach;
										break;
									default:
										if ( $meta_field[ 'id' ] !== 'adfoxly-ad-preview' ) {

											if ( ! isset( $meta_field[ 'class' ] ) ) {
												$meta_field[ 'class' ] = '';
											}
											$output .= '<input name="' . $meta_field[ 'id' ] . '" type="' . $meta_field[ 'type' ] . '" class="' . $meta_field[ 'class' ] . '" id="' . $meta_field[ 'id' ] . '"';

											if ( isset( $meta_field[ 'value' ] ) ) {
												$output .= ' value="' . $meta_field[ 'value' ] . '" ';
											}

											if ( isset( $meta_field[ 'required' ] ) && ! empty( $meta_field[ 'required' ] ) && $meta_field[ 'required' ] === true ):
												$output .= " required ";
											endif;

											if ( isset( $meta_field[ 'min' ] ) ) {
												$output .= ' min="' . $meta_field[ 'min' ] . '" ';
											}

											if ( isset( $meta_field[ 'data-parsley-mincheck' ] ) && ! empty( $meta_field[ 'data-parsley-mincheck' ] ) ):
												$output .= " data-parsley-multiple=" . $meta_field[ 'data-parsley-mincheck' ] . " ";
											endif;

											if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
												$output .= " data-parsley-errors-container=" . $meta_field[ 'data-parsley-errors-container' ] . " ";
											endif;
											if ( ! empty( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] ) ):
												$output .= " value='" . $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] . "' ";
											elseif ( isset( $meta_field[ 'value' ] ) && ! empty( $meta_field[ 'value' ] ) ):
												$input_default_value = $meta_field[ 'value' ];
												$output              .= " value='" . $input_default_value . "' ";
											endif;

											if ( isset( $meta_field[ 'data-media-uploader-target' ] ) && ! empty( $meta_field[ 'data-media-uploader-target' ] ) ):
												$output .= " data-media-uploader-target=" . $meta_field[ 'data-media-uploader-target' ] . " ";
											endif;

											if ( isset( $meta_field[ 'autocomplete' ] ) && ! empty( $meta_field[ 'autocomplete' ] ) ):
												$output .= " autocomplete=" . $meta_field[ 'autocomplete' ] . " ";
											endif;

											$output .= '/>';
										} else {
											$output .= '<img id="' . $meta_field[ 'id' ] . '" src="' . $meta_field[ 'value' ] . '" style="max-height: 100px;" />';
										}

										break;
								endswitch;

								if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
									$output .= '<div id="alert-' . $meta_field[ "id" ] . '"></div>';
								endif;

								if ( isset( $meta_field[ 'help-block' ] ) && ! empty( $meta_field[ 'help-block' ] ) ) {
									$output .= '<p class="help-block">';
									$output .= '<em>' . $meta_field[ 'help-block' ] . '</em>';
									$output .= '</p>';
								}
								$output .= '</div>';
								$output .= '</div>';
							}
						}

						if ( ! adfoxly_wa_fs()->is__premium_only() ) {
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

							$output .= '<label class="col-sm-3 col-form-label" style="color: #aaa;">' . $meta_field[ 'label' ] . ' <small>(PRO)</small><br/><a href="' . admin_url( 'admin.php?billing_cycle=annual&trial=true&page=adfoxly-pricing' ) . '" class="pro-link" style="color: #aaa; font-size: 10px; line-height: 1;">This feature is available only in pro version. Start free 7-day trial. No hidden fees. No credit card required.</a></label>';
							$output .= '<div class="col-sm-9 col-form-label">';

							switch ( $meta_field[ 'type' ] ):
								case 'radio':
									foreach ( $meta_field[ 'options' ] as $key => $value ):
										$output .= '<div class="custom-control custom-radio">';
										$output .= '<input type="radio" id="' . $meta_field[ 'id' ] . '_' . $key . '" disabled class="custom-control-input" value="' . $key . '"';
										$output .= '>';
										$output .= '<label class="custom-control-label" for="' . $meta_field[ 'id' ] . '_' . $key . '">' . $value . '</label>';
										$output .= '</div>';
									endforeach;
									break;
								default:
									if ( $meta_field[ 'id' ] !== 'adfoxly-ad-preview' ) {

										if ( ! isset( $meta_field[ 'class' ] ) ) {
											$meta_field[ 'class' ] = '';
										}
										$output .= '<input disabled type="' . $meta_field[ 'type' ] . '" class="' . $meta_field[ 'class' ] . '" id="' . $meta_field[ 'id' ] . '"';
										$output .= '/>';
									} else {
										$output .= '<img id="' . $meta_field[ 'id' ] . '" src="' . $meta_field[ 'value' ] . '" style="max-height: 100px;" />';
									}

									break;
							endswitch;

							if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
								$output .= '<div id="alert-' . $meta_field[ "id" ] . '"></div>';
							endif;

							if ( isset( $meta_field[ 'help-block' ] ) && ! empty( $meta_field[ 'help-block' ] ) ) {
								$output .= '<p class="help-block">';
								$output .= '<em style="color: #aaa;">' . $meta_field[ 'help-block' ] . '</em>';
								$output .= '</p>';
							}
							$output .= '</div>';
							$output .= '</div>';
						}
					} else {
						// free
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

						$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ];
						if ( isset( $meta_field[ 'question-mark' ] ) && ! empty( $meta_field[ 'question-mark' ] ) ) {
							$output .= '<em class="question-mark">' . $meta_field[ 'question-mark' ] . '</em>';
						}
						$output .='</label>';
						$output .= '<div class="col-sm-9 col-form-label">';

						switch ( $meta_field[ 'type' ] ):
							case 'radio':
								foreach ( $meta_field[ 'options' ] as $key => $value ):
									$output .= '<div class="custom-control custom-radio">';
									$output .= '<input type="radio" id="' . $meta_field[ 'id' ] . '_' . $key . '" name="' . $meta_field[ 'id' ] . '" class="custom-control-input" value="' . $key . '"';
									if (
										( isset( $meta_field[ 'default' ] ) && ! empty( $meta_field[ 'default' ] ) && $meta_field[ 'default' ] === $key )
										|| ( isset( $meta_field[ 'value' ] ) && ! empty( $meta_field[ 'value' ] ) && $meta_field[ 'value' ] === $key )
										|| (
											! empty( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] )
											&& $key === intval( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] )
										)
									) {
//										echo "<pre>";
//										var_dump($meta_field[ 'default' ]);
//										var_dump($key);
//										echo "</pre>";
										$output .= ' checked ';
									}
									$output .= '>';
									$output .= '<label class="custom-control-label" for="' . $meta_field[ 'id' ] . '_' . $key . '">' . $value . '</label>';
									$output .= '</div>';
								endforeach;
								break;
							default:
								if ( $meta_field[ 'id' ] !== 'adfoxly-ad-preview' ) {

									if ( ! isset( $meta_field[ 'class' ] ) ) {
										$meta_field[ 'class' ] = '';
									}
									$output .= '<input name="' . $meta_field[ 'id' ] . '" type="' . $meta_field[ 'type' ] . '" class="' . $meta_field[ 'class' ] . '" id="' . $meta_field[ 'id' ] . '"';

									if ( isset( $meta_field[ 'required' ] ) && ! empty( $meta_field[ 'required' ] ) && $meta_field[ 'required' ] === true ):
										$output .= " required ";
									endif;

									if ( isset( $meta_field[ 'value' ] ) ) {
										$output .= ' value="' . $meta_field[ 'value' ] . '" ';
									}

									if ( isset( $meta_field[ 'min' ] ) ) {
										$output .= ' min="' . $meta_field[ 'min' ] . '" ';
									}

									if ( isset( $meta_field[ 'data-parsley-mincheck' ] ) && ! empty( $meta_field[ 'data-parsley-mincheck' ] ) ):
										$output .= " data-parsley-multiple=" . $meta_field[ 'data-parsley-mincheck' ] . " ";
									endif;

									if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
										$output .= " data-parsley-errors-container=" . $meta_field[ 'data-parsley-errors-container' ] . " ";
									endif;
									if ( ! empty( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] ) ):
										$output .= " value='" . $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] . "' ";
									elseif ( isset( $meta_field[ 'value' ] ) && ! empty( $meta_field[ 'value' ] ) ):
										$input_default_value = $meta_field[ 'value' ];
										$output              .= " value='" . $input_default_value . "' ";
									endif;

									if ( isset( $meta_field[ 'data-media-uploader-target' ] ) && ! empty( $meta_field[ 'data-media-uploader-target' ] ) ):
										$output .= " data-media-uploader-target=" . $meta_field[ 'data-media-uploader-target' ] . " ";
									endif;

									if ( isset( $meta_field[ 'autocomplete' ] ) && ! empty( $meta_field[ 'autocomplete' ] ) ):
										$output .= " autocomplete=" . $meta_field[ 'autocomplete' ] . " ";
									endif;

									$output .= '/>';

									if ( isset( $meta_field[ 'adfoxly_validation_type' ] ) && ! empty( $meta_field[ 'adfoxly_validation_type' ] ) ) {
										$output .= '<div class="invalid-feedback">';
										if ( isset( $meta_field[ 'adfoxly_validation_text' ] ) && ! empty( $meta_field[ 'adfoxly_validation_text' ] ) ) {
											$output .= $meta_field[ 'adfoxly_validation_text' ];
										}
										$output .= '</div>';
									}

								} else {
									$output .= '<img id="' . $meta_field[ 'id' ] . '" src="' . $meta_field[ 'value' ] . '" style="max-height: 100px;" />';
								}

								break;
						endswitch;

						if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
							$output .= '<div id="alert-' . $meta_field[ "id" ] . '"></div>';
						endif;

						if ( isset( $meta_field[ 'help-block' ] ) && ! empty( $meta_field[ 'help-block' ] ) ) {
							$output .= '<p class="help-block">';
							$output .= '<em>' . $meta_field[ 'help-block' ] . '</em>';
							$output .= '</p>';
						}
						$output .= '</div>';
						$output .= '</div>';
					}


					break;
			endswitch;
		endif;

		return $output;

	}

	/**
	 * @param      $output
	 * @param      $meta_field
	 * @param null $array
	 *
	 * @return string
	 */
	public function generate_options( $output, $meta_field, $array = null ) {

//		$view = new AdfoxlyWizardView();
//		$view->generateOptions();
//		exit();

		if ( $meta_field['type'] === 'image_radio_label' ) {
			$output .= '<div class="form-group row form-group-type-text ';
			if ( isset( $meta_field[ 'wrapper_class' ] ) && ! empty( $meta_field[ 'wrapper_class' ] ) ) {
				$output .= $meta_field['wrapper_class'];
			}
			$output .= '">';
			$output .= '<label class="col-sm-3 col-form-label"> ' . __( 'Rotation', 'adfoxly' ) . ' <br/><small>' . __( 'How rotate if in this place will be more than one ad?', 'adfoxly' ) . '</small></label>';
			$output .= '<div class="col-sm-9 col-form-label">';
			$output .= '<div class="row">';
		}

		foreach ( $meta_field[ 'options' ] as $key => $field ) {
			switch ( $meta_field[ 'type' ] ):
				case "image_checkbox" || "image_radio" || "image_radio_label":
					$imageCheckbox = new wizardImageCheckbox();
					$output = $imageCheckbox->render( $this->banner_data, $output, $meta_field, $key, $field, $array );
					break;
			endswitch;
		}

		if ( $meta_field['type'] === 'image_radio_label' ) {
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
		}

		return $output;
	}
}
