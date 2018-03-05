<?php
/**
 * Displays Album post type single
 *
 * @package  Eveny
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
			<?php printf( '<h1 class="entry-title">%s<span class="album-info">%s</span></h1>', esc_html( get_the_title() ), get_post_meta( get_the_ID(), 'eveny_album_info', true ) ); ?>
			<?php eveny_post_nav(); ?>
		</header><!-- .entry-header -->

		<?php get_sidebar(); ?>

		<div id="primary" class="content-area <?php echo esc_attr( $content_class ); ?>">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>
<!-- <div id="pricetag">
	<span>
	<a class=button href="<?php the_field('cd_buy'); ?>">KAUFEN</a>
	<p class="button"><?php the_field('Preis'); ?></p></span>
</div> -->
					<?php get_template_part( '/templates/contents/content', 'album' ); ?>

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