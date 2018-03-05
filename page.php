<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Eveny
 */

get_header();

$header_class  = 'col-lg-2';
$content_class = 'col-lg-10';

if ( is_active_sidebar( 'sidebar-1' ) ) {
	$header_class  = 'col-lg-9 col-md-8';
	$content_class = 'col-lg-9 col-md-8';
}

?>

<div class="container">
	<div class="row">

		<header class="entry-header <?php echo esc_attr( $header_class ); ?>">
			<?php printf( '<h1 class="entry-title">%s</h1>', esc_html( get_the_title() ) ); ?>
		</header><!-- .entry-header -->

		<?php get_sidebar(); ?>

		<div id="primary" class="content-area <?php echo esc_attr( $content_class ); ?>">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( '/templates/contents/content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php eveny_paging_nav(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
