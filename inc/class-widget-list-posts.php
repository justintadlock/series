<?php
/**
 * @package    Series
 * @since      0.2.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2009 - 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/plugins
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class Series_Widget_List_Posts extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname'   => 'series-list-posts',
			'description' => esc_html__( 'Displays a list of posts within a series.', 'series' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width'  => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'series-list-posts',                  // $this->id_base
			__( 'Series: List Posts', 'series' ), // $this->name
			$widget_options,                      // $this->widget_options
			$control_options                      // $this->control_options
		);
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function widget( $sidebar, $instance ) {
		extract( $sidebar );

		/* Set up the arguments. */
		$args = array(
			'series'         => !empty( $instance['series'] )         ? $instance['series']         : '',
			'order'          => !empty( $instance['order'] )          ? $instance['order']          : 'ASC',
			'orderby'        => !empty( $instance['orderby'] )        ? $instance['orderby']        : 'date',
			'posts_per_page' => !empty( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : -1
		);

		/* Output the theme's widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* Output the series. */
		series_list_posts( $args );

		/* Close the theme's widget wrapper. */
		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since  0.2.0
	 * @access public
	 * @param  array  $new_instance
	 * @param  array  $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {

		$instance['title']          = strip_tags( $new_instance['title'] );
		$instance['series']         = strip_tags( $new_instance['series'] );
		$instance['order']          = strip_tags( $new_instance['order'] );
		$instance['orderby']        = strip_tags( $new_instance['orderby'] );
		$instance['posts_per_page'] = intval( $new_instance['posts_per_page'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	function form( $instance ) {

		/* Get series. */
		$terms = get_terms( 'series' );

		/* If there are no terms, return. */
		if ( empty( $terms ) ) {
			_e( 'You need at least one series of posts to use this widget.', 'series' );
			return;
		}

		/* Get a default series. */
		$default_series = reset( $terms );

		/* Set up the default form values. */
		$defaults = array(
			'title'          => __( 'Series', 'series' ),
			'series'         => $default_series->slug,
			'order'          => 'ASC',
			'orderby'        => 'date',
			'posts_per_page' => -1,
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/* Orderby options. */
		$orderby = array(
			'ID'            => __( 'ID', 'series' ),
			'author'        => __( 'Author', 'series' ),
			'none'          => __( 'None', 'series' ),
			'title'         => __( 'Title', 'series' ),
			'name'          => __( 'Slug', 'series' ),
			'date'          => __( 'Date', 'series' ),
			'modified'      => __( 'Date Modified', 'series' ),
			'random'        => __( 'Random', 'series' ),
			'comment_count' => __( 'Comment Count', 'series' )
		);

		/* Order options. */
		$order = array(
			'ASC'  => __( 'Ascending', 'series' ),
			'DESC' => __( 'Descending', 'series' )
		);

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'series' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'series' ); ?>"><?php _e( 'Series:', 'series' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'series' ); ?>" name="<?php echo $this->get_field_name( 'series' ); ?>" class="widefat" >
				<?php foreach ( $terms as $term ) { ?>
					<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $instance['series'], $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', 'series' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
				<?php foreach ( $orderby as $option_value => $option_label ) { ?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['orderby'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:', 'series' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
				<?php foreach ( $order as $option_value => $option_label ) { ?>
					<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['order'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Limit:', 'series' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo $instance['posts_per_page']; ?>" />
		</p>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>