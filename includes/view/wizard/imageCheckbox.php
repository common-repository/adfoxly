<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class wizardImageCheckbox {

	/**
	 * @var \adfoxlyadfoxlyPlacesController
	 */
	private $places_controller;

	public function render( $banner_data, $output, $meta_field, $key, $field, $array = null ) {

		if ( $meta_field[ 'type' ] == 'image_checkbox' ) {
			$html_type   = 'checkbox';
			$design_type = 'check';
		} else if ( $meta_field[ 'type' ] == 'image_radio' || $meta_field['type'] == 'image_radio_label' ) {
			$html_type   = 'radio';
			$design_type = 'radio';
		}

		if (
			( ! isset( $array ) || $array === null || ! isset( $field[ 'category' ] ) )
			|| ( isset( $array[ 'category' ] ) && isset( $field[ 'category' ] ) && $field[ 'category' ] === $array[ 'category' ] )
		) {
			$output .= '<div class="col-md-6 col-lg-3 grid-margin stretch-card">';
			$output .= '<div class="bootstrap4-card">';
			$output .= '<label for="' . $meta_field[ "id" ] . '_' . $key . '" class="file-item ' . $meta_field[ "id" ] . ' ' . $meta_field[ "id" ] . '_' . $key;
			if ( isset( $field[ 'category' ] ) && ! empty( $field[ 'category' ] ) ) {
				$output .= ' ' . $meta_field[ "id" ] . '_' . $field[ "category" ];
			}
			$output .= '">';
			$output .= '<span class="file-preview pdf">';

			if ( $field[ 'type' ] === 'fa-icon' ) {

				$output .= "<i class='" . $field[ 'image' ] . "' style='display: block; margin: 0 auto; max-width: 70px; height: 100%;'></i>";

			} else if ( $field[ 'type' ] === 'img' ) {

				$img_url = plugins_url( "admin/img/zones/{$field['image']}", dirname( dirname( dirname( __FILE__ ) ) ) );
				$output  .= "<img src='" . $img_url . "' style='display: block; margin: 0 auto; max-width: 60px;'/>";

			} else {
				$output .= '<i class="fa fa-file"></i>';
			}

			$output .= '</span>';
			$output .= '<div class="file-info">';

			$output .= '<div class="">';


			if ( $meta_field[ 'type' ] === 'image_radio' || $meta_field[ 'type' ] === 'image_radio_label' ) {

				// todo loop to much data - example: echo "test" here;
//				echo "<pre>";
//				$banner_data, $output, $meta_field, $key, $field, $array
//				var_dump($banner_data);
//				exit();
//				echo "</pre>";
//				echo "<pre>";
//				var_dump($meta_field);
//				echo "</pre>";

				$output .= '<div class="custom-control custom-radio">';
				//                      <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
				//                      <label class="custom-control-label" for="customRadio1">Toggle this custom radio</label>
				//                    </div>
				//									$output .= '<div class="icheck-square">';
				$slug = strtolower( str_replace( ' ', '-', $field[ 'name' ] ) );

				if ( isset( $field[ 'category' ] ) && $field[ 'category' ] === 'predefined' ) {
					$output .= '<input type="radio" id="' . $meta_field[ 'id' ] . '_' . $key . '" name="predefined_' . $meta_field[ 'id' ] . '" value="' . $key . '" class="custom-control-input adfoxly-input-slug-' . $slug . '"';
				} else {
					$output .= '<input type="radio" id="' . $meta_field[ 'id' ] . '_' . $key . '" name="' . $meta_field[ 'id' ] . '" value="' . $key . '" class="custom-control-input adfoxly-input-slug-' . $slug . '"';
				}

				if (
					(
						isset( $meta_field[ 'default' ] )
						&& ! empty( $meta_field[ 'default' ] )
						&& $meta_field[ 'default' ] === $key
					)
					|| (
						! empty( $banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] )
						&& $key === intval( $banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] )
					)
				) {
					$output .= ' checked ';
				}

				if (
					isset( $banner_data )
					&& isset( $banner_data[ 'meta' ][ 'adfoxly-format' ][ 0 ] )
					&& ! empty( $banner_data[ 'meta' ][ 'adfoxly-format' ][ 0 ] )
					&& $banner_data['meta']['adfoxly-format'][0] == $key
				) {
					$output .= ' checked ';
				}

			} else {

				$output .= '<div class="custom-control custom-checkbox form-' . $design_type . ' form-' . $design_type . '-flat">';
				//									$output .= '<div class="custom-control custom-checkbox">';
				//									$output .= '<label class="custom-control-label" for="customCheck1">Check this custom checkbox</label>';
				//									$output .= '</div>';
				//									$output .= '<label class="form-check-label" for="' . $meta_field[ "id" ] . '_' . $key . '">';
				//									$output .= '<input id="' . $meta_field[ "id" ] . '_' . $key . '" name="' . $meta_field[ "id" ] . '[]" type="' . $html_type . '" class="form-check-input"';
				$slug = strtolower( str_replace( ' ', '-', $field[ 'name' ] ) );
				$output .= '<input id="' . $meta_field[ "id" ] . '_' . $key . '" name="' . $meta_field[ "id" ] . '[]" type="' . $html_type . '" class="custom-control-input adfoxly-input-slug-' . $slug . '"';
			}

			//								if ( $key === intval( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] ) ) {
			//									echo $key;
			//								}

			// todo it could work, because $meta_value is not set
//			if ( ( ! empty( $meta_value ) && in_array( $key, $meta_value ) )
//			     || ( ! empty( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] ) && in_array( $key, unserialize( $this->banner_data[ 'meta' ][ 'adfoxly-adzone-place' ][ 0 ] ) ) )
//			     || ( isset( $meta_field[ 'options' ][ $key ][ 'checked' ] ) && $meta_field[ 'options' ][ $key ][ 'checked' ] === true )
//			):
//				$output .= " checked ";
//			endif;


//			var_dump($banner_data[ 'meta' ][ 'adfoxly-adzone-place' ][0]);

//			var_dump($banner_data);
//			exit();
//			echo "<pre>";
//			var_dump( $banner_data[ 'meta' ][ 'adfoxly-adzone-place' ][0] );
//			exit();

//			$banner_data[ 'meta' ][ 'adfoxly-adzone-place' ][0]

			if ( isset( $banner_data ) && isset( $banner_data[ 'meta' ][ 'adfoxly-adzone-place' ][ 0 ] ) && ! empty( $banner_data[ 'meta' ][ 'adfoxly-adzone-place' ][ 0 ] ) ) {
				$uniqueID = get_post_meta( $banner_data[ 'meta' ][ 'adfoxly-adzone-place' ][0], 'adfoxly_place_unique_id', true );
			}


//			var_dump(  );
//			exit();

			if ( isset( $banner_data )
			     && isset( $banner_data[ 'meta' ][ 'adfoxly-adzone-place' ] )
			     && ! empty( $banner_data[ 'meta' ][ 'adfoxly-adzone-place' ] )
			     &&
			     (
				     in_array( $key, $banner_data[ 'meta' ][ 'adfoxly-adzone-place' ] )
				     || ( isset( $uniqueID ) && ! empty( $uniqueID ) && $uniqueID === $key )
			     )
			):
				$output .= " checked ";
			endif;


			if ( isset( $meta_field[ 'options' ][ $key ][ 'pro' ] ) && $meta_field[ 'options' ][ $key ][ 'pro' ] === true ):
				$output .= " disabled ";
			endif;

			if ( isset( $meta_field[ 'required' ] ) && ! empty( $meta_field[ 'required' ] ) && $meta_field[ 'required' ] === true ):
				//						$output .= " required ";
			endif;

			if ( isset( $meta_field[ 'data-parsley-mincheck' ] ) && ! empty( $meta_field[ 'data-parsley-mincheck' ] ) ):
				$output .= " data-parsley-multiple=" . $meta_field[ 'data-parsley-multiple' ] . " ";
			endif;

			if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
				$output .= " data-parsley-errors-container=" . $meta_field[ 'data-parsley-errors-container' ] . " ";
			endif;

			if ( isset( $meta_field[ 'data-parsley-errors-container' ] ) && ! empty( $meta_field[ 'data-parsley-errors-container' ] ) ):
				$output .= " data-parsley-errors-container=" . $meta_field[ 'data-parsley-errors-container' ] . " ";
			endif;

			$output .= " value='" . $key . "' ";

			if ( isset( $meta_field[ 'data-media-uploader-target' ] ) && ! empty( $meta_field[ 'data-media-uploader-target' ] ) ):
				$output .= " data-media-uploader-target=" . $meta_field[ 'data-media-uploader-target' ] . " ";
			endif;

			if ( isset( $meta_field[ 'data-parsley-value' ] ) && ! empty( $meta_field[ 'data-parsley-value' ] ) ):
				$output .= " data-parsley-value=" . htmlentities( $meta_field[ 'data-parsley-value' ] ) . " ";
			endif;

			if ( $meta_field[ 'type' ] === 'image_radio' || $meta_field['type'] === 'image_radio_label' ) {
				$output .= '>';
				$output .= '<label class="custom-control-label" for="' . $meta_field[ "id" ] . '_' . $key . '">' . $field[ "name" ] . '</label>';
				//									$output .= '<label for="square-radio-1">' . $field[ "name" ] . '</label>';
				$output .= '</div>';
			} else {
				$slug = strtolower( str_replace( ' ', '-', $field[ 'name' ] ) );
				$output .= '><label class="custom-control-label adfoxly-label-slug-' . $slug . '" for="' . $meta_field[ "id" ] . '_' . $key . '">' . $field[ 'name' ] . '</label>';
				//									$output .= '>' . $field[ 'name' ];

				if ( isset( $meta_field[ 'options' ][ $key ][ 'pro' ] ) && $meta_field[ 'options' ][ $key ][ 'pro' ] === true ):
					$output .= ' <a href="' . admin_url() . 'admin.php?page=adfoxly-pricing' . '" target="_blank"><div class="badge badge-danger">PRO</div></a>';
				endif;

				$output .= '</label>';
				$output .= '</div>';
			}

			$output .= '</div>';
			$output .= '<span>';

			if ( $html_type === 'radio' ) {
				$output .= '<i></i>';
			}

			$output .= '</span>';

			$output .= '</label>';
			$output .= '</div>';
			$output .= '</div>';

			if ( isset( $meta_field[ 'options' ][ $key ][ 'soon' ] ) && $meta_field[ 'options' ][ $key ][ 'soon' ] === true ) {
				$output .= '<div style="position: absolute; top: 0; height: 100%;width: calc(100% - 23px);background: rgba(255,255,255, 0.9);"><span style="top: 50%; left: 50%; transform: translate(-50%, -50%); position: absolute; text-transform: uppercase; font-size: 20px; font-weight: 600;">' . __( 'soon', 'adfoxly' ) . '</span></div>';
			}

			$output .= '</label>';

			$output .= '</div>';
		}

		return $output;
	}
}
