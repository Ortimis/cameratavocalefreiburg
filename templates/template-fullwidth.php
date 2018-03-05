<?php
/**
 * Template Name: Fullwidth Page
 *
 * @package  Eveny
 */

get_header();

$header_class  = 'col-lg-2';
$content_class = 'col-lg-10';

?>

<div class="container">
	<div class="row">

		<header class="entry-header <?php echo esc_attr( $header_class ); ?>">
			<?php printf( '<h1 class="entry-title">%s</h1>', esc_html( get_the_title() ) ); ?>
		</header><!-- .entry-header -->

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

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
