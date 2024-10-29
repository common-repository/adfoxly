<?php

class AdfoxlyWizardView extends AdfoxlyFormController {

	public $banner_id;

	function __construct( $banner_id = null ) {
		parent::__construct( $banner_id );
//		$this->banner_id = $banner_id;
	}

	public function generateOptions( $output, $meta_field, $array = null ) {

//		var_dump($this->banner_id);
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
