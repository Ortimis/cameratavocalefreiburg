<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Eveny
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="featured-image">
			<?php the_post_thumbnail(); ?>
		</figure>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'eveny' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
