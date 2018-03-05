<?php
/**
 * Displays Album post type single
 *
 * @package  Eveny
 */

get_header();

$columns = 'col-lg-12';

if ( is_active_sidebar( 'sidebar-1' ) ) {
	$columns = 'col-lg-9 col-md-8';
}

// Get Gallery Archive Template Page Name
$page_name = eveny_get_page_archive_name( 'events' );

?>

<div class="container">
	<div class="row">

		<div id="primary" class="content-area <?php echo esc_attr( $columns ); ?>">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( '/templates/contents/content', 'event' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
