<?php

class AdfoxlyNewController {

	public $context;
	public $settings;

	/**
	 *
	 */

	public function verifyEmptyInputs() {
		if ( ! isset( $_POST[ 'adfoxly-ad-name' ] ) || empty( $_POST[ 'adfoxly-ad-name' ] ) ) {
			if ( isset( $_POST[ 'adfoxly-banner-id' ] ) && ! empty( $_POST[ 'adfoxly-banner-id' ] ) ) {
				$getTheDate = get_the_date( 'Y-m-d H:i:s',  $_POST[ 'adfoxly-banner-id' ] );
				$_POST[ 'adfoxly-ad-name' ] = "Ad (" . $getTheDate . ")";
			} else {
				$_POST[ 'adfoxly-ad-name' ] = "Ad (" . date( 'Y-m-d H:i:s' ) . ")";
			}
		}


		if ( ! isset( $_POST[ 'adfoxly-campaign-name' ] ) || empty( $_POST[ 'adfoxly-campaign-name' ] ) ) {
			$_POST[ 'adfoxly-campaign-name' ] = "Campaign (" . date( 'Y-m-d H:i:s' ) . ")";
		}
	}

	public function catchAdsPOSTRequest() {

		$banner = new AdfoxlyBannerModel();
		if ( isset( $_POST ) && ! empty( $_POST ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ) {

			if ( isset( $_FILES ) && ! empty( $_FILES ) ) {
				$handle  = fopen( $_FILES[ 'file' ][ 'tmp_name' ], "r" );
				$headers = fgetcsv( $handle, 1000, ";" );
				$i = 0;
				foreach ( $headers as $header ) {
					$iName[$i] = $header;
					$i++;
				}

				while ( ( $data = fgetcsv( $handle, 1000, ";" ) ) !== false ) {
					for ($e=0;$e<count($data);$e++) {
						$_POST[ $iName[ $e ] ] = $data[ $e ];
					}

					$result = $banner->insert( $_POST );
					$action = 'new';
					if ( isset( $result ) && ! is_wp_error( $result ) && ! empty( $action ) ) {
						$banner->insert_meta( $result, $result, $action );

						$campaign = new AdfoxlyCampaignModel();
						$place    = new AdfoxlyPlacesModel();

						$campaign->insert( $_POST, $result );
						$shortcodePlaceID = $place->insert2PlacesData( $_POST, $result );
					}
				}
				fclose( $handle );
			} else {
				$this->verifyEmptyInputs();

				if ( $_GET[ 'page' ] === 'adfoxly-new' ):
					$result = $banner->insert( $_POST );
					$action = 'new';
				elseif ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) ):
					$result = $banner->update( $_POST );
					$action = 'edit';
				endif;

				if ( isset( $result ) && ! is_wp_error( $result ) && ! empty( $action ) ) {
					$banner->insert_meta( $result, $result, $action );

					$campaign = new AdfoxlyCampaignModel();
					$place    = new AdfoxlyPlacesModel();

					$campaign->insert( $_POST, $result );
					$shortcodePlaceID = $place->insert2PlacesData( $_POST, $result );
				}

				if ( isset( $_POST[ 'predefined_adfoxly-adzone-place' ] ) && $_POST[ 'predefined_adfoxly-adzone-place' ] === 'shortcode' && isset( $shortcodePlaceID ) && ! empty( $shortcodePlaceID ) ) {
					$redirect = admin_url( 'admin.php?page=adfoxly-banners&info=shortcode&id=' . $shortcodePlaceID );
				} else if ( isset( $_POST[ 'predefined_adfoxly-adzone-place' ] ) && $_POST[ 'predefined_adfoxly-adzone-place' ] === 'widget' && isset( $shortcodePlaceID ) && ! empty( $shortcodePlaceID ) ) {
					$redirect = admin_url( 'admin.php?page=adfoxly-banners&info=widget&id=' . $shortcodePlaceID );
				} else if ( ( isset( $_POST[ 'predefined_adfoxly-adzone-place' ] ) ) && ( $_POST[ 'predefined_adfoxly-adzone-place' ] !== 'shortcode' || $_POST[ 'predefined_adfoxly-adzone-place' ] !== 'widget' ) && isset( $shortcodePlaceID ) && ! empty( $shortcodePlaceID ) ) {
					$redirect = admin_url( 'admin.php?page=adfoxly-banners&info=success' );
				} else {
					$redirect = admin_url( 'admin.php?page=adfoxly-banners' );
				}
				echo '<script>window.location.href = "' . $redirect . '";</script>';
			}
		}

		if ( isset( $_GET[ 'remove' ] ) && ! empty( $_GET[ 'remove' ] ) ) {
			if ( is_array( $_GET[ 'remove' ] ) ) {
				foreach ( $_GET[ 'remove' ] as $remove ) {
					$this->removeStatistics( $remove );
					wp_delete_post( $remove );
				}
			} else {
				$this->removeStatistics( $_GET[ 'remove' ] );
				wp_delete_post( $_GET[ 'remove' ] );
			}

		}
	}

	public function viewV2() {
//		if ( isset( $this->settings[ 'adfoxly-navbar' ] ) && ! empty( $this->settings[ 'adfoxly-navbar' ] ) && $this->settings[ 'adfoxly-navbar' ] === 'true' ):
			$navbar = new AdfoxlyAdminNavbarController();
			$navbar->render();
//		endif;

		$this->context[ 'v2' ] = true;
		if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'adfoxly-new' ):
			$this->context[ 'page' ] = 'adfoxly-new';
		endif;
		if ( isset( $_GET[ 'wizard' ] ) && $_GET[ 'wizard' ] == 'no' ):
			$this->context[ 'wizard' ] = 'no';
		endif;

		// save form
//		if ( isset( $_POST ) && ! empty( $_POST ) && isset( $_REQUEST[ '_wpnonce' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ] ) ):
//
//		endif;

		// remove ad
		if ( isset( $_GET[ 'remove' ] ) && ! empty( $_GET[ 'remove' ] ) ):
			$this->removeStatistics( $_GET[ 'remove' ] );
			wp_delete_post( $_GET[ 'remove' ] );
		endif;
	}

	public function removeStatistics( $id ) {
		$statistics = new AdfoxlyStatisticsModel();
		if ( is_numeric( $_GET[ 'remove' ] ) ) {
			$statistics->removeClicks( htmlspecialchars( $id ) );
		}

	}

	public function view() {
		$banner = new AdfoxlyBannerModel();

		/**
		 * Catch the POST from adfoxly-new
		 * @see: admin.php?page=adfoxly-new
		 **/
		$this->catchAdsPOSTRequest(); // ads as banner/wizard
		/**
		 * Load Admin Navbar
		 **/
		$this->settings = get_option( 'adfoxly_settings' );
//		if ( isset( $this->settings[ 'adfoxly-navbar' ] ) && ! empty( $this->settings[ 'adfoxly-navbar' ] ) && $this->settings[ 'adfoxly-navbar' ] === 'true' ) {
			$navbar = new AdfoxlyAdminNavbarController();
			$navbar->render();
//		}

		if (
			isset( $_GET['info'] )
			&& ! empty( $_GET[ 'info' ] )
			&& isset( $_GET['id'] )
			&& ! empty( $_GET[ 'id' ] )
			&& $_GET[ 'info' ] === 'shortcode'
			&& is_numeric( $_GET[ 'id' ] )
		) {
			$id = $_GET[ 'id' ];
			echo "<script>
			jQuery(document).ready(function($) {				
				swal({
				  title: \"Shortcode generated!\",
				  text: \"Please copy your into you clipboard which is: [adfoxly place='$id']\",
				  icon: \"success\",
				  button: \"Copied!\",
				});			
			});</script>";
		} else if (
			isset( $_GET['info'] )
			&& ! empty( $_GET[ 'info' ] )
			&& isset( $_GET['id'] )
			&& ! empty( $_GET[ 'id' ] )
			&& $_GET[ 'info' ] === 'widget'
			&& is_numeric( $_GET[ 'id' ] )
		) {
			echo "<script>
			jQuery(document).ready(function($) {				
				swal({
				  title: \"Your a is ready as widget!\",
				  text: \"Do you want open Default WordPress Widgets Manager, right now?\",
				  icon: \"success\",
				  buttons: {
				    cancel: \"No!\",
				    go: {
				        text: \"Yes, take me there!\",
				        value: \"go\"
				    }
				  }
				}).then((value) => {
				  switch (value) {				
				    case \"go\":
				      window.location.href = \"/wp-admin/widgets.php\";
				      break;				
				  }
				});			
			});</script>";
		} else if (
			isset( $_GET['info'] )
			&& ! empty( $_GET[ 'info' ] )
			&& $_GET[ 'info' ] === 'success'
		) {
			echo "<script>
			jQuery(document).ready(function($) {				
				swal({
				  title: \"Success\",
				  text: \"Ad is successfully inserted. You can visit your website and check it.\",
				  icon: \"success\",
				  button: \"Done\",
				});			
			});</script>";
		}

		/**
		 * Load Common Variables
		 **/

		$this->context[ 'admin' ][ 'url' ] = admin_url();

		if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) ) {
			$this->context[ 'edit' ] = $_GET[ 'edit' ];
			$bannerIsset = $banner->getBanner( $_GET['edit'] );

			if (
				! isset( $bannerIsset )
				|| empty( $bannerIsset )
				|| ! isset( $bannerIsset['details'] )
				|| $bannerIsset['details'] === NULL
			) {
				$this->context[ 'error' ]       = 'true';
				$this->context[ 'errorReason' ] = 'adDoesntExists';
			} elseif (
				isset( $_GET[ 'edit' ] )
				&& ! empty( $_GET[ 'edit' ] )
				&& ! is_numeric( $_GET[ 'edit' ] )
			) {
				$this->context[ 'error' ]       = 'true';
				$this->context[ 'errorReason' ] = 'nonNumericValue';
			} else {
				$this->context[ 'title' ]    = 'Edit advert';
				$this->context[ 'ads_header' ] = Timber::compile( 'group-header.twig', $this->context );
			}
		} else {
			if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] === 'adfoxly-banners' && ! isset( $_GET[ 'edit' ] ) ) {
				$this->context[ 'title' ]    = 'List of your ads';
			} else {
				$this->context[ 'title' ]    = 'Create new ad';
			}


			$this->context[ 'ads_header' ] = Timber::compile( 'group-header.twig', $this->context );
		}
		if ( isset( $_GET[ 'page' ] ) && ! empty( $_GET[ 'page' ] ) ) {
			$this->context[ 'page' ] = $_GET[ 'page' ];
		}
		if ( isset( $_GET[ 'wizard' ] ) && ! empty( $_GET[ 'wizard' ] ) ) {
			$this->context[ 'wizard' ] = $_GET[ 'wizard' ];
		}

		/**
		 * Generate AdFoxly Main Form
		 * @see: admin.php?page=adfoxly-new
		 **/
		$form  = new AdfoxlyFormController();

		$array = array( 'type' => 'format' );
		if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) ) {
			$array[ 'banner_id' ] = $_GET[ 'edit' ];
		}
		$this->context[ 'format' ] = $form->generate( $array );

		$array = array( 'type' => 'image' );
		if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) ) {
			$array[ 'banner_id' ] = $_GET[ 'edit' ];
		}
		$this->context[ 'image' ] = $form->generate( $array );

		$array = array( 'type' => 'spot' );
		if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) ) {
			$array[ 'banner_id' ] = $_GET[ 'edit' ];
		}
		$this->context[ 'spot' ] = $form->generate( $array );

		$array = array( 'type' => 'places_settings' );
		if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) ) {
			$array[ 'banner_id' ] = $_GET[ 'edit' ];
		}
		$this->context[ 'places_settings' ] = $form->generate( $array );

		$array = array( 'type' => 'campaign' );
		if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) ) {
			$array[ 'banner_id' ] = $_GET[ 'edit' ];
		}
		$this->context[ 'campaign' ] = $form->generate( $array );

		$this->context[ 'banners' ] = $banner->getBannersWithMetaForTwig();

		$places               = new AdfoxlyPlacesModel();
		$numberOfCustomPlaces = $places->get_custom_places();


		if ( isset( $numberOfCustomPlaces ) && empty( $numberOfCustomPlaces ) ) {
			$this->context[ 'number_of_places' ] = 0;
			$this->context[ 'places_exists' ]    = 'false';
		} else {
			$this->context[ 'number_of_places' ] = count( $numberOfCustomPlaces );
			$this->context[ 'places_exists' ]    = 'true';
		}
	}

	public function isWizard() {
		if (
			( ! isset( $_POST ) || empty( $_POST ) )
			&& isset( $_GET[ 'page' ] )
			&& $_GET[ 'page' ] == 'adfoxly-new'
			&& isset( $this->settings[ 'adfoxly-wizard' ] )
			&& $this->settings[ 'adfoxly-wizard' ] == 'false'
			&& (
				! isset( $_GET[ 'wizard' ] )
				|| ( $_GET[ 'wizard' ] !== 'false' && $_GET[ 'wizard' ] !== 'true' )
			)
		) {
			$redirect = admin_url( 'admin.php?page=adfoxly-new&wizard=false' );
			echo '<script>window.location.href = "' . $redirect . '";</script>';
		}

		if (
			( ! isset( $_POST ) || empty( $_POST ) )
			&& isset( $_GET[ 'page' ] )
			&& isset( $_GET[ 'edit' ] )
			&& $_GET[ 'page' ] == 'adfoxly-banners'
			&& is_numeric( $_GET[ 'edit' ] )
			&& isset( $this->settings[ 'adfoxly-wizard' ] )
			&& $this->settings[ 'adfoxly-wizard' ] == 'false'
			&& (
				! isset( $_GET[ 'wizard' ] )
				|| ( $_GET[ 'wizard' ] !== 'false' && $_GET[ 'wizard' ] !== 'true' )
			)
		) {
			$redirect = admin_url( 'admin.php?page=adfoxly-banners&edit=' . $_GET[ 'edit' ] . '&wizard=false' );
			echo '<script>window.location.href = "' . $redirect . '";</script>';
		}
	}

	public function index() {

		$this->settings = get_option( 'adfoxly_settings' );

		$this->isWizard();
		$this->view();

		$this->context[ 'wp_create_nonce' ] = wp_create_nonce();

		if ( isset( $_GET ) && isset( $_GET[ 'bulk' ] ) && $_GET[ 'bulk' ] === 'true' ) {
			if ( isset( $_FILES ) && ! empty( $_FILES ) ) {
				$handle  = fopen( $_FILES[ 'file' ][ 'tmp_name' ], "r" );
				$headers = fgetcsv( $handle, 1000, ";" );
				while ( ( $data = fgetcsv( $handle, 1000, ";" ) ) !== false ) {
//					var_dump( $data );
				}
				fclose( $handle );
			}
			Timber::render( basename( __FILE__, '.php' ) . '-bulk.twig', $this->context );
		} else {
			Timber::render( basename( __FILE__, '.php' ) . '.twig', $this->context );
		}



	}
}

$render = new AdfoxlyNewController();
$render->index();
