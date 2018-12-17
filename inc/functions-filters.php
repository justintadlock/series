<?php
/**
 * Plugin filters.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009 - 2018, Justin Tadlock
 * @link      https://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Series;

# Filter prior to getting posts from the DB.
add_action( 'pre_get_posts', __NAMESPACE__ . '\pre_get_posts' );

/**
 * Filter on `pre_get_posts` to alter the main query on series archives.
 *
 * @since  2.0.0
 * @access public
 * @param  object  $query
 * @return void
 */
function pre_get_posts( $query ) {

	if ( ! is_admin() && $query->is_main_query() && is_series() ) {

		// Set the themes per page.
		$query->set( 'posts_per_page', get_posts_per_page() );
		$query->set( 'orderby',        get_posts_orderby()  );
		$query->set( 'order',          get_posts_order()    );
	}
}