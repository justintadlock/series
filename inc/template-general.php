<?php
/**
 * Functions for use in theme templates.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009 - 2018, Justin Tadlock
 * @link      https://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Series;

/**
 * Conditional tag to check if viewing a series archive.
 *
 * @since  2.0.0
 * @access public
 * @param  mixed  $term
 * @return bool
 */
function is_series( $term = '' ) {

	return apply_filters( 'series/is_series', is_tax( get_series_taxonomy(), $term ), $term );
}

/**
 * Conditional tag to check if the post is in a series.
 *
 * @since  2.0.0
 * @access public
 * @param  string|int|array  $term
 * @param  int|object        $post
 * @return bool
 */
function in_series( $term, $post = null ) {

	return apply_filters( 'series/in_series', has_term( $series, get_series_taxonomy(), $post ), $term, $post );
}

/**
 * Outputs a post's series.
 *
 * @since  2.0.0
 * @access public
 * @param  array   $args
 * @return void
 */
function post_series( $args = array() ) {

	echo get_post_series( $args );
}

/**
 * Wrapper for `get_the_term_list()` for outputting a list of the current
 * post's series.
 *
 * @since  2.0.0
 * @access public
 * @param  array   $args
 * @return string
 */
function get_post_series( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id'    => get_the_ID(),
		'text'       => '%s',
		'before'     => '',
		'after'      => '',
		'wrap'       => '<span %s>%s</span>',
		// Translators: Separates tags, categories, etc. when displaying a post.
		'sep'        => _x( ', ', 'taxonomy terms separator', 'series' )
	);

	$args = wp_parse_args( $args, $defaults );

	$terms = get_the_term_list( $args['post_id'], get_series_taxonomy(), '', $args['sep'], '' );

	if ( $terms ) {
		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="entry-terms entry-series"', sprintf( $args['text'], $terms ) );
		$html .= $args['after'];
	}

	return $html;
}

/**
 * Displays a list of posts by series.
 *
 * @since  2.0.0
 * @param  array   $args
 * @return string
 */
function list_posts( $args = array() ) {

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
		'order'          => 'ASC',
		'orderby'        => 'date',
		'posts_per_page' => -1,
		'echo'           => true
	);

	$args = wp_parse_args( $args, $defaults );

	$query_args = array(
		'order'          => $args['order'],
		'orderby'        => $args['orderby'],
		'posts_per_page' => $args['posts_per_page'],
		'tax_query'      => array(
			array(
				'taxonomy' => get_series_taxonomy(),
				'field'    => is_numeric( $args['series'] ) ? 'term_id' : 'slug',
				'terms'    => array( $args['series'] )
			)
		)
	);

	$loop = new \WP_Query( $query_args );

	if ( $loop->have_posts() ) {

		$out .= '<ul class="series-list">';

		while ( $loop->have_posts() ) {

			$loop->the_post();

			$title = get_the_title() ? the_title( '', '', false ) : get_the_ID();

			$out .= $post_id === get_the_ID()
			        ? sprintf( '<li>%s</li>', $title )
			        : sprintf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink() ), $title );
		}

		$out .= '</ul>';
	}

	wp_reset_postdata();

	if ( false === $args['echo'] )
		return $out;

	echo $out;
}

/**
 * Displays a list of posts related to the current post.
 *
 * @since  2.0.0
 * @param  int     $post_id
 * @param  array   $args
 * @return string
 */
function list_related_posts( $post_id = 0, $args = array() ) {

	if ( ! $post_id )
		get_the_ID();

	if ( $post_id )
		$series = get_the_terms( $post_id, get_series_taxonomy() );

	if ( empty( $series ) )
		return;

	$series = reset( $series );

	$args['series'] = $series->slug;

	return list_posts( $args );
}
