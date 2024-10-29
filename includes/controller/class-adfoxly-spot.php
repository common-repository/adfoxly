<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class adfoxlyPlaces
 * @example ?page=adfoxly-new
 * @section "Where"
 */
class AdfoxlySpotModel {
	/**
	 * @var array
	 */
	public $meta_fields = array(
		array(
			'label'                         => 'Choose place on website',
			'id'                            => 'adfoxly-adzone-place',
			'type'                          => 'image_radio',
			'required'                      => true,
			'data-parsley-multiple'         => 'adfoxly-format',
			'data-parsley-errors-container' => '#alert-step-1',
			'options'                       => array(
				'before_post'    => array( 'name' => 'Before post', 'type' => 'img', 'image' => 'before_content.svg', 'category' => 'predefined' ),
				'after_post'     => array( 'name' => 'After post', 'type' => 'img', 'image' => 'after_content.svg', 'category' => 'predefined' ),
				'inside_post'    => array( 'name' => 'Inside the post', 'type' => 'img', 'image' => 'inside_content.svg', 'category' => 'predefined' ),
				'popup'          => array( 'name' => 'Popup', 'type' => 'img', 'image' => 'adfoxly-popup.svg', 'category' => 'predefined' ),
				'sticky'         => array( 'name' => 'Sticky', 'type' => 'img', 'image' => 'adfoxly-sticky.svg', 'category' => 'predefined' ),
				'widget'         => array( 'name' => 'WordPress Widget', 'type' => 'img', 'image' => 'widget.svg', 'category' => 'predefined' ),
				'shortcode'      => array( 'name' => 'Shortcode', 'type' => 'img', 'image' => 'code.svg', 'category' => 'predefined' ),
				'post_and_pages' => array( 'name' => 'Posts and Pages', 'type' => 'img', 'image' => 'code.svg', 'category' => 'predefined' ),
				'homepage_posts' => array( 'name' => 'Between Posts', 'type' => 'img', 'image' => 'inside_content.svg', 'category' => 'predefined' ),
			)
		),
	);

	/**
	 * adfoxlyPlaces constructor.
	 */
	public function __construct() {

		$getExistingPlacesArgs = array(
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => - 1
		);
		$getExistingPlaces = get_posts( $getExistingPlacesArgs );




		foreach ( $getExistingPlaces as $place ) {
			$meta = get_post_meta( $place->ID );
			if ( isset( $meta[ 'adfoxly_place_unique_id' ] ) && ! empty( $meta[ 'adfoxly_place_unique_id' ] ) ) {
				$uname = $meta[ 'adfoxly_place_unique_id' ][ 0 ];

				$this->meta_fields[ 0 ][ 'options' ][ $uname ][ 'name' ]     = $meta[ 'adfoxly-place-name' ][ 0 ];
				$this->meta_fields[ 0 ][ 'options' ][ $uname ][ 'type' ]     = 'img';
				$this->meta_fields[ 0 ][ 'options' ][ $uname ][ 'image' ]    = 'code.svg';
				$this->meta_fields[ 0 ][ 'options' ][ $uname ][ 'category' ] = 'custom';
			}
		}

		if ( ! empty( $getExistingPlaces ) ) {
			$this->meta_fields[ 0 ][ 'options' ][ 'new' ][ 'name' ]     = "Add new place";
			$this->meta_fields[ 0 ][ 'options' ][ 'new' ][ 'type' ]     = 'img';
			$this->meta_fields[ 0 ][ 'options' ][ 'new' ][ 'image' ]    = 'new.svg';
			$this->meta_fields[ 0 ][ 'options' ][ 'new' ][ 'category' ] = 'custom';
		}

//		if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) {
//			$adID = htmlentities( $_GET[ 'edit' ] );
//			$adID = intval( $adID );
//		}
	}

	/**
	 * @param null $id
	 *
	 * @return string
	 */
//	public function field_generator( $id = null ) {
//		if ( isset( $id ) && ! empty( $id ) ) {
//			$this->banner_id = $id;
//		}
//		$output = '';
//
//		$form = new adfoxlyForm( $id );
//
//		foreach ( $this->meta_fields as $meta_field ) {
//			$output .= $form->generate_field( $meta_field );
//		}
//
//		return $output;
//	}

	/**
	 *
	 */
//	public function getNumberOfPlaces() {
//	}

}

/**
 * Class adfoxlyPlacesSettings
 */
class AdfoxlyPlacesSettingsController {
	/**
	 * @var array|null|\WP_Post
	 */
	private $place;

	/**
	 * @var array
	 */
	public $meta_fields;

	/**
	 * adfoxlyPlacesSettings constructor.
	 */
	function __construct() {

		$adfoxlyPlacesModel = new AdfoxlyPlacesModel();
		$this->meta_fields = $adfoxlyPlacesModel->named_meta_fields;

//		echo "<pre>";
//		var_dump($this->meta_fields);
//		exit();

		if ( isset( $_GET[ 'edit' ] ) && $_GET[ 'edit' ] !== 'new' ) {
			$places      = new AdfoxlyPlacesModel();

			if (
				isset( $_GET[ 'page' ] )
				&& ! empty( $_GET[ 'page' ] )
				&& $_GET[ 'page' ] === 'adfoxly-banners'
				&& isset( $_GET[ 'edit' ] )
				&& ! empty( $_GET[ 'edit' ] )
				&& isset( $_GET[ 'edit' ] )
			) {
				$this->place = $places->get_placeby_banner_id( $_GET[ 'edit' ] );
			} else {
				$this->place = $places->get_place( $_GET[ 'edit' ] );
			}

//			echo "<pre>";
//			var_dump($this->place);
//			exit();
//			adfoxly_adzone_how_rotate
//			adfoxly_adzone_popup_repeat
//			adfoxly_adzone_popup_delay
//			adfoxly_place_ads_list

			if ( isset( $this->place->post_title ) && ! empty( $this->place->post_title ) ) {
				$this->meta_fields[ 'adfoxly-place-name' ][ 'value' ] = $this->place->post_title;
			}

			// todo: property_exists()
//			if ( isset( $this->place->adfoxly_adzone_is_rotate ) && ! empty( $this->place->adfoxly_adzone_is_rotate ) ) {
//				$this->meta_fields[ '' ][ 'value' ] = $this->place->adfoxly_adzone_is_rotate;
//			}

			// todo: property_exists()
			if ( isset( $this->place->adfoxly_adzone_how_rotate ) && ! empty( $this->place->adfoxly_adzone_how_rotate ) ) {
				$this->meta_fields[ 'adfoxly-adzone-how-rotate' ][ 'default' ] = $this->place->adfoxly_adzone_how_rotate;
			}

			// todo: property_exists()
			if ( isset( $this->place->adfoxly_adzone_rotate_time ) && ! empty( $this->place->adfoxly_adzone_rotate_time ) ) {
				$this->meta_fields[ 'adfoxly-adzone-rotate-time' ][ 'value' ] = $this->place->adfoxly_adzone_rotate_time;
			}

			// todo: property_exists()
			if ( isset( $this->place->adfoxly_adzone_popup_delay ) && ! empty( $this->place->adfoxly_adzone_popup_delay ) ) {
				$this->meta_fields[ 'adfoxly-adzone-popup-delay' ][ 'value' ] = $this->place->adfoxly_adzone_popup_delay;
			}

			// todo: property_exists()
			if ( isset( $this->place->adfoxly_adzone_popup_repeat ) && ! empty( $this->place->adfoxly_adzone_popup_repeat ) ) {
				$this->meta_fields[ 'adfoxly-adzone-popup-repeat' ][ 'value' ] = $this->place->adfoxly_adzone_popup_repeat;
			}

			// todo: property_exists()
			if ( isset( $this->place->adfoxly_place_ads_list ) && ! empty( $this->place->adfoxly_place_ads_list ) ) {
				$this->meta_fields[ 'adfoxly-place-ads-list' ][ 'value' ] = $this->place->adfoxly_place_ads_list;
			}
		}
	}
}

/**
 * Class AdfoxlyPlacesSettingsSticky
 */
class AdfoxlyPlacesSettingsSticky extends AdfoxlyPlacesSettingsController {

	/**
	 * @var array|null|\WP_Post
	 */
	private $place;
	/**
	 * @var array
	 */
	public $meta_fields = array(
		array(
			'label'   => 'Position',
			'class'   => 'form-control',
			'id'      => 'adfoxly-place-sticky-position',
			'default' => 'bottom',
			'type'    => 'radio',
			'options' => array(
				'bottom' => 'Bottom',
				'top'    => 'Top',
				'left'   => 'Left',
				'right'  => 'Right'
			),
		)
	);

	/**
	 * AdfoxlyPlacesSettingsSticky constructor.
	 */
	function __construct() {
		parent::__construct();
		if ( isset( $_GET[ 'edit' ] ) && $_GET[ 'edit' ] !== 'new' ) {
			$places      = new AdfoxlyPlacesModel();
			$this->place = $places->get_place( $_GET[ 'edit' ] );
		}
	}
}
