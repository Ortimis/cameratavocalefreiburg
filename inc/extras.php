<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Eveny
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function eveny_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'eveny_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function eveny_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'eveny_body_classes' );

if ( ! function_exists( '_wp_render_title_tag' ) ) :
	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function eveny_render_title() {
		echo '<title>' . wp_title( '|', false, 'right' ) . "</title>\n";
	}
	add_action( 'wp_head', 'eveny_render_title' );
endif;

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function eveny_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'eveny_setup_author' );

/**
 * Filter post_class() additional classes
 *
 * @since Solar 1.0
 */
function eveny_post_classes( $classes, $class, $post_id ) {

	if ( 'album' == get_post_type() ) {
		return $classes;
	}

	if ( 'post' !=  get_post_type() && 'page' != get_post_type() && !is_front_page() ) :

		if ( 'gallery' == get_post_type() ) {
			$taxonomy = 'ct_gallery';
		}
		if ( 'event' == get_post_type() ) {
			$taxonomy = 'ct_events';
		}

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( ! empty( $terms ) ) {

		    foreach( $terms as $order => $term ) {

		        if ( ! in_array( $term->slug, $classes ) ) {

		            $classes[] = $term->slug;

		        }

		    }

		}

	endif;

	// Check if archive is using grid layout
    if ( ( is_home() && !is_post_type_archive() ) || ( is_archive() && !is_post_type_archive() ) ) {

    	$archive_layout = esc_attr( get_theme_mod( 'blog_archive_layout', 'default' ) );

    	if ( 'grid' == $archive_layout ) :

			$cols_post = 'col-lg-4';
			if ( is_active_sidebar( 'sidebar-1' ) ) {
				$cols_post = 'col-lg-6';
			}

			$classes[] = 'col-sm-6';
			$classes[] = $cols_post;

		endif;
	}

	return $classes;

}
add_filter( 'post_class', 'eveny_post_classes', 10, 3 );

/**
 * Retina Detection and variable set
 *
 * @package  Eveny
 */
function eveny_is_retina() {
    global $is_retina;
    $is_retina = isset( $_COOKIE["device_pixel_ratio"] ) AND $_COOKIE["device_pixel_ratio"] >= 2;
}
add_action( 'init', 'eveny_is_retina' );

/**
 * Enable SVG image upload
 *
 * @since  Eveny 1.0
 */
function eveny_svg_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'eveny_svg_mime_types' );
