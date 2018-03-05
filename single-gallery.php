<?php
/**
 * Displays Album post type single
 *
 * @package  Eveny
 */

get_header();

// Get Gallery Archive Template Page Name
$page_name = Galerie
//eveny_get_page_archive_name( 'gallery' );

?>

<div class="container">
	<div class="row">

		<header class="page-header col-lg-2">
			<?php printf( '<h1 class="page-title">%s</h1>', $page_name ); ?>
			<?php eveny_post_nav(); ?>
		</header><!-- .page-header -->

		<div id="primary" class="content-area col-lg-10">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( '/templates/contents/content', 'gallery' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
