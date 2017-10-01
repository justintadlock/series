<?php
/**
 * Deprecated functions.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009-2017, Justin Tadlock
 * @link      https://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class Series_Plugin {}

function series_plugin_register_taxonomies() {}
function series_plugin_register_shortcodes() {}

/**
 * @since      0.1.0
 * @deprecated 2.0.0
 * @access     public
 * @attr       $attr
 * @return     string
 */
function the_series_shortcode( $attr ) {

	return \Series\the_series_shortcode( $attr );
}

