<?php
/**
 * Functions for use in theme templates.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009-2017, Justin Tadlock
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
