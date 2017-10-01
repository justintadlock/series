<?php
/**
 * Functions for handling plugin options.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009-2017, Justin Tadlock
 * @link      https://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Series;

/**
 * Returns the series rewrite base. Used for series archives.
 *
 * @since  2.0.0
 * @access public
 * @return string
 */
function get_series_rewrite_base() {

	return apply_filters( 'series/get_series_rewrite_base', get_setting( 'series_rewrite_base' ) );
}

/**
 * Gets a setting from from the plugin settings in the database.
 *
 * @since  2.0.0
 * @access public
 * @return mixed
 */
function get_setting( $option = '' ) {

	$defaults = get_default_settings();

	$settings = wp_parse_args( get_option( 'series_settings', $defaults ), $defaults );

	return isset( $settings[ $option ] ) ? $settings[ $option ] : false;
}

/**
 * Returns an array of the default plugin settings.
 *
 * @since  2.0.0
 * @access public
 * @return array
 */
function get_default_settings() {

	return array(
		// @since 2.0.0
		'series_rewrite_base' => 'series'
	);
}
