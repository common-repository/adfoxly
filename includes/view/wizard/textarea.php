<?php


class wizardTextarea {


	/**
	 * @var
	 */
	private $banner_data;

	public function __construct( $banner_data ) {
		$this->banner_data = $banner_data;
	}


	public function render( $output, $meta_field ) {

//		$this->banner_data = $banner_data;

//		var_dump($meta_field);
		if ( isset( $meta_field[ 'group' ] ) && ! empty( $meta_field[ 'group' ] ) ) {
			$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . ' ad-format-group-' . $meta_field[ 'group' ];
		} else {
			$output .= '<div class="jj form-group row form-group-type-' . $meta_field[ 'type' ];
		}

		if ( isset( $meta_field[ 'wrapper_class' ] ) && ! empty( $meta_field[ 'wrapper_class' ] ) ) {
			$output .= ' ' . $meta_field[ 'wrapper_class' ];
		}

		$output .= '"';

		if ( isset( $meta_field[ 'wrapper_id' ] ) && ! empty( $meta_field[ 'wrapper_id' ] ) ) {
			$output .= ' id="' . $meta_field[ 'wrapper_id' ] . '" ';
		}

		if ( ! empty( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] ) ):
			$output .= ' style="display: flex;"';
		elseif ( isset( $meta_field[ 'value' ] ) && ! empty( $meta_field[ 'value' ] ) ):
			$output .= ' style="display: flex;"';
		elseif ( isset( $meta_field[ 'show' ] ) && $meta_field[ 'show' ] === false ):
			$output .= ' style="display: none;" ';
		endif;

		$output .= '>';

		$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ];

		if ( isset( $meta_field[ 'help-block' ] ) ) {

			$output .= '<br/><small';

			if ( isset( $meta_field['help-block-url'] ) ) {
				$output .= ' data-url="' . $meta_field['help-block-url'] . '"';
			}

			$output .= '>' . $meta_field[ 'help-block' ] . '</small>';

		}

		$output .= '</label>';

		$output .= '<div class="col-sm-9 col-form-label">';

		$output .= '<textarea name="' . $meta_field[ 'id' ] . '" id="' . $meta_field[ 'id' ] . '"';

		if ( isset( $meta_field[ 'required' ] ) && ! empty( $meta_field[ 'required' ] ) && $meta_field[ 'required' ] === true ):
			$output .= " required ";
		endif;

		$output .= '>';

		if ( ! empty( $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ] ) ):
			$output .= $this->banner_data[ 'meta' ][ $meta_field[ 'id' ] ][ 0 ];
		elseif ( isset( $meta_field[ 'value' ] ) && ! empty( $meta_field[ 'value' ] ) ):
			$output .= $meta_field[ 'value' ];
		endif;

		$output .= '</textarea>';


		$output .= '</div>';

		$output .= '</div>';

		return $output;
	}
}
