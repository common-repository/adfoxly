<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * create widget
 */
class AdfoxlyWidget extends WP_Widget {
	/**
	 * construct function
	 */
	function __construct() {
		parent::__construct(
			'adfoxly',
			__( 'AdFoxly Ad Widget', 'adfoxly' ),
			array( 'description' => __( 'Show Ad on website via Widget on Sidebar', 'adfoxly' ), )
		);
	}

	/**
	 * display widget ad
	 */
	public function widget( $args, $instance ) {
		$id = $instance[ 'adfoxly_place' ];
		echo $args[ 'before_widget' ];
		if ( ! empty( $instance['title'] ) ) {
			echo $args[ 'before_title' ] . apply_filters( 'widget_title', $instance[ 'title' ] ) . $args[ 'after_title' ];
		}
		$places = new AdfoxlyPlacesController();
		echo $places->renderPlace( $id );
		echo $args[ 'after_widget' ];
	}


	/**
	 * widget form
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'adfoxly_place' ] ) ) {
			$widgetAdzone = $instance[ 'adfoxly_place' ];
		} else {
			$widgetAdzone = __( 'Select Ad', 'adfoxly' );
		}

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Advertisement', 'adfoxly' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget name', 'adfoxly' ) ?></label>
			<input type="text" value="<?php echo esc_attr( $title ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" style="width: 100%">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'adfoxly_place' ); ?>"><?php _e( 'Select Ad', 'adfoxly' ) ?></label>
			<select id="<?php echo $this->get_field_id( 'adfoxly_place' ); ?>"
			        name="<?php echo $this->get_field_name( 'adfoxly_place' ); ?>" style="width: 100%">
				<option placeholder="Select adzone"
					<?php if ( ! empty( $instance[ 'adfoxly_place' ] ) && $instance[ 'adfoxly_place' ] !== '' ) {
						echo " disabled ";
					} ?>>
					<?php _e( "Select Ad", "adfoxly" ) ?>
				</option>
				<?php
				$getPlaceIDArgs = array(
					'meta_query'     => array(
						array(
							'key'   => 'adfoxly_place_type',
							'value' => 'widget'
						)
					),
					'post_type'      => 'adfoxly_places',
					'posts_per_page' => - 1
				);

				$getWidgetPlace = get_posts( $getPlaceIDArgs );

				foreach ( $getWidgetPlace as $widgetPlace ) {
					echo '<option value="' . $widgetPlace->ID . '"';
					if ( esc_attr( $widgetAdzone ) == $widgetPlace->ID ) {
						echo "selected";
					}
					echo '>' . $widgetPlace->post_title . '</option>';
				}
				?>
			</select>
		</p>
		<?php
	}

	/**
	 * widget update
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                        = array();
		$instance[ 'adfoxly_place' ] = ( ! empty( $new_instance[ 'adfoxly_place' ] ) ) ? strip_tags( $new_instance[ 'adfoxly_place' ] ) : '';
		$instance[ 'title' ] = ( ! empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';

		return $instance;
	}
}
