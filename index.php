<?php
/**
 * The main template file.
 *
 * @package Eveny
 */

get_header();

// Set column width depending on sidebar activation
$columns              = 'col-lg-10';
$grid                 = '';
$archive_layout       = esc_attr( get_theme_mod( 'blog_archive_layout', 'default' ) );
$blog_archive_title   = esc_attr( get_option( 'page_for_posts', true ) );

if ( $blog_archive_title ) {
	$blog_archive_heading = get_the_title( $blog_archive_title );
} else {
	$blog_archive_heading = esc_html__( 'Blog Archives', 'eveny' );
}

if ( is_active_sidebar( 'sidebar-1' ) ) {
	$columns = 'col-lg-7 col-md-8';
}

if ( 'grid' == $archive_layout ) {
	$grid = $archive_layout;
}

?>

<div class="container">
	<div class="row">

		<header class="page-header col-lg-2">
			<h1 class="page-title"><?php echo esc_html( $blog_archive_heading ); ?></h1>
		</header><!-- .page-header -->

		<div id="primary" class="content-area <?php echo esc_attr( $grid ); ?> <?php echo esc_attr( $columns ); ?>">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

					<div class="row">

						<?php if ( 'grid' == $grid ) { ?><div class="grid-wrapper"><?php } ?>

							<?php while ( have_posts() ) : the_post(); ?>

								<?php get_template_part( '/templates/contents/content', get_post_format() ); ?>

							<?php endwhile; ?>

						<?php if ( 'grid' == $grid ) { ?></div><!-- .grid-wrapper --><?php } ?>

					</div><!-- .row -->

					<?php eveny_page_numbers_pagination(); ?>

			<?php else : ?>

					<?php get_template_part( '/templates/contents/content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
