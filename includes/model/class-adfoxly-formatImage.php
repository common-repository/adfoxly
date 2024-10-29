<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class adfoxlyFormatImage
 * @example ?page=adfoxly-new
 * @section "What - Details"
 */
class AdfoxlyFormatImageModel {
	/**
	 * @var array
	 */
	public $meta_fields;

	/**
	 * adfoxlyFormatImage constructor.
	 */
	function __construct() {

		$this->meta_fields = array(
			array(
				'label'                      => __( 'Select image', 'adfoxly' ),
				'id'                         => 'adfoxly-image_button',
				'type'                       => 'button',
				'group'                      => 'image',
				'value'                      => 'Upload',
				'data-media-uploader-target' => '#adfoxly-image',
				'class'                      => 'btn btn-primary btn-fw adsettings-media',
			),
			array(
				'label'                         => 'Select image',
				'id'                            => 'adfoxly-image',
				'type'                          => 'hidden',
				'show'                          => false,
				'value'                         => '',
				'data-parsley-errors-container' => '#alert-adfoxly-image',
			),
			array(
				'label' => 'Image preview',
				'id'    => 'adfoxly-ad-preview',
				'type'  => 'src',
				'group' => 'image',
				'value' => plugins_url( "admin/img/preview-picture.png", dirname( dirname( __FILE__ ) ) )
			),
			array(
				'label'                   => 'Ad Name',
				'id'                      => 'adfoxly-ad-name',
				'wrapper_class'           => 'adfoxly-ad-name',
				'adfoxly_validation_type' => 'invalid-feedback',
				'adfoxly_validation_text' => 'Ad with this same name already exists.',
				'type'                    => 'text',
				'class'                   => 'form-control'
			),
			array(
				'label'                         => 'Target URL',
				'id'                            => 'adfoxly-target-url',
				'type'                          => 'url',
				'class'                         => 'form-control',
				'wrapper_class'                 => 'adfoxly-target-url',
				'adfoxly_validation_type'       => 'invalid-feedback',
				'adfoxly_validation_text'       => 'URL should start with http:// or https://',
				'group'                         => 'image',
				'help-block'                    => 'What page will be open after user click on ad?',
				'required'                      => false,
				'data-parsley-errors-container' => '#alert-adfoxly-target-url'
			),
			array(
				'label'   => 'After click on ad, link should be open in...',
				'id'      => 'adfoxly-ad-options-target',
				'type'    => 'radio',
				'group'   => 'image',
				'class'   => 'form-control',
				'default' => 1,
				'options' => array(
					1 => 'new tab',
					2 => 'same tab'
				)
			),
			array(
				'label'   => 'Ref sponsored follow/nofollow <a href="https://support.google.com/webmasters/answer/96569" target="_blank">(?)</a>',
				'id'      => 'adfoxly-ad-options-nofollow',
				'type'    => 'radio',
				'group'   => 'image',
				'class'   => 'form-control',
				'default' => 1,
				'options' => array(
					1 => 'sponsored',
					2 => 'nofollow',
					3 => 'dofollow'
				)
			),
			array(
				'label'          => 'Paste the Google AdSense code',
				'id'             => 'adfoxly-adsense-code',
				'class'          => 'form-control',
				'group'          => 'google-adsense',
				'type'           => 'textarea',
				'help-block'     => 'Google AdSense Ad displays in wrong place? Check how generate AdSense code properly. <i class="fa fa-info-circle"></i>',
				'help-block-url' => plugins_url( "assets/images/adunits.png", dirname( dirname( __FILE__ ) ) )
			),
			array(
				'label'          => 'Paste the HTML/JS code',
				'id'             => 'adfoxly-custom-code',
				'class'          => 'form-control',
				'group'          => 'custom-code',
				'type'           => 'textarea',
				'help-block'     => 'Paste here code from your any publisher',
				'help-block-url' => plugins_url( "assets/images/adunits.png", dirname( dirname( __FILE__ ) ) )
			),
		);


		if ( isset( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) {
			$id             = $_GET[ 'edit' ];
			$getAdSenseCode = get_post_meta( $id, 'adfoxly-adsense-code', true );
			if ( isset( $this->settings[ 'adfoxly-adsense-code' ] ) ) {
				$this->meta_fields[ 5 ][ 'value' ] = stripslashes( $getAdSenseCode );
			}

			$getCustomCode = get_post_meta( $id, 'adfoxly-custom-code', true );
			if ( isset( $this->settings[ 'adfoxly-custom-code' ] ) ) {
				$this->meta_fields[ 6 ][ 'value' ] = stripslashes( $getCustomCode );
				$this->meta_fields[ 6 ][ 'visible-on-start' ] = true;
			}

			$getImageURL = get_post_meta( $id, 'adfoxly-image', true );
			if ( isset( $getImageURL ) && ! empty( $getImageURL ) ) {
				$this->meta_fields[ 2 ][ 'value' ] = $getImageURL;
			}


		}

	}
}
