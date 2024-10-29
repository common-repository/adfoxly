<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class adfoxlyFormats
 * @example ?page=adfoxly-new
 * @section "What"
 */
class AdfoxlyFormatsModel {
	/**
	 * @var array
	 */
	public $meta_fields = array(
		array(
			'label'                         => 'Ad Formats',
			'id'                            => 'adfoxly-format',
			'type'                          => 'image_radio',
			'options'                       => array(
				'image' => array( 'name' => 'Image', 'type' => 'fa-icon', 'image' => 'fas fa-image' ),
				'google_adsense' => array( 'name' => 'Google AdSense', 'type' => 'fa-icon', 'image' => 'fab fa-google' ),
				'custom_code' => array( 'name' => 'Custom HTML/JS', 'type' => 'fa-icon', 'image' => 'fas fa-code' ),
			),
			'required'                      => true,
			'data-parsley-multiple'         => 'adfoxly-format',
			'data-parsley-errors-container' => '#alert-step-1'

		)
	);
}
