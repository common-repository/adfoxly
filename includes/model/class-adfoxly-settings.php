<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class adfoxlySettingsRedirect
 */
class AdfoxlySettingsRedirectModel {

	/**
	 * @var mixed
	 */
	public $settings;

	/**
	 * @var array
	 */
	public $meta_fields = array(
		array(
			'label' => 'Redirect URL',
			'id'    => 'adfoxly-redirect-slug',
			'type'  => 'text',
			'class' => 'form-control',
		)
	);

	/**
	 * adfoxlySettingsRedirect constructor.
	 */
	function __construct() {
		$this->settings = get_option( 'adfoxly_settings' );
		if ( isset( $this->settings[ 'redirect-slug' ] ) && ! empty( $this->settings[ 'redirect-slug' ] ) ) {
			$this->meta_fields[ 0 ][ 'value' ] = $this->settings[ 'redirect-slug' ];
		}
	}
}

/**
 * Class adfoxlySettingsStatistics
 */
class AdfoxlySettingsStatisticsModel {

	/**
	 * @var mixed
	 */
	public $settings;

	/**
	 * @var array
	 */
	public $meta_fields = array(
		array(
			'label'   => 'Ads statistics status',
			'id'      => 'adfoxly-statistics-status',
			'type'    => 'radio',
			'class'   => 'form-control',
			'default' => 'enabled',
			'options' => array(
				'enabled'  => 'Enabled',
				'disabled' => 'Disabled'
			),
		),
		array(
			'label'      => 'Choose statistics',
			'id'         => 'adfoxly-statistics-type',
			'type'       => 'checkbox',
			'class'      => 'form-control',
			'default'    => 'internal',
			'wrapper_id' => 'adfoxly-statistics-type-wrapper',
			'options'    => array(
				'internal'         => 'Internal',
//				'google-analytics' => 'Google Analytics',
//				'piwik'            => 'Piwik/Matomo',
			),
		),
		array(
			'label'      => 'Google Analytics ID<br/><small>(UA CODE)</small>',
			'id'         => 'adfoxly-statistics-gaid-select',
			'type'       => 'radio',
			'class'      => 'form-control',
			'wrapper_id' => 'adfoxly-statistics-gaid-wrapper',
		),
		array(
			'label'      => 'Custom Analytics ID<br/><small>(UA CODE)</small>',
			'id'         => 'adfoxly-statistics-custom-gaid',
			'type'       => 'text',
			'class'      => 'form-control',
			'wrapper_id' => 'adfoxly-statistics-custom-gaid-wrapper',
		),
		array(
			'label'      => 'Saving banner view interval',
			'id'         => 'adfoxly-statistics-saving-view-interval',
			'type'       => 'number',
			'class'      => 'form-control',
			'wrapper_id' => 'adfoxly-statistics-saving-view-interval-wrapper',
		),
	);

	/**
	 * adfoxlySettingsStatistics constructor.
	 */
	function __construct() {
		$this->settings = get_option( 'adfoxly_settings' );
//		$ga_obj         = new Ga_track();
//		$ua_id          = $ga_obj->get_ga_implemented( get_site_url() );

		if ( isset( $ua_id ) && ! empty( $ua_id[ 0 ] ) ) {
			foreach ( $ua_id[ 0 ] as $key => $value ) {
				$ga_ua_ids[ $value ] = $value;
			}
		}
		$ga_ua_ids[ 'other' ] = "Other";

		if ( isset( $this->settings[ 'statistics-status' ] ) && ! empty( $this->settings[ 'statistics-status' ] ) ) {
			$this->meta_fields[ 0 ][ 'value' ] = $this->settings[ 'statistics-status' ];
		}
		if ( isset( $this->settings[ 'statistics-type' ] ) && ! empty( $this->settings[ 'statistics-type' ] ) ) {
			$this->meta_fields[ 1 ][ 'value' ] = $this->settings[ 'statistics-type' ];
		}
		if ( isset( $this->settings[ 'statistics-gaid-select' ] ) && ! empty( $this->settings[ 'statistics-gaid-select' ] ) ) {
			$this->meta_fields[ 2 ][ 'value' ] = $this->settings[ 'statistics-gaid-select' ];
		}
		if ( isset( $ga_ua_ids ) && ! empty( $ga_ua_ids ) ) {
			$this->meta_fields[ 2 ][ 'options' ] = $ga_ua_ids;
		}
		if ( isset( $this->settings[ 'statistics-custom-gaid' ] ) && ! empty( $this->settings[ 'statistics-custom-gaid' ] ) ) {
			$this->meta_fields[ 3 ][ 'value' ] = $this->settings[ 'statistics-custom-gaid' ];
		}
		if ( isset( $this->settings[ 'statistics-saving-view-interval' ] ) && ( ! empty( $this->settings[ 'statistics-saving-view-interval' ] ) ) ) {
			$this->meta_fields[ 4 ][ 'value' ] = $this->settings[ 'statistics-saving-view-interval' ];
		} else {
			$this->meta_fields[ 4 ][ 'value' ] = '10';
		}

	}
}

/**
 * Class AdfoxlySettingsPixelModel
 */
class AdfoxlySettingsAdstxtModel {

	/**
	 * @var mixed
	 */
	public $settings;

	/**
	 * @var array
	 */
	public $meta_fields = array(
		array(
			'label' => 'Ads.txt',
			'id'    => 'adfoxly-adstxt-code',
			'type'  => 'textarea',
			'class' => 'form-control'
		)
	);

	/**
	 * AdfoxlySettingsPixelModel constructor.
	 */
	function __construct() {
		$filename = "../ads.txt";

		if ( file_exists( $filename ) && filesize( $filename ) > 0 ) {
			$handle   = fopen( $filename, "r" );
			$contents = fread( $handle, filesize( $filename ) );
			fclose( $handle );

			$this->meta_fields[ 0 ][ 'value' ] = $contents;
		}
	}
}

class AdfoxlySettingsPixelModel {

	/**
	 * @var mixed
	 */
	public $settings;

	/**
	 * @var array
	 */
	public $meta_fields = array(
		array(
			'label' => 'Pixel',
			'id'    => 'adfoxly-facebook-pixel-code',
			'type'  => 'textarea',
			'class' => 'form-control'
		)
	);

	/**
	 * AdfoxlySettingsPixelModel constructor.
	 */
	function __construct() {
		$this->settings = get_option( 'adfoxly_settings' );

		if ( isset( $this->settings[ 'adfoxly-facebook-pixel-code' ] ) ) {
			$this->meta_fields[ 0 ][ 'value' ] = stripslashes( $this->settings[ 'adfoxly-facebook-pixel-code' ] );

		}
	}
}

/**
 * Class AdfoxlySettingsPrivacyModel
 */
class AdfoxlySettingsPrivacyModel {

	/**
	 * @var mixed
	 */
	public $settings;
	/**
	 * @var array
	 */
	public $meta_fields = array(
        array(
            'label'      => 'Sentry',
            'id'         => 'adfoxly-privacy-sentry',
            'type'       => 'radio',
            'class'      => 'form-control',
            'default'    => 'no',
            'wrapper_id' => 'adfoxly-privacy-sentry-wrapper',
            'options'    => array(
                'no'  => 'Do not send any data',
                'yes' => 'Send anonymously background errors, for better optimization.'
            ),
        ),
        array(
            'label'      => 'Bugsnag',
            'id'         => 'adfoxly-privacy-bugsnag',
            'type'       => 'radio',
            'class'      => 'form-control',
            'default'    => 'no',
            'wrapper_id' => 'adfoxly-privacy-bugsnag-wrapper',
            'options'    => array(
                'no'  => 'Do not send any data',
                'yes' => 'Send anonymously background errors, for better optimization.'
            ),
        ),
        array(
            'label'      => 'Freshpaint',
            'id'         => 'adfoxly-privacy-freshpaint',
            'type'       => 'radio',
            'class'      => 'form-control',
            'default'    => 'no',
            'wrapper_id' => 'adfoxly-privacy-freshpaint-wrapper',
            'options'    => array(
                'no'  => 'Do not send any data',
                'yes' => 'Send some data like clicks, for better optimization.'
            ),
        ),
        array(
            'label'      => 'Smartlook',
            'id'         => 'adfoxly-privacy-smartlook',
            'type'       => 'radio',
            'class'      => 'form-control',
            'default'    => 'no',
            'wrapper_id' => 'adfoxly-privacy-heap-wrapper',
            'options'    => array(
                'no'  => 'Do not send any data',
                'yes' => 'Send some data like clicks, for better optimization.'
            ),
        )
	);

	/**
	 * AdfoxlySettingsPrivacyModel constructor.
	 */
	function __construct() {
		$this->settings = get_option( 'adfoxly_settings' );

        if ( isset( $this->settings[ 'adfoxly-privacy-sentry' ] ) ) {
            $this->meta_fields[ 0 ][ 'value' ] = stripslashes( $this->settings[ 'adfoxly-privacy-sentry' ] );
        } else if ( adfoxly_wa_fs()->is_registered() && adfoxly_wa_fs()->is_tracking_allowed() && ! isset( $this->settings[ 'adfoxly-privacy-sentry' ] ) ) {
            $this->meta_fields[ 0 ][ 'value' ] = "yes";
        }

        if ( isset( $this->settings[ 'adfoxly-privacy-bugsnag' ] ) ) {
            $this->meta_fields[ 1 ][ 'value' ] = stripslashes( $this->settings[ 'adfoxly-privacy-bugsnag' ] );
        } else if ( adfoxly_wa_fs()->is_registered() && adfoxly_wa_fs()->is_tracking_allowed() && ! isset( $this->settings[ 'adfoxly-privacy-bugsnag' ] ) ) {
            $this->meta_fields[ 1 ][ 'value' ] = "yes";
        }

        if ( isset( $this->settings[ 'adfoxly-privacy-freshpaint' ] ) ) {
            $this->meta_fields[ 2 ][ 'value' ] = stripslashes( $this->settings[ 'adfoxly-privacy-freshpaint' ] );
        } else if ( adfoxly_wa_fs()->is_registered() && adfoxly_wa_fs()->is_tracking_allowed() && ! isset( $this->settings[ 'adfoxly-privacy-freshpaint' ] ) ) {
            $this->meta_fields[ 2 ][ 'value' ] = "yes";
        }

        if ( isset( $this->settings[ 'adfoxly-privacy-smartlook' ] ) ) {
            $this->meta_fields[ 3 ][ 'value' ] = stripslashes( $this->settings[ 'adfoxly-privacy-smartlook' ] );
        } else if ( adfoxly_wa_fs()->is_registered() && adfoxly_wa_fs()->is_tracking_allowed() && ! isset( $this->settings[ 'adfoxly-privacy-smartlook' ] ) ) {
            $this->meta_fields[ 3 ][ 'value' ] = "yes";
        }
	}
}

/**
 * Class adfoxlySettingsCore
 */
class AdfoxlySettingsCoreModel {

	/**
	 * @var mixed
	 */
	public $settings;

	/**
	 * @var array
	 */
	public $meta_fields = array(
		'adfoxly_navbar' => array(
			'label'      => 'Top navbar',
			'id'         => 'adfoxly-navbar',
			'type'       => 'radio',
			'class'      => 'form-control',
			'default'    => 'false',
			'options' => array(
				'false' => 'Hide',
				'true'  => 'Show'
			),
		),
		'adfoxly_wizard' => array(
			'label'      => 'Wizard As Default',
			'id'         => 'adfoxly-wizard',
			'type'       => 'radio',
			'class'      => 'form-control',
			'default'    => 'false',
			'options' => array(
				'false'  => 'No',
				'true' => 'Yes'
			),
		),
		'adfoxly_error_404' => array(
			'label'      => 'Do not show ads on 404 error page',
			'id'         => 'adfoxly-error-404',
			'type'       => 'radio',
			'class'      => 'form-control',
			'default'    => 'false',
			'options' => array(
				'false' => 'No',
				'true'  => 'Yes'
			),
		),
	);

	/**
	 * adfoxlySettingsCore constructor.
	 */
	function __construct() {
		$this->settings = get_option( 'adfoxly_settings' );
		if ( isset( $this->settings[ 'adfoxly-navbar' ] ) && ! empty( $this->settings[ 'adfoxly-navbar' ] ) ) {
			$this->meta_fields[ 'adfoxly_navbar' ][ 'value' ] = $this->settings[ 'adfoxly-navbar' ];
		}
		if ( isset( $this->settings[ 'adfoxly-wizard' ] ) && ! empty( $this->settings[ 'adfoxly-wizard' ] ) ) {
			$this->meta_fields[ 'adfoxly_wizard' ][ 'value' ] = $this->settings[ 'adfoxly-wizard' ];
		}
		if ( isset( $this->settings[ 'adfoxly-error-404' ] ) && ! empty( $this->settings[ 'adfoxly-error-404' ] ) ) {
			$this->meta_fields[ 'adfoxly_error_404' ][ 'value' ] = $this->settings[ 'adfoxly-error-404' ];
		}
	}
}
