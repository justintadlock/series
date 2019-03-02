<?php
/**
 * List Posts Widget - Lists posts from a given series.
 *
 * @package    Series
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009 - 2018, Justin Tadlock
 * @link       https://themehybrid.com/plugins/plugins
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Series\Widgets;

/**
 * List posts widget class.
 *
 * @since  2.0.0
 * @access public
 */
class List_Posts extends \WP_Widget {

	/**
	 * Default arguments for the widget settings.
	 *
	 * @since  2.0.0
	 * @access public
	 * @var    array
	 */
	public $defaults = array();

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		// Set up the widget options.
		$widget_options = array(
			'classname'   => 'series-list-posts',
			'description' => esc_html__( 'Displays a list of posts within a series.', 'series' )
		);

		// Create the widget.
		parent::__construct( 'series-list-posts', __( 'Series - List Posts', 'series' ), $widget_options );

		// Set up defaults.
		$this->defaults = array(
			'title'          => __( 'Series', 'series' ),
			'series'         => '',
			'order'          => 'ASC',
			'orderby'        => 'date',
			'posts_per_page' => -1,
		);
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function widget( $sidebar, $instance ) {

		// Set the $args for wp_get_archives() to the $instance array.
		$args = wp_parse_args( $instance, $this->defaults );

		// If there is no series, bail.
		if ( ! $args['series'] )
			return;

		// Output the theme's widget wrapper.
		echo $sidebar['before_widget'];

		// If a title was input by the user, display it.
		if ( ! empty( $instance['title'] ) )
			echo $sidebar['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $sidebar['after_title'];

		// Output the posts list.
		\Series\list_posts( $args );

		// Close the theme's widget wrapper.
		echo $sidebar['after_widget'];
	}

	/**
	 * The update callback for the widget control options.  This method is used to sanitize and/or
	 * validate the options before saving them into the database.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  array  $new_instance
	 * @param  array  $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {

		// Sanitize title.
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		// Strip tags.
		$instance['series'] = strip_tags( $new_instance['series'] );

		// Whitelist options.
		$order   = array( 'ASC', 'DESC' );
		$orderby = array( 'ID', 'author', 'none', 'title', 'name', 'date', 'modified', 'random', 'comment_count' );

		$instance['order']   = in_array( $new_instance['order'], $order )   ? $new_instance['order']  : 'ASC';
		$instance['orderby'] = in_array( $new_instance['orderby'], $orderby )   ? $new_instance['orderby']  : 'date';

		// Integers.
		$instance['posts_per_page'] = intval( $new_instance['posts_per_page'] );

		// Return sanitized options.
		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  array  $instance
	 * @param  void
	 */
	public function form( $instance ) {

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		/* Get series. */
		$terms = get_terms( \Series\get_series_taxonomy() );

		// If there are no terms, return.
		if ( empty( $terms ) ) {
			esc_html_e( 'You need at least one series of posts to use this widget.', 'series' );
			return;
		}

		// Orderby options.
		$orderby = array(
			'ID'            => __( 'ID',               'series' ),
			'author'        => __( 'Author',           'series' ),
			'none'          => __( 'None',             'series' ),
			'title'         => __( 'Title',            'series' ),
			'name'          => __( 'Slug',             'series' ),
			'date'          => __( 'Date (Published)', 'series' ),
			'modified'      => __( 'Date (Modified)',  'series' ),
			'random'        => __( 'Random',           'series' ),
			'comment_count' => __( 'Comment Count',    'series' )
		);

		// Order options.
		$order = array(
			'ASC'  => __( 'Ascending',  'series' ),
			'DESC' => __( 'Descending', 'series' )
		); ?>

		<p>
			<label>
				<?php esc_html_e( 'Title:', 'series' ); ?>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</label>
		</p>

		<p>
			<label>
				<?php esc_html_e( 'Series:', 'series' ); ?>

				<select name="<?php echo esc_attr( $this->get_field_name( 'series' ) ); ?>" class="widefat" >
					<?php foreach ( $terms as $term ) : ?>
						<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $instance['series'], $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</p>

		<p>
			<label>
				<?php esc_html_e( 'Order By:', 'series' ); ?>

				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
					<?php foreach ( $orderby as $option_value => $option_label ) : ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['orderby'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</p>

		<p>
			<label>
				<?php esc_html_e( 'Order:', 'series' ); ?>

				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
					<?php foreach ( $order as $option_value => $option_label ) : ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['order'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</p>

		<p>
			<label>
				<?php esc_html_e( 'Limit:', 'series' ); ?>
				<input type="text" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'posts_per_page' ) ); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" />
			</label>
		</p>
	<?php }
}
