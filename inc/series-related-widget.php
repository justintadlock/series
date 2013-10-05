<?php
/**
 * Series Widget
 *
 * @package Series
 */

/**
 * Output of the series widget.
 * @since 0.1
 */
class Series_Widget_Related extends WP_Widget {

	function Series_Widget_Related() {
		$widget_ops = array( 'classname' => 'series-related', 'description' => __('A widget for showing other posts in the same series as the current post.', 'series') );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'series-related-list' );
		$this->WP_Widget( 'series-related-list', __('Series: Related Posts', 'series'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$series = $instance['series'];
		$order = $instance['order'];
		$orderby = $instance['orderby'];
		$numberposts = $instance['numberposts'];

		$defaults = array(
			'series' => $series,		// Series args
			'link_current' => true,
			'order' => $order,		// get_posts() args
			'orderby' => $orderby,
			'numberposts' => $numberposts,
			'include' => '',
			'exclude' => '',
			'post_type' => 'post',
			'echo' => false,
		);

		if ( !is_single() )
			return '';

		$list = series_list_related( $defaults );

		if ( !$list )
			return '';

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		echo '<ul>';
			echo $list;
		echo '</ul>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes( $new_instance['title'] ) );
		$instance['order'] = strip_tags( stripslashes( $new_instance['order'] ) );
		$instance['orderby'] = strip_tags( stripslashes( $new_instance['orderby'] ) );
		$instance['numberposts'] = strip_tags( stripslashes( $new_instance['numberposts'] ) );

		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$defaults = array( 'title' => __('Articles in this series', 'series'), 'numberposts' => -1, 'orderby' => 'ID', 'order' => 'DESC' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'series'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:', 'series'); ?> <code>order</code></label> 
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'ASC' == $instance['order'] ) echo 'selected="selected"'; ?>>ASC</option>
				<option <?php if ( 'DESC' == $instance['order'] ) echo 'selected="selected"'; ?>>DESC</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Order By:', 'series'); ?> <code>orderby</code></label> 
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'name' == $instance['orderby'] ) echo 'selected="selected"'; ?>>name</option>
				<option <?php if ( 'ID' == $instance['orderby'] ) echo 'selected="selected"'; ?>>ID</option>
				<option <?php if ( 'author' == $instance['orderby'] ) echo 'selected="selected"'; ?>>author</option>
				<option <?php if ( 'category' == $instance['orderby'] ) echo 'selected="selected"'; ?>>category</option>
				<option <?php if ( 'content' == $instance['orderby'] ) echo 'selected="selected"'; ?>>content</option>
				<option <?php if ( 'date' == $instance['orderby'] ) echo 'selected="selected"'; ?>>date</option>
				<option <?php if ( 'modified' == $instance['orderby'] ) echo 'selected="selected"'; ?>>modified</option>
				<option <?php if ( 'password' == $instance['orderby'] ) echo 'selected="selected"'; ?>>password</option>
				<option <?php if ( 'rand' == $instance['orderby'] ) echo 'selected="selected"'; ?>>rand</option>
				<option <?php if ( 'title' == $instance['orderby'] ) echo 'selected="selected"'; ?>>title</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'numberposts' ); ?>"><?php _e('Number:', 'series'); ?> <code>numberposts</code></label>
			<input id="<?php echo $this->get_field_id( 'numberposts' ); ?>" name="<?php echo $this->get_field_name( 'numberposts' ); ?>" value="<?php echo $instance['numberposts']; ?>" style="width:100%;" />
		</p>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>