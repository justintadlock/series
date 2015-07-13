<?php
/**
 * Registers custom shortcodes for the plugin.
 *
 * @package    Series
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2009 - 2015, Justin Tadlock
 * @link       http://themehybrid.com/plugins/plugins
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register shortcodes on 'init'. */
add_action( 'init', 'series_plugin_register_shortcodes' );

/**
 * Registers the plugin's shortcodes with WordPress.
 *
 * @since  0.2.0
 * @access public
 * @return void
 */
function series_plugin_register_shortcodes() {
	add_shortcode( 'the-series', 'the_series_shortcode' );
}

/**
 * Gets the series terms of the current post and displays them.
 *
 * @since  0.1.0
 * @access public
 * @attr   $attr   Attributes attributed to the shortcode.
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
