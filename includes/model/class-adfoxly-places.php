<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class adfoxlyPlacesModel
 * @see: includes/controller/adfoxlyForm.php
 */
class AdfoxlyPlacesModel {

	public $options;
	public $data = array();

	public $named_meta_fields = array(
		/**
		 * deprecated
		 * still here because of list of functions (eg. animations)
		 */
//		'before_post' => array(
//			'name'    => 'Before Post',
//			'label'   => 'Before Post',
//			'class'   => 'form-control',
//			'id'      => 'before_post',
//			'options' => array(
//				'rotation' => array(
//					'label'   => 'Rotation',
//					'name'    => 'Rotation',
//					'class'   => 'form-control',
//					'id'      => 'before_post_options_rotation',
//					'default' => '',
//					'type'    => 'radio',
//					'options' => array(
//						'refresh' => array(
//							'label' => 'Refresh',
//							'name'  => 'Refresh',
//							'id'    => 'before_post_options_rotation_refresh',
//						),
//						'time'    => array(
//							'label'   => 'Time',
//							'name'    => 'Time',
//							'id'      => 'before_post_options_rotation_time',
//							'type'    => 'radio',
//							'options' => array(
//								'animation' => array(
//									'id'      => 'before_post_options_rotation_time_animation',
//									'label'   => 'Animation',
//									'name'    => 'Animation',
//									'type'    => 'radio',
//									'options' => array(
//										'left'  => array(
//											'label' => 'Left',
//											'name'  => 'Left',
//											'id'    => 'before_post_options_rotation_time_animation_left',
//											'type'  => 'radio',
//										),
//										'right' => array(
//											'label' => 'Right',
//											'name'  => 'Right',
//											'id'    => 'before_post_options_rotation_time_animation_right',
//											'type'  => 'radio',
//										)
//									)
//								),
//								'seconds'   => array(
//									'label' => 'Seconds',
//									'name'  => 'Seconds',
//									'id'    => 'before_post_options_rotation_time_seconds',
//									'type'  => 'radio',
//								)
//							),
//						),
//					)
//				),
//			),
//		),
		/**
		 * end of deprecated
		 */
		'adfoxly-place-name' => array(
			'label'                   => 'Name',
			'class'                   => 'form-control',
			'id'                      => 'adfoxly-place-name',
			'wrapper_class'           => 'adfoxly-place-name',
			'adfoxly_validation_type' => 'invalid-feedback',
			'adfoxly_validation_text' => 'This place name already exists.',
			'default'                 => '',
			'type'                    => 'text',
		),
		'adfoxly-adzone-how-rotate' => array(
			'label'         => 'Rotation',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-how-rotate',
			'default'       => 'refresh',
			'type'          => 'image_radio_label',
			'wrapper_class' => 'adfoxly-adzone-how-rotate-wrapper',
			'wrapper_id'    => 'adfoxly-adzone-how-rotate-wrapper',
			'options'       => array(
				'refresh' => array( 'name' => 'Refresh', 'type' => 'fa-icon', 'image' => 'fas fa-redo' ),
				'time'    => array( 'name' => 'Time', 'type' => 'fa-icon', 'image' => 'fas fa-clock' ),
			),
		),
		'adfoxly-adzone-rotate-time' => array(
			'label'         => 'Rotate time',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-rotate-time',
			'wrapper_id'    => 'adfoxly-adzone-rotate-time-wrapper',
			'wrapper_class' => 'adfoxly-adzone-rotate-time-wrapper',
			'default'       => '60',
			'type'          => 'number',
			'min'           => '0',
		),
		'adfoxly-adzone-popup-delay' => array(
			'label'         => 'Display delay',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-popup-delay',
			'wrapper_id'    => 'adfoxly-adzone-popup-delay-wrapper',
			'wrapper_class' => 'adfoxly-adzone-popup-delay-wrapper',
			'default'       => '0',
			'type'          => 'number',
			'min'           => '0',
		),
		'adfoxly-adzone-popup-repeat' => array(
			'label'         => 'Popup repeat',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-popup-repeat',
			'wrapper_id'    => 'adfoxly-adzone-popup-repeat-wrapper',
			'wrapper_class' => 'adfoxly-adzone-popup-repeat-wrapper',
			'default'       => '0',
			'type'          => 'number',
			'min'           => '0',
		),
		'adfoxly-adzone-rotate-slider' => array(
			'label'         => 'Slider',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-rotate-slider',
			'wrapper_id'    => 'adfoxly-adzone-rotate-slider-wrapper',
			'wrapper_class' => 'adfoxly-adzone-rotate-slider-wrapper',
			'default'       => '60',
			'type'          => 'number',
			'min'           => '0',
		),
		'adfoxly-adzone-rotate-grid-rows' => array(
			'label'         => 'Grid rows number',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-rotate-grid-rows',
			'wrapper_id'    => 'adfoxly-adzone-rotate-grid-wrapper',
			'wrapper_class' => 'adfoxly-adzone-rotate-grid-wrapper',
			'default'       => '60',
			'type'          => 'number',
			'min'           => '0',
		),
		'adfoxly-adzone-rotate-grid-columns' => array(
			'label'         => 'Grid columns number',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-rotate-grid-columns',
			'wrapper_id'    => 'adfoxly-adzone-rotate-grid-wrapper',
			'wrapper_class' => 'adfoxly-adzone-rotate-grid-wrapper',
			'default'       => '60',
			'type'          => 'number',
			'min'           => '0',
		),
		'adfoxly-place-ads-list' => array(
			'label'      => 'Included Ads',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-ads-list',
			'default'    => '',
			'wrapper_id' => 'adfoxly-place-ads-list-wrapper',
			'type'       => 'checkbox',
		),
		'adfoxly-place-sticky-position' => array(
			'label'      => 'Position',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-sticky-position',
			'wrapper_id' => 'adfoxly-place-sticky-position-wrapper',
			'default'    => 'bottom',
			'type'       => 'radio',
			'options'    => array(
				'bottom' => 'Bottom',
				'top'    => 'Top',
				'left'   => 'Left',
				'right'  => 'Right'
			),
		),
		'adfoxly-place-sticky-close' => array(
			'label'      => 'Show close button',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-sticky-close',
			'wrapper_id' => 'adfoxly-place-sticky-close-wrapper',
			'default'    => 'yes',
			'type'       => 'radio',
			'options'    => array(
				'yes' => 'Yes',
				'no'  => 'No'
			),
		),
		'adfoxly-place-insidepost-position' => array(
			'label'      => 'Position',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-insidepost-position',
			'wrapper_id' => 'adfoxly-place-insidepost-position-wrapper',
			'default'    => 'middle',
			'type'       => 'radio',
			'options'    => array(
				'middle' => 'In the middle of post',
				'x'      => 'After X paragraphs'
			),
		),
		'adfoxly-place-insidepost-position-paragraph' => array(
			'label'      => 'Choose after which paragraph',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-insidepost-position-paragraph',
			'wrapper_id' => 'adfoxly-place-insidepost-position-paragraph-wrapper',
			'default'    => '0',
			'type'       => 'number',
			'min'        => '0',
		)

	);

	public $meta_fields = array(
		/**
		 * deprecated
		 * still here because of list of functions (eg. animations)
		 */
//		'before_post' => array(
//			'name'    => 'Before Post',
//			'label'   => 'Before Post',
//			'class'   => 'form-control',
//			'id'      => 'before_post',
//			'options' => array(
//				'rotation' => array(
//					'label'   => 'Rotation',
//					'name'    => 'Rotation',
//					'class'   => 'form-control',
//					'id'      => 'before_post_options_rotation',
//					'default' => '',
//					'type'    => 'radio',
//					'options' => array(
//						'refresh' => array(
//							'label' => 'Refresh',
//							'name'  => 'Refresh',
//							'id'    => 'before_post_options_rotation_refresh',
//						),
//						'time'    => array(
//							'label'   => 'Time',
//							'name'    => 'Time',
//							'id'      => 'before_post_options_rotation_time',
//							'type'    => 'radio',
//							'options' => array(
//								'animation' => array(
//									'id'      => 'before_post_options_rotation_time_animation',
//									'label'   => 'Animation',
//									'name'    => 'Animation',
//									'type'    => 'radio',
//									'options' => array(
//										'left'  => array(
//											'label' => 'Left',
//											'name'  => 'Left',
//											'id'    => 'before_post_options_rotation_time_animation_left',
//											'type'  => 'radio',
//										),
//										'right' => array(
//											'label' => 'Right',
//											'name'  => 'Right',
//											'id'    => 'before_post_options_rotation_time_animation_right',
//											'type'  => 'radio',
//										)
//									)
//								),
//								'seconds'   => array(
//									'label' => 'Seconds',
//									'name'  => 'Seconds',
//									'id'    => 'before_post_options_rotation_time_seconds',
//									'type'  => 'radio',
//								)
//							),
//						),
//					)
//				),
//			),
//		),
		/**
		 * end of deprecated
		 */
		array(
			'label'                   => 'Name',
			'class'                   => 'form-control',
			'id'                      => 'adfoxly-place-name',
			'wrapper_class'           => 'adfoxly-place-name',
			'adfoxly_validation_type' => 'invalid-feedback',
			'adfoxly_validation_text' => 'This place name already exists.',
			'default'                 => '',
			'type'                    => 'text',
		),
		array(
			'label'         => 'Rotation',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-how-rotate',
			'default'       => 'refresh',
			'type'          => 'image_radio_label',
			'wrapper_class' => 'adfoxly-adzone-how-rotate-wrapper',
			'wrapper_id'    => 'adfoxly-adzone-how-rotate-wrapper',
			'options'       => array(
				'refresh' => array( 'name' => 'Refresh', 'type' => 'fa-icon', 'image' => 'fas fa-redo' ),
				'time'    => array( 'name' => 'Time', 'type' => 'fa-icon', 'image' => 'fas fa-clock' ),
			),
		),
		array(
			'label'         => 'Rotate time',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-rotate-time',
			'wrapper_id'    => 'adfoxly-adzone-rotate-time-wrapper',
			'wrapper_class' => 'adfoxly-adzone-rotate-time-wrapper',
			'default'       => '60',
			'type'          => 'number',
			'min'           => '0',
		),
		array(
			'label'         => 'Display delay',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-popup-delay',
			'wrapper_id'    => 'adfoxly-adzone-popup-delay-wrapper',
			'wrapper_class' => 'adfoxly-adzone-popup-delay-wrapper',
			'default'       => '0',
			'type'          => 'number',
			'min'           => '0',
		),
		array(
			'label'         => 'Popup repeat',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-popup-repeat',
			'wrapper_id'    => 'adfoxly-adzone-popup-repeat-wrapper',
			'wrapper_class' => 'adfoxly-adzone-popup-repeat-wrapper',
			'default'       => '0',
			'type'          => 'number',
			'min'           => '0',
		),
		array(
			'label'         => 'Slider',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-rotate-slider',
			'wrapper_id'    => 'adfoxly-adzone-rotate-slider-wrapper',
			'wrapper_class' => 'adfoxly-adzone-rotate-slider-wrapper',
			'default'       => '60',
			'type'          => 'number',
			'min'           => '0',
		),
		array(
			'label'         => 'Grid rows number',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-rotate-grid-rows',
			'wrapper_id'    => 'adfoxly-adzone-rotate-grid-wrapper',
			'wrapper_class' => 'adfoxly-adzone-rotate-grid-wrapper',
			'default'       => '60',
			'type'          => 'number',
			'min'           => '0',
		),
		array(
			'label'         => 'Grid columns number',
			'class'         => 'form-control',
			'id'            => 'adfoxly-adzone-rotate-grid-columns',
			'wrapper_id'    => 'adfoxly-adzone-rotate-grid-wrapper',
			'wrapper_class' => 'adfoxly-adzone-rotate-grid-wrapper',
			'default'       => '60',
			'type'          => 'number',
			'min'           => '0',
		),
		array(
			'label'      => 'Included Ads',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-ads-list',
			'default'    => '',
			'wrapper_id' => 'adfoxly-place-ads-list-wrapper',
			'type'       => 'checkbox',
		),
		array(
			'label'      => 'Position',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-sticky-position',
			'wrapper_id' => 'adfoxly-place-sticky-position-wrapper',
			'default'    => 'bottom',
			'type'       => 'radio',
			'options'    => array(
				'bottom' => 'Bottom',
				'top'    => 'Top',
//				'left'   => 'Left',
//				'right'  => 'Right'
			),
		),
		array(
			'label'      => 'Show close button',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-sticky-close',
			'wrapper_id' => 'adfoxly-place-sticky-close-wrapper',
			'default'    => 'yes',
			'type'       => 'radio',
			'options'    => array(
				'yes' => 'Yes',
				'no'  => 'No'
			),
		),
		array(
			'label'      => 'Position',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-insidepost-position',
			'wrapper_id' => 'adfoxly-place-insidepost-position-wrapper',
			'default'    => 'middle',
			'type'       => 'radio',
			'options'    => array(
				'middle' => 'In the middle of post',
				'x'      => 'After X paragraphs'
			),
		),
		array(
			'label'      => 'Choose after which paragraph',
			'class'      => 'form-control',
			'id'         => 'adfoxly-place-insidepost-position-paragraph',
			'wrapper_id' => 'adfoxly-place-insidepost-position-paragraph-wrapper',
			'default'    => '0',
			'type'       => 'number',
			'min'           => '0',
		)

	);

	function __construct() {
	}

	public function listOfPostAndPagesCategories() {
		return get_categories( array(
            'orderby' => 'name',
            'numberposts' => -1
		) );
	}

	public function listOfPostAndPagesTags() {
		return get_tags( array(
            'orderby' => 'name',
            'numberposts' => -1
		) );
	}

	public function listOfPostOrPages() {
		return get_posts( array(
            'orderby' => 'name',
            'numberposts' => -1
		) );
	}

	public function listOfCountries() {
		return array(
			"Afghanistan",
			"Albania",
			"Algeria",
			"American Samoa",
			"Andorra",
			"Angola",
			"Anguilla",
			"Antarctica",
			"Antigua and Barbuda",
			"Argentina",
			"Armenia",
			"Aruba",
			"Australia",
			"Austria",
			"Azerbaijan",
			"Bahamas",
			"Bahrain",
			"Bangladesh",
			"Barbados",
			"Belarus",
			"Belgium",
			"Belize",
			"Benin",
			"Bermuda",
			"Bhutan",
			"Bolivia",
			"Bosnia and Herzegowina",
			"Botswana",
			"Bouvet Island",
			"Brazil",
			"British Indian Ocean Territory",
			"Brunei Darussalam",
			"Bulgaria",
			"Burkina Faso",
			"Burundi",
			"Cambodia",
			"Cameroon",
			"Canada",
			"Cape Verde",
			"Cayman Islands",
			"Central African Republic",
			"Chad",
			"Chile",
			"China",
			"Christmas Island",
			"Cocos (Keeling) Islands",
			"Colombia",
			"Comoros",
			"Congo",
			"Congo, the Democratic Republic of the",
			"Cook Islands",
			"Costa Rica",
			"Cote d'Ivoire",
			"Croatia (Hrvatska)",
			"Cuba",
			"Cyprus",
			"Czech Republic",
			"Denmark",
			"Djibouti",
			"Dominica",
			"Dominican Republic",
			"East Timor",
			"Ecuador",
			"Egypt",
			"El Salvador",
			"Equatorial Guinea",
			"Eritrea",
			"Estonia",
			"Ethiopia",
			"Falkland Islands (Malvinas)",
			"Faroe Islands",
			"Fiji",
			"Finland",
			"France",
			"France Metropolitan",
			"French Guiana",
			"French Polynesia",
			"French Southern Territories",
			"Gabon",
			"Gambia",
			"Georgia",
			"Germany",
			"Ghana",
			"Gibraltar",
			"Greece",
			"Greenland",
			"Grenada",
			"Guadeloupe",
			"Guam",
			"Guatemala",
			"Guinea",
			"Guinea-Bissau",
			"Guyana",
			"Haiti",
			"Heard and Mc Donald Islands",
			"Holy See (Vatican City State)",
			"Honduras",
			"Hong Kong",
			"Hungary",
			"Iceland",
			"India",
			"Indonesia",
			"Iran (Islamic Republic of)",
			"Iraq",
			"Ireland",
			"Israel",
			"Italy",
			"Jamaica",
			"Japan",
			"Jordan",
			"Kazakhstan",
			"Kenya",
			"Kiribati",
			"Korea, Democratic People's Republic of",
			"Korea, Republic of",
			"Kuwait",
			"Kyrgyzstan",
			"Lao, People's Democratic Republic",
			"Latvia",
			"Lebanon",
			"Lesotho",
			"Liberia",
			"Libyan Arab Jamahiriya",
			"Liechtenstein",
			"Lithuania",
			"Luxembourg",
			"Macau",
			"Macedonia, The Former Yugoslav Republic of",
			"Madagascar",
			"Malawi",
			"Malaysia",
			"Maldives",
			"Mali",
			"Malta",
			"Marshall Islands",
			"Martinique",
			"Mauritania",
			"Mauritius",
			"Mayotte",
			"Mexico",
			"Micronesia, Federated States of",
			"Moldova, Republic of",
			"Monaco",
			"Mongolia",
			"Montserrat",
			"Morocco",
			"Mozambique",
			"Myanmar",
			"Namibia",
			"Nauru",
			"Nepal",
			"Netherlands",
			"Netherlands Antilles",
			"New Caledonia",
			"New Zealand",
			"Nicaragua",
			"Niger",
			"Nigeria",
			"Niue",
			"Norfolk Island",
			"Northern Mariana Islands",
			"Norway",
			"Oman",
			"Pakistan",
			"Palau",
			"Panama",
			"Papua New Guinea",
			"Paraguay",
			"Peru",
			"Philippines",
			"Pitcairn",
			"Poland",
			"Portugal",
			"Puerto Rico",
			"Qatar",
			"Reunion",
			"Romania",
			"Russian Federation",
			"Rwanda",
			"Saint Kitts and Nevis",
			"Saint Lucia",
			"Saint Vincent and the Grenadines",
			"Samoa",
			"San Marino",
			"Sao Tome and Principe",
			"Saudi Arabia",
			"Senegal",
			"Seychelles",
			"Sierra Leone",
			"Singapore",
			"Slovakia (Slovak Republic)",
			"Slovenia",
			"Solomon Islands",
			"Somalia",
			"South Africa",
			"South Georgia and the South Sandwich Islands",
			"Spain",
			"Sri Lanka",
			"St. Helena",
			"St. Pierre and Miquelon",
			"Sudan",
			"Suriname",
			"Svalbard and Jan Mayen Islands",
			"Swaziland",
			"Sweden",
			"Switzerland",
			"Syrian Arab Republic",
			"Taiwan, Province of China",
			"Tajikistan",
			"Tanzania, United Republic of",
			"Thailand",
			"Togo",
			"Tokelau",
			"Tonga",
			"Trinidad and Tobago",
			"Tunisia",
			"Turkey",
			"Turkmenistan",
			"Turks and Caicos Islands",
			"Tuvalu",
			"Uganda",
			"Ukraine",
			"United Arab Emirates",
			"United Kingdom",
			"United States",
			"United States Minor Outlying Islands",
			"Uruguay",
			"Uzbekistan",
			"Vanuatu",
			"Venezuela",
			"Vietnam",
			"Virgin Islands (British)",
			"Virgin Islands (U.S.)",
			"Wallis and Futuna Islands",
			"Western Sahara",
			"Yemen",
			"Yugoslavia",
			"Zambia",
			"Zimbabwe"
		);
	}

	public function get_predefined_places() {
		$args = array(
			'post_type'      => 'adfoxly_places',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'meta_query'     => array(
				array(
					'key'     => 'adfoxly-place-category',
					'value'   => 'predefined',
					'compare' => '='
				),
			),
		);

		return get_posts( $args );
	}

	public function get_custom_places() {
		$args = array(
			'post_type'      => 'adfoxly_places',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'meta_query'     => array(
				array(
					'key'     => 'adfoxly-place-category',
					'value'   => 'custom',
					'compare' => '='
				),
			),
		);

		return get_posts( $args );
	}

	public function get_places() {
		$args = array(
			'post_type'      => 'adfoxly_places',
			'post_status'    => 'publish',
			'posts_per_page' => -1
		);

		return get_posts( $args );
	}

	public function get_place( $id ) {
		$place     = get_post( $id, OBJECT );
		$placeMeta = get_post_meta( $id );

		foreach ( $placeMeta as $key => $item ) {
			$key             = str_replace( "-", "_", $key );
			$place->{"$key"} = $item[ 0 ];
		}

		return $place;
	}

	public function get_placeby_banner_id( $id ) {
		$placeMeta = get_post_meta( $id );

		if ( isset( $placeMeta[ 'adfoxly-adzone-place' ][ 0 ] ) && ! empty( $placeMeta[ 'adfoxly-adzone-place' ][ 0 ] ) ) {
			$place     = get_post( $placeMeta[ 'adfoxly-adzone-place' ][ 0 ], OBJECT );
			$placeMeta = get_post_meta( $placeMeta[ 'adfoxly-adzone-place' ][ 0 ] );

			if ( isset( $placeMeta ) && ! empty( $placeMeta ) ) {
				foreach ( $placeMeta as $key => $item ) {
					$key             = str_replace( "-", "_", $key );
					$place->{"$key"} = $item[ 0 ];
				}
			}
			return $place;
		}

	}

	public function getBannersByPlace( $id ) {
		$bannersByPlaceArgs = array(
			'meta_query' => array(
				array(
					'key'     => 'adfoxly-adzone-place',
					'value'   => $id,
					'compare' => 'LIKE'
				)
			),

			'posts_per_page' => - 1,
			'post_type'      => 'adfoxly_banners'
		);
		$bannersByPlace = get_posts( $bannersByPlaceArgs );

		return $bannersByPlace;
	}

	public function insert( $post ) {
		$data = array(
			'post_title'  => sanitize_text_field( $post[ 'adfoxly-place-name' ] ),
			'post_status' => 'publish',
			'post_type'   => 'adfoxly_places',
			'post_author' => get_current_user_id(),
		);

		$result = wp_insert_post( $data );

		return $result;
	}

	public function insert2PlacesData( $post, $post_id ) {

		$place = new AdfoxlyPlacesModel();
//		$data = array();

		if ( isset( $post[ 'predefined_adfoxly-adzone-place' ] )
		     && ! empty( $post[ 'predefined_adfoxly-adzone-place' ] )
		) {
//			$this->popupDelay( $post );
			$this->data[ 'options' ][ 'adfoxly_place_unique_id' ] = $post[ 'predefined_adfoxly-adzone-place' ];

			if ( isset( $post[ 'adfoxly-place-sticky-position' ] ) && $post[ 'predefined_adfoxly-adzone-place' ] === 'sticky' ) {
				$this->data[ 'options' ][ 'adfoxly_place_unique_id' ] = $this->data[ 'options' ][ 'adfoxly_place_unique_id' ] . "_" . $post[ 'adfoxly-place-sticky-position' ];

				if ( isset( $post[ 'adfoxly-place-sticky-close' ] ) && $post[ 'predefined_adfoxly-adzone-place' ] === 'sticky' ) {
					$this->data[ 'options' ][ 'adfoxly_place_sticky_close' ] = $post[ 'adfoxly-place-sticky-close' ];
				}
			}

			if ( isset( $post[ 'predefined_adfoxly-adzone-place' ] ) && $post[ 'predefined_adfoxly-adzone-place' ] === 'inside_post' ) {
				if ( isset( $post[ 'adfoxly-place-insidepost-position' ] ) && $post[ 'adfoxly-place-insidepost-position' ] === 'middle' ) {
					$this->data[ 'options' ][ 'adfoxly_place_unique_id' ] = $this->data[ 'options' ][ 'adfoxly_place_unique_id' ] . "_" . $post[ 'adfoxly-place-insidepost-position' ];
				} else if ( isset( $post[ 'adfoxly-place-insidepost-position' ] ) && $post[ 'adfoxly-place-insidepost-position' ] === 'x' ) {
					if ( isset( $post[ 'adfoxly-place-insidepost-position-paragraph' ] ) && ! empty( $post[ 'adfoxly-place-insidepost-position-paragraph' ] ) ) {
						$this->data[ 'options' ][ 'adfoxly_place_unique_id' ]   = $this->data[ 'options' ][ 'adfoxly_place_unique_id' ] . "_" . $post[ 'adfoxly-place-insidepost-position' ] . "_" . $post[ 'adfoxly-place-insidepost-position-paragraph' ];
					}
				}
			}

			if ( isset( $this->data ) && isset( $this->data[ 'options' ] ) && isset( $this->data[ 'options' ][ 'adfoxly_place_unique_id' ] ) ) {
				$getPlaceIDArgs = array(
					'meta_query'     => array(
						array(
							'key'   => 'adfoxly_place_unique_id',
							'value' => $this->data[ 'options' ][ 'adfoxly_place_unique_id' ]
						)
					),
					'post_type'      => 'adfoxly_places',
					'posts_per_page' => - 1,
					'fields'         => 'ids'
				);
				$getPlaceID = get_posts( $getPlaceIDArgs );
			}


			if ( isset( $getPlaceID ) && ! empty( $getPlaceID ) ) {
				$newPlaceID = intval( $getPlaceID[ 0 ] );
				add_post_meta( $post_id, sanitize_text_field( 'adfoxly-adzone-place' ), sanitize_text_field( $newPlaceID ) );

			} else {
				$placeResult = $place->insert( $post );
				$newPlaceID  = intval( $placeResult );

				$this->data[ 'options' ][ 'adfoxly-place-category' ]  = 'custom';
				$this->data[ 'options' ][ 'adfoxly_place_type' ]      = $post[ 'predefined_adfoxly-adzone-place' ];
				$this->data[ 'options' ][ 'adfoxly_place_unique_id' ] = $post[ 'predefined_adfoxly-adzone-place' ];

				if ( isset( $post[ 'adfoxly-place-sticky-position' ] ) && $post[ 'predefined_adfoxly-adzone-place' ] === 'sticky' ) {
					$this->data[ 'options' ][ 'adfoxly_place_unique_id' ] = $this->data[ 'options' ][ 'adfoxly_place_unique_id' ] . "_" . $post[ 'adfoxly-place-sticky-position' ];

					if ( isset( $post[ 'adfoxly-place-sticky-close' ] ) && $post[ 'predefined_adfoxly-adzone-place' ] === 'sticky' ) {
						$this->data[ 'options' ][ 'adfoxly_place_sticky_close' ] = $post[ 'adfoxly-place-sticky-close' ];
					}
				}

				if ( isset( $post[ 'predefined_adfoxly-adzone-place' ] ) && $post[ 'predefined_adfoxly-adzone-place' ] === 'inside_post' ) {

					if ( isset( $post[ 'adfoxly-place-insidepost-position' ] ) && $post[ 'adfoxly-place-insidepost-position' ] === 'middle' ) {
						$this->data[ 'options' ][ 'adfoxly_place_unique_id' ] = $this->data[ 'options' ][ 'adfoxly_place_unique_id' ] . "_" . $post[ 'adfoxly-place-insidepost-position' ];
					} else if ( isset( $post[ 'adfoxly-place-insidepost-position' ] ) && $post[ 'adfoxly-place-insidepost-position' ] === 'x' ) {
						if ( isset( $post[ 'adfoxly-place-insidepost-position-paragraph' ] ) && ! empty( $post[ 'adfoxly-place-insidepost-position-paragraph' ] ) ) {
							$this->data[ 'options' ][ 'adfoxly_place_unique_id' ]   = $this->data[ 'options' ][ 'adfoxly_place_unique_id' ] . "_" . $post[ 'adfoxly-place-insidepost-position' ] . "_" . $post[ 'adfoxly-place-insidepost-position-paragraph' ];
							$this->data[ 'options' ][ 'adfoxly_place_x_paragraph' ] = true;
							$this->data[ 'options' ][ 'adfoxly_place_x_number' ]    = $post[ 'adfoxly-place-insidepost-position-paragraph' ];
						}
					}
				}

				if ( isset( $post[ 'predefined_adfoxly-adzone-place' ] )
				     &&
				     (
					     $post[ 'predefined_adfoxly-adzone-place' ] === 'shortcode'
					     || $post[ 'predefined_adfoxly-adzone-place' ] === 'widget'
				     )
				) {
					$this->data[ 'options' ][ 'adfoxly_place_unique_id' ] = $this->data[ 'options' ][ 'adfoxly_place_unique_id' ] . "_" . $newPlaceID;
				}

				if ( isset( $placeResult ) && ! is_wp_error( $placeResult ) ) {
					$place->insert_meta( $newPlaceID, $post, $this->data[ 'options' ] );
					delete_metadata( 'post', $post_id, 'adfoxly-adzone-place', false, false );
					add_post_meta( $post_id, sanitize_text_field( 'adfoxly-adzone-place' ), sanitize_text_field( $newPlaceID ) );

				}
			}

		} else if ( ! isset( $post[ 'predefined_adfoxly-adzone-place' ] ) && isset( $post[ 'adfoxly-adzone-place' ] ) ) {
//			if ( isset( $post[ 'adfoxly-adzone-popup-delay' ] ) && !empty( $post[ 'adfoxly-adzone-popup-delay' ] ) ) {
//				$this->data[ 'options' ][ 'adfoxly-adzone-popup-delay' ] = $post[ 'adfoxly-adzone-popup-delay' ];
//			}

//			$this->popupDelay( $post );
			$getPlaceIDArgs = array(
				'meta_query'     => array(
					array(
						'key'   => 'adfoxly_place_unique_id',
						'value' => $post[ 'adfoxly-adzone-place' ]
					)
				),
				'post_type'      => 'adfoxly_places',
				'posts_per_page' => - 1,
				'fields'         => 'ids'
			);

			$getPlaceID = get_posts( $getPlaceIDArgs );
			$newPlaceID = intval( $getPlaceID[ 0 ] );
			delete_metadata( 'post', $post_id, 'adfoxly-adzone-place', false, false );
			$place->insert_meta( $newPlaceID, $post );
		}

		if ( isset( $post[ 'adfoxly-adzone-place' ] )
		     && ! empty( $post[ 'adfoxly-adzone-place' ] )
		) {
			delete_metadata( 'post', $post_id, 'adfoxly-adzone-place', false, false );
			add_post_meta( $post_id, sanitize_text_field( 'adfoxly-adzone-place' ), sanitize_text_field( $newPlaceID ) );
		}

		if ( isset( $newPlaceID ) && ! empty( $newPlaceID ) ) {
			return $newPlaceID;
		}

	}

	public function update( $post ) {
		$data = array(
			'ID'         => sanitize_text_field( $post[ 'adfoxly-place-id' ] ),
			'post_title' => sanitize_text_field( $post[ 'adfoxly-place-name' ] ),
		);

		$result = wp_update_post( $data );

		return $result;
	}

	public function insert_meta( $result, $data, $options = null ) {
		$post_id = $result;
		foreach ( $data as $key => $meta_field ):
			foreach ( $this->meta_fields as $meta_key => $meta_value ) {
				if ( $meta_value[ 'id' ] === $key ) {
					if ( isset( $meta_field ) && ! empty( $meta_field ) ) {
						update_post_meta( $post_id, sanitize_text_field( $key ), sanitize_text_field( $meta_field ) );
					}
				}
			}

			if ( isset( $options ) && ! empty( $options ) ) {
				foreach ( $options as $option_key => $option_value ) {
					update_post_meta( $post_id, sanitize_text_field( $option_key ), sanitize_text_field( $option_value ) );
				}
			}
		endforeach;

		if ( ! isset( $data[ 'adfoxly-place-ads-list' ] ) || empty( $data[ 'adfoxly-place-ads-list' ] ) ) {
			if ( isset( $_GET[ 'edit' ] ) ) {
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
				$selectedAdsConnectedToPlace     = get_posts( $selectedAdsConnectedToPlaceArgs );

				foreach ( $selectedAdsConnectedToPlace as $adID ) {
					$adID = (int) $adID;
					delete_post_meta( $adID, 'adfoxly-adzone-place', $g_id_int );
				}
			}
		} else {
			if ( isset( $_GET[ 'edit' ] ) ) {
				$g_id = $_GET[ 'edit' ];
				if ( $_GET[ 'edit' ] === 'new' ) {
					$g_id = $post_id;
				}
				$g_id_int = intval( $g_id );

				// remove meta if checkbox is not selected
				$selectedAdsConnectedToPlaceArgs = array(
					'meta_query'     => array(
						array(
							'id'      => 'adfoxly-adzone-place',
							'value'   => $g_id_int,
							'compare' => 'LIKE'
						)
					),
					'posts_per_page' => - 1,
					'post_type'      => 'adfoxly_banners',
					'fields'         => 'ids'
				);
				$selectedAdsConnectedToPlace     = get_posts( $selectedAdsConnectedToPlaceArgs );
				foreach ( $selectedAdsConnectedToPlace as $place ) {
					if ( ! in_array( $place, $data[ 'adfoxly-place-ads-list' ] ) ) {
						$place = (int) $place;
						delete_post_meta( $place, 'adfoxly-adzone-place', $g_id_int );
					}
				}

				// add meta - $g_id_int (place id) into ad id, if checkbox is selected
				foreach ( $data[ 'adfoxly-place-ads-list' ] as $selectedPlace ) {
					$get_ad_place = get_post_meta( $selectedPlace, 'adfoxly-adzone-place' );
					if ( empty( $get_ad_place ) || ( ! empty( $get_ad_place ) && ! in_array( $g_id_int, $get_ad_place ) ) ) {
						add_post_meta( $selectedPlace, 'adfoxly-adzone-place', $g_id_int );
					}
				}
			}
		}
	}

	public function getPlaceIDArgs( $value ) {
		$getPlaceIDArgs = array(
			'meta_query'     => array(
				array(
					'key'   => 'adfoxly_place_unique_id',
					'value' => $value
				)
			),
			'post_type'      => 'adfoxly_places',
			'posts_per_page' => -1,
			'fields'         => 'ids'
		);

		return get_posts( $getPlaceIDArgs );
	}

	// todo: move to campaign
	public function get_campaigns_by_ad_id( $id ) {
		$args = array(
			'meta_query'     => array(
				array(
					'key'     => 'adfoxly-ad-campaign',
					'value'   => $id,
					'compare' => 'LIKE'
				)
			),
			'post_type'      => 'adfoxly_ad_campaign',
			'posts_per_page' => - 1
		);

		return get_posts( $args );
	}

	// Register Custom Post Type
	static public function adfoxly_places() {
		$adfoxly_places_labels = array(
			'name'                  => _x( 'Places', 'Post Type General Name', 'adfoxly' ),
			'singular_name'         => _x( 'Place', 'Post Type Singular Name', 'adfoxly' ),
			'menu_name'             => __( 'Ads Manager', 'adfoxly' ),
			'name_admin_bar'        => __( 'Ads Manager', 'adfoxly' ),
			'archives'              => __( 'Item Archives', 'adfoxly' ),
			'attributes'            => __( 'Item Attributes', 'adfoxly' ),
			'parent_item_colon'     => __( 'Parent Item:', 'adfoxly' ),
			'all_items'             => __( 'All Places', 'adfoxly' ),
			'add_new_item'          => __( 'Add New Item', 'adfoxly' ),
			'add_new'               => __( 'Add Place', 'adfoxly' ),
			'new_item'              => __( 'New Place', 'adfoxly' ),
			'edit_item'             => __( 'Edit Place', 'adfoxly' ),
			'update_item'           => __( 'Update Place', 'adfoxly' ),
			'view_item'             => __( 'View Place', 'adfoxly' ),
			'view_items'            => __( 'View Place', 'adfoxly' ),
			'search_items'          => __( 'Search Place', 'adfoxly' ),
			'not_found'             => __( 'Not found', 'adfoxly' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'adfoxly' ),
			'featured_image'        => __( 'Featured Image', 'adfoxly' ),
			'set_featured_image'    => __( 'Set featured image', 'adfoxly' ),
			'remove_featured_image' => __( 'Remove featured image', 'adfoxly' ),
			'use_featured_image'    => __( 'Use as featured image', 'adfoxly' ),
			'insert_into_item'      => __( 'Insert into item', 'adfoxly' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'adfoxly' ),
			'items_list'            => __( 'Items list', 'adfoxly' ),
			'items_list_navigation' => __( 'Items list navigation', 'adfoxly' ),
			'filter_items_list'     => __( 'Filter items list', 'adfoxly' ),
		);
		$adfoxly_places_args   = array(
			'label'               => __( 'Places', 'adfoxly' ),
			'description'         => __( 'Post Type Description', 'adfoxly' ),
			'labels'              => $adfoxly_places_labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'menu_position'       => 75,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
			'show_in_rest'        => false,
		);
		register_post_type( 'adfoxly_places', $adfoxly_places_args );
	}

	static public function registerPostType() {
		if ( ! function_exists( 'adfoxly_places' ) ) {
			add_action( 'init', array( get_called_class(), 'adfoxly_places' ), 0 );
		}
	}
}
