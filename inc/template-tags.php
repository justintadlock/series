<?php
/**
 * @package    Series
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2009 - 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/plugins
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function get_series_feed_link( $cat_id, $feed = '' ) {
	return get_term_feed_link( $term_id, 'series', $feed );
}

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function is_series( $slug = false ) {
	return is_tax( 'series', $slug );
}

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function in_series( $series, $_post = null ) {
	return has_term( $series, 'series', $_post );
}

/**
 * Displays a list of posts by series ID.
 *
 * @since  0.1.0
 * @param  array   $args
 * @return string
 */
function series_list_posts( $args = array() ) {

	if ( empty( $args['series'] ) )
		return;

	$out     = '';
	$post_id = 0;

	if ( in_the_loop() )
		$post_id = get_the_ID();

	else if ( is_singular() )
		$post_id = get_queried_object_id();

	$defaults = array(
		'series'         => '', // term slug
		'order'          => 'DESC',
		'orderby'        => 'ID',
		'posts_per_page' => -1,
		'echo'           => false
	);

	$args = wp_parse_args( $args, $defaults );

	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) {

		$out .= '<ul class="series-list">';

		while ( $loop->have_posts() ) {

			$loop->the_post();

			$out .= $post_id === get_the_ID() ? the_title( '<li>', '</li>', false ) : the_title( '<li><a href="' . get_permalink() . '">', '</a></li>', false );
		}

		$out .= '</ul>';
	}

	wp_reset_postdata();

	if ( false === $args['echo'] )
		return $out;

	echo $out;
}

/**
 * Displays a list of posts related to the post by the first series.
 *
 * @since  0.1.0
 * @param  array  $args
 * @return string
 */
function series_list_related() {

	$series = get_the_terms( get_the_ID(), 'series' );

	if ( empty( $series ) )
		return;

	$series = reset( $series );

	series_list_posts( array( 'series' => $series->slug ) );
}

?>