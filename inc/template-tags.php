<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Eveny
 */

if ( ! function_exists( 'eveny_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function eveny_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'eveny' ); ?></h1>
		<div class="nav-links clear">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav"><i class="icon-left"></i></span> Older posts', 'eveny' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav"><i class="icon-right"></i></span>', 'eveny' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'eveny_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function eveny_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	$post_name = ucfirst( get_post_type() );

	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'eveny' ); ?></h1>
		<div class="nav-links clear">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '%title<span class="meta-nav"><i class="icon-left"></i>Previous ' . $post_name . '</span>', 'Previous post link', 'eveny' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title<span class="meta-nav">Next ' . $post_name . '<i class="icon-right"></i></span>', 'Next post link',     'eveny' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'eveny_page_numbers_pagination' ) ) :
/**
 * Eveny custom paging function
 *
 * Creates and displays custom page numbering pagination in bottom of archives
 *
 * @since Eveny 1.0
 */
    function eveny_page_numbers_pagination() {

		global $wp_query, $wp_rewrite;

		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

		$pagination = array(
			'base'      => @add_query_arg( 'paged', '%#%' ),
			'format'    => '',
			'total'     => $wp_query->max_num_pages,
			'current'   => $current,
			'type'      => 'list',
			'prev_next' => true,
			'prev_text' => __( 'Prev', 'eveny' ),
			'next_text' => __( 'Next', 'eveny' )
		);

		if ( $wp_rewrite->using_permalinks() )
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

		if ( ! empty( $wp_query->query_vars['s'] ) )
			$pagination['add_args'] = array( 's' => get_query_var( 's' ) );

        // Display pagination
		printf( '<nav class="navigation paging-navigation"><h1 class="screen-reader-text">%1$s</h1>%2$s</nav>',
			esc_html_x( 'Page navigation', 'eveny' ),
			paginate_links( $pagination )
		);
    }
endif;

if ( ! function_exists( 'eveny_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function eveny_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'Posted on %s', 'post date', 'eveny' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'eveny' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'eveny_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function eveny_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		// printf( '<span class="byline"><span class="author vcard">' . __( 'Posted by', 'eveny' ) . '<a class="url fn n" href="%1$s">%2$s</a></span></span>',
		// 	esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		// 	esc_html( get_the_author() )
		// );

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ' ', 'eveny' ) );
		if ( $categories_list && eveny_categorized_blog() ) {
			printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'eveny' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ' ', 'eveny' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'eveny' ) . '</span>', $tags_list );
		}
	}

}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'eveny' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'eveny' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'eveny' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'eveny' ), get_the_date( _x( 'Y', 'yearly archives date format', 'eveny' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'eveny' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'eveny' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'eveny' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'eveny' ) ) );
	} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
		$title = _x( 'Asides', 'post format archive title', 'eveny' );
	} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
		$title = _x( 'Galleries', 'post format archive title', 'eveny' );
	} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
		$title = _x( 'Images', 'post format archive title', 'eveny' );
	} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
		$title = _x( 'Videos', 'post format archive title', 'eveny' );
	} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
		$title = _x( 'Quotes', 'post format archive title', 'eveny' );
	} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
		$title = _x( 'Links', 'post format archive title', 'eveny' );
	} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
		$title = _x( 'Statuses', 'post format archive title', 'eveny' );
	} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
		$title = _x( 'Audio', 'post format archive title', 'eveny' );
	} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
		$title = _x( 'Chats', 'post format archive title', 'eveny' );
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'eveny' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'eveny' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'eveny' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function eveny_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'eveny_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'eveny_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so eveny_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so eveny_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in eveny_categorized_blog.
 */
function eveny_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'eveny_categories' );
}
add_action( 'edit_category', 'eveny_category_transient_flusher' );
add_action( 'save_post',     'eveny_category_transient_flusher' );



if ( ! function_exists( 'eveny_post_meta' ) ) :
/**
 * Displays post meta data.
 *
 * @since Eveny 1.0
 */

function eveny_post_meta() { ?>

<div class="post-meta">
	<?php

		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

	?>

	<?php if ( is_sticky() ) : ?>
			<div class="featured-banner"><?php _e( 'Featured', 'eveny' ); ?></div>
	<?php endif; ?>

	<?php

		printf( '<span class="entry-date"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_permalink() ),
			$time_string
		);

	?>

	<?php if ( ( comments_open() || get_comments_number() ) ) : ?>
			<span class="comments-link">
				<?php comments_popup_link( esc_html__( 'Leave a comment', 'eveny' ), esc_html__( '1 Comment', 'eveny' ), esc_html__( '% Comments', 'eveny' )); ?>
			</span>
	<?php endif; ?>

	<?php if ( is_search() ) : ?>
		<?php
			printf( '<li>&nbsp;%1$s&nbsp;%2$s</li>',
				esc_html( __( 'Type:', 'eveny' ) ),
				ucfirst( str_replace( '-', ' ', get_post_type() ) )
			);
		?>
	<?php endif; ?>

	<?php edit_post_link( __( 'Edit', 'eveny' ), '<span class="edit-link">', '</span>' ); ?>
</div>

<?php
}

endif;

/**
 * Get Tickets and Directions for Events
 *
 * Generates Buy Tickets and Get direction buttons with all functionality
 *
 * @since Eveny 1.0
 */
function eveny_tickets_directions() { ?>

	<?php

		$disable_directions = esc_attr( get_post_meta( get_the_ID(), 'eveny_event_directions', true ) );
		$disable_tickets    = esc_attr( get_post_meta( get_the_ID(), 'eveny_event_buytickets', true ) );
		$event_place        = get_post_meta( get_the_ID(), 'eveny_event_location', true );
		$event_tickets      = get_post_meta( get_the_ID(), 'eveny_buy_tickets_link', true );
        $event_url          = get_post_permalink();

	?>

	<div class="tickets-directions">
		<div class="buttons">

			<?php if ( ! $disable_tickets ) { ?>
					<!-- BUY TICKETS -->
					<?php
						if ( ! empty( $event_tickets ) ) :
							printf( '<a class="buy-tickets" target="_blank" href="%s">%s</a>', esc_html( $event_tickets ), esc_html__( 'Buy tickets', 'eveny' ) );
						endif;
					?>
			<?php } else { ?>
					<?php printf( '<span class="sold-out banner">%s</span>', esc_html__( 'Sold out!', 'eveny' ) ); ?>
			<?php } ?>

			<?php if ( ! $disable_directions ) { ?>
					<!-- GET DIRECTIONS -->
					<?php if ( ! empty( $event_place ) ) : ?>
							<a href="#" class="get-directions" data-event-id="<?php the_ID(); ?>">
								<?php esc_html_e( 'Get directions', 'eveny' ); ?>
							</a>
					<?php endif; ?>
			<?php } ?>

                    <!-- INFO -->
					<?php 
						if ( ! empty( $event_tickets ) ) :
							printf( '<a class="buy-tickets" id="info" target="_blank" href="%s">%s</a>', esc_html( $event_url ), esc_html__( 'Info', 'eveny' ) );
						endif;
					?>
			<?php ?>
            
		</div><!-- .buttons -->
		<div class="directions-form" id="directions-form-<?php the_ID(); ?>">
			<form action="http://maps.google.com/maps" method="get" target="_blank">
			   <input type="text" name="saddr" class="location-input" placeholder="<?php esc_attr_e( 'Enter your location ( eg. Your Street, Your Country )', 'eveny' ); ?>" />
			   <input type="hidden" name="daddr" value="<?php echo esc_attr( $event_place ); ?>" />
			   <input type="submit" value="<?php esc_attr_e( 'Go', 'eveny' ); ?>" />
			</form>
		</div><!-- .directions-form -->

	</div><!-- .tickets-directions -->

<?php

}
