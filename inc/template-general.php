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
