<?php
/**
 * File for registering custom taxonomies.
 *
 * @package    Series
 * @since      0.2.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2009 - 2013, Justin Tadlock
 * @link       http://themehybrid.com/plugins/plugins
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register taxonomies on the 'init' hook. */
add_action( 'init', 'series_plugin_register_taxonomies' );

/**
 * Registers custom taxonomies for this plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function series_plugin_register_taxonomies() {

	/* Set up the arguments for the series taxonomy. */
	$args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => false,
		'query_var'         => 'series',

		/* Only 2 caps are needed: 'manage_series' and 'edit_posts'. */
		'capabilities' => array(
			'manage_terms' => 'manage_series',
			'edit_terms'   => 'edit_posts',
			'delete_terms' => 'edit_posts',
			'assign_terms' => 'edit_posts',
		),

		/* The rewrite handles the URL structure. */
		'rewrite' => array(
			'slug'         => 'series',
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),

		/* Labels used when displaying taxonomy and terms. */
		'labels' => array(
			'name'                       => __( 'Series',                           'series' ),
			'singular_name'              => __( 'Series',                           'series' ),
			'menu_name'                  => __( 'Series',                           'series' ),
			'name_admin_bar'             => __( 'Series',                           'series' ),
			'search_items'               => __( 'Search Series',                    'series' ),
			'popular_items'              => __( 'Popular Series',                   'series' ),
			'all_items'                  => __( 'All Series',                       'series' ),
			'edit_item'                  => __( 'Edit Series',                      'series' ),
			'view_item'                  => __( 'View Series',                      'series' ),
			'update_item'                => __( 'Update Series',                    'series' ),
			'add_new_item'               => __( 'Add New Series',                   'series' ),
			'new_item_name'              => __( 'New Series Name',                  'series' ),
			'separate_items_with_commas' => __( 'Separate series with commas',      'series' ),
			'add_or_remove_items'        => __( 'Add or remove series',             'series' ),
			'choose_from_most_used'      => __( 'Choose from the most used series', 'series' ),
		)
	);

	/* Register the 'series' taxonomy. */
	register_taxonomy( 'series', array( 'post' ), $args );
}

?>