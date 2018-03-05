<?php
/**
 * The template for displaying all single posts.
 *
 * @package Eveny
 */

get_header();

$content_class = 'col-lg-10';
$posts_page    = esc_attr( get_option( 'page_for_posts', true ) );
$archive_title = esc_html__( 'Blog Archives', 'eveny' );

if ( $posts_page ) {
	$archive_title = esc_attr( get_the_title( $posts_page ) );
}

if ( is_active_sidebar( 'sidebar-1' ) ) {
	$content_class = 'col-lg-7 col-md-8';
}

?>

<div class="container">
	<div class="row">

		<header class="page-header col-lg-2">
			<h1 class="page-title"><?php echo esc_html( $archive_title ); ?></h1>
			<?php eveny_post_nav(); ?>
		</header><!-- .page-header -->

		<div id="primary" class="content-area <?php echo esc_attr( $content_class ); ?>">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( '/templates/contents/content', get_post_format() ); ?>

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
