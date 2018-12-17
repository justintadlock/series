<?php
/**
 * Deprecated functions.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009 - 2018, Justin Tadlock
 * @link      https://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class Series_Plugin {}

function series_plugin_register_taxonomies() {}
function series_plugin_register_shortcodes() {}
function get_series_feed_link() {}
function create_series_taxonomy() {}
function series_register_widgets() {}

/**
 * @since      0.1.0
 * @deprecated 2.0.0
 */
function the_series_shortcode( $attr ) {

	_deprecated_function( __FUNCTION__, '2.0.0', '\Series\the_series_shortcode' );

	return \Series\the_series_shortcode( $attr );
}

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function is_series( $slug = false ) {

	_deprecated_function( __FUNCTION__, '0.2.0', '\Series\is_series' );

	return \Series\is_series( $slug );
}

/**
 * @since      0.1.0
 * @deprecated 0.2.0
 */
function in_series( $series, $_post = null ) {

	_deprecated_function( __FUNCTION__, '0.2.0', '\Series\in_series' );

	return \Series\in_series( $series, $_post );
}

/**
 * @since      0.1.0
 * @deprecated 2.0.0
 */
function series_list_posts( $args = array() ) {

	_deprecated_function( __FUNCTION__, '2.0.0', '\Series\list_posts' );

	return \Series\list_posts( $args );
}

/**
 * @since      0.1.0
 * @deprecated 2.0.0
 */
function series_list_related( $args = array() ) {

	_deprecated_function( __FUNCTION__, '2.0.0', '\Series\list_related' );

	return \Series\list_related_posts( null, $args );
}
