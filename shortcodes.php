<?php
/**
 * Series Shortcodes
 *
 * @package Series
 */

/**
 * Add our new shortcodes.
 * @since 0.1
 */
add_shortcode( 'the-series', 'the_series_shortcode' );

/**
 * Gets the series terms of the current post and displays them.
 * $before is the XHTML that can be placed before the list.
 * $separator is the XHTML that separates each term in the list.
 * $after is the XHTML that can be placed after the list.
 *
 * @attr Attributes attributed to the shortcode.
 */
function the_series_shortcode( $attr ) {
	global $post;
	return get_the_term_list( $post->ID, 'series', $attr['before'], $attr['separator'], $attr['after'] );
}

?>