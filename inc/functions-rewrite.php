<?php
/**
 * Plugin rewrite functions.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009 - 2018, Justin Tadlock
 * @link      https://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Series;

/**
 * Returns the tag rewrite slug used for tag archives.
 *
 * @since  2.0.0
 * @access public
 * @return string
 */
function get_series_rewrite_slug() {

	$series_base = get_series_rewrite_base();

	$slug = $series_base ? $series_base : 'series';

	return apply_filters( 'series/get_series_rewrite_slug', $slug );
}
