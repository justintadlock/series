<?php
/**
 * File for handling shortcodes.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009-2017, Justin Tadlock
 * @link      https://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Series;

# Register shortcodes.
add_action( 'init', __NAMESPACE__ . '\register_shortcodes' );

/**
 * Registers the plugin shortcodes.
 *
 * @since  2.0.0
 * @access public
 * @return void
 */
function register_shortcodes() {

	add_shortcode( 'the-series', __NAMESPACE__ . 'the_series_shortcode' );
}

/**
 * Gets the series terms of the current post and displays them.
 *
 * @since  2.0.0
 * @access public
 * @attr   $attr
 * @return string
 */
function the_series_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'before'    => '',
			'after'     => '',
			'separator' => ','
		),
		$attr,
		'the-series'
	);

	return get_the_term_list( get_the_ID(), 'series', $attr['before'], $attr['separator'], $attr['after'] );
}
