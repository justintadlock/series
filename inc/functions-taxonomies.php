<?php
/**
 * File for registering custom taxonomies.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009 - 2018, Justin Tadlock
 * @link      https://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Series;

# Register taxonomies on the 'init' hook.
add_action( 'init', __NAMESPACE__ . '\register_taxonomies', 9 );

# Filter the term updated messages.
add_filter( 'term_updated_messages', __NAMESPACE__ . '\term_updated_messages', 5 );

/**
 * Returns the name of the portfolio category taxonomy.
 *
 * @since  2.0.0
 * @access public
 * @return string
 */
function get_series_taxonomy() {

	return apply_filters( 'series/get_series_taxonomy', 'series' );
}

/**
 * Returns the capabilities for the portfolio series taxonomy.
 *
 * @since  2.0.0
 * @access public
 * @return array
 */
function get_series_capabilities() {

	$caps = array(
		'manage_terms' => 'manage_series',
		'edit_terms'   => 'manage_series',
		'delete_terms' => 'manage_series',
		'assign_terms' => 'edit_posts',
	);

	return apply_filters( 'series/get_series_capabilities', $caps );
}

/**
 * Returns the labels for the portfolio series taxonomy.
 *
 * @since  2.0.0
 * @access public
 * @return array
 */
function get_series_labels() {

	$labels = array(
		'name'                       => __( 'Series',                           'custom-content-portfolio' ),
		'singular_name'              => __( 'Series',                           'custom-content-portfolio' ),
		'menu_name'                  => __( 'Series',                           'custom-content-portfolio' ),
		'name_admin_bar'             => __( 'Series',                           'custom-content-portfolio' ),
		'search_items'               => __( 'Search Series',                    'custom-content-portfolio' ),
		'popular_items'              => __( 'Popular Series',                   'custom-content-portfolio' ),
		'all_items'                  => __( 'All Series',                       'custom-content-portfolio' ),
		'edit_item'                  => __( 'Edit Series',                      'custom-content-portfolio' ),
		'view_item'                  => __( 'View Series',                      'custom-content-portfolio' ),
		'update_item'                => __( 'Update Series',                    'custom-content-portfolio' ),
		'add_new_item'               => __( 'Add New Series',                   'custom-content-portfolio' ),
		'new_item_name'              => __( 'New Series Name',                  'custom-content-portfolio' ),
		'not_found'                  => __( 'No series found.',                 'custom-content-portfolio' ),
		'no_terms'                   => __( 'No series',                        'custom-content-portfolio' ),
		'items_list_navigation'      => __( 'Series list navigation',           'custom-content-portfolio' ),
		'items_list'                 => __( 'Series list',                      'custom-content-portfolio' ),

		// Non-hierarchical only.
		'separate_items_with_commas' => __( 'Separate series with commas',      'custom-content-portfolio' ),
		'add_or_remove_items'        => __( 'Add or remove series',             'custom-content-portfolio' ),
		'choose_from_most_used'      => __( 'Choose from the most used series', 'custom-content-portfolio' ),
	);

	return apply_filters( 'series/get_series_labels', $labels );
}

/**
 * Register taxonomies for the plugin.
 *
 * @since  2.0.0
 * @access public
 * @return void.
 */
function register_taxonomies() {

	// Set up the arguments for the portfolio series taxonomy.
	$series_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'hierarchical'      => false,
		'query_var'         => get_series_taxonomy(),
		'capabilities'      => get_series_capabilities(),
		'labels'            => get_series_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'         => get_series_rewrite_slug(),
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),
	);

	// Register the taxonomies.
	register_taxonomy(
		get_series_taxonomy(),
		array( 'post' ),
		apply_filters( 'series/series_taxonomy_args', $series_args )
	);
}

/**
 * Filters the term updated messages in the admin.
 *
 * @since  2.0.0
 * @access public
 * @param  array  $messages
 * @return array
 */
function term_updated_messages( $messages ) {

	$series_taxonomy = get_series_taxonomy();

	// Add the portfolio series messages.
	$messages[ $series_taxonomy ] = array(
		0 => '',
		1 => __( 'Series added.',       'custom-content-portfolio' ),
		2 => __( 'Series deleted.',     'custom-content-portfolio' ),
		3 => __( 'Series updated.',     'custom-content-portfolio' ),
		4 => __( 'Series not added.',   'custom-content-portfolio' ),
		5 => __( 'Series not updated.', 'custom-content-portfolio' ),
		6 => __( 'Series deleted.',     'custom-content-portfolio' ),
	);

	return $messages;
}
