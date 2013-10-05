<?php
/**
 * Series Template Tags
 *
 * Several functions (template tags) exist within this file, which can be used 
 * within the theme.  These are pretty standard things we generally see used
 * with categories and tags.
 *
 * WordPress already has numerous built-in functions that handle most of the work 
 * required here.  As opposed to rewriting a ton of code, we should make use of those 
 * pre-coded functions as much as possible.  Reference the WordPress files 
 * /wp-inclues/taxonomy.php and /wp-includes/category-template.php when looking 
 * for things you can do.
 *
 * Get a term by the term slug:
 * $term = get_term_by( 'slug', $term_slug, 'series' );
 *
 * Get a term's description:
 * $description = term_description( $term_id, 'series' );
 *
 * Get the series terms for a post:
 * $terms = get_the_term_list( $post->ID, 'series', $before, $sep, $after );
 *
 * Display the series terms for a post:
 * the_terms( $post->ID, 'series', $before, $sep, $after )
 *
 * Get all series terms:
 * $terms = get_terms( 'series', $args );
 *
 * Get a specific series term:
 * $term = get_term( $series, 'series', $output, $filter );
 *
 * Get a specific series term link:
 * $link = get_term_link( $series, 'series' );
 *
 * @package Series
 */

/**
 * Produces a feed link for an individual series.
 *
 * @since 0.1
 */
function get_series_feed_link( $cat_id, $feed = '' ) {
	$cat_id = (int) $cat_id;

	$category = get_series( $cat_id );

	if ( empty( $category ) || is_wp_error( $category ) )
		return false;

	if ( empty( $feed ) )
		$feed = get_default_feed();

	$permalink_structure = get_option( 'permalink_structure' );

	if ( '' == $permalink_structure ) {
		$link = trailingslashit( get_option( 'home' ) ) . "?feed=$feed&amp;series=" . $cat_id;
	} else {
		$link = get_series_link( $cat_id );
		if( $feed == get_default_feed() )
			$feed_link = 'feed';
		else
			$feed_link = "feed/$feed";

		$link = trailingslashit( $link ) . user_trailingslashit( $feed_link, 'feed' );
	}

	$link = apply_filters( 'series_feed_link', $link, $feed );

	return $link;
}

/**
 * Checks if the current page is a series archive.  This function
 * will return true|false depending on whether the value is true.
 * If a $slug is entered, we'll check against that.  Otherwise, we 
 * only check if the current page is a series.
 *
 * @since 0.1
 */
function is_series( $slug = false ) {
	global $wp_query;

	$tax = $wp_query->get_queried_object();
	$taxonomy = get_query_var( 'taxonomy' );

	if ( $slug && $slug == $tax->slug )
		return true;
	elseif ( $slug && $slug !== $tax->slug )
		return false;

	if ( $taxonomy == 'series' )
		return true;

	return false;
}

/**
 * Check if the current post is within any of the given series.
 *
 * The given series are checked against the post's series' term_ids, names and slugs.
 * Series given as integers will only be checked against the post's series' term_ids.
 *
 * @uses is_object_in_term()
 *
 * @since 0.1
 * @param int|string|array $series. Series ID, name or slug, or array of said.
 * @param int|post object Optional.  Post to check instead of the current post.
 * @return bool True if the current post is in any of the given series.
 */
function in_series( $series, $_post = null ) {
	if ( empty( $series ) )
		return false;

	if ( $_post )
		$_post = get_post( $_post );
	else
		$_post =& $GLOBALS['post'];

	if ( !$_post )
		return false;

	$r = is_object_in_term( $_post->ID, 'series', $series );

	if ( is_wp_error( $r ) )
		return false;

	return $r;
}

/**
 * Displays a list of posts by series ID.
 * $args['series'] must be input for the list to work.
 *
 * @uses get_posts() Grabs an array of posts to loop through.
 *
 * @since 0.1
 * @param array $args
 * @return string $out
 */
function series_list_posts( $args = array() ) {
	global $post;

	$defaults = array(
		'series' => '',		// Series args
		'link_current' => false,
		'order' => 'DESC',		// get_posts() args
		'orderby' => 'ID',
		'post_type' => 'post',
		'exclude' => '',
		'include' => '',
		'numberposts' => -1,
		'echo' => true,
	);

	$args = apply_filters( 'series_list_posts_args', $args );

	$args = wp_parse_args( $args, $defaults );
	extract( $args );

	if ( !$series ) :
		echo '<li>' . _e('No series term was input.', 'series') . '</li>';
		return false;
	endif;

	$series_posts = get_posts( $args );

	if ( !$series_posts ) :
		echo '<li>' . _e('No posts in this series.', 'series') . '</li>';
		return false;
	endif;

	foreach ( $series_posts as $serial ) :

		if ( $serial->ID == $post->ID && !$link_current )
			$out .= '<li class="current-post">' . $serial->post_title . '</li>';

		else
			$out .= '<li><a href="' . get_permalink( $serial->ID ) . '" title="' . wp_specialchars( $serial->post_title, 1 ) . '">' . $serial->post_title . '</a></li>';

	endforeach;

	if ( $echo )
		echo $out;
	else
		return $out;
}

/**
 * Displays a list of posts related to the post by the first series.
 * @uses series_list_posts() Lists the posts in the series.
 *
 * @since 0.1
 * @param array $args See series_list_posts() for arguments.
 * @return string
 */
function series_list_related( $args = array() ) {
	global $post;

	$series = get_the_terms( $post->ID, 'series' );

	if ( !$series )
		return '';
	else
		$series = reset( $series );

	$args['series'] = $series->slug;

	if ( $args['echo'] )
		echo series_list_posts( $args );
	else
		return series_list_posts( $args );
}

?>