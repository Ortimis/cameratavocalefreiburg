<?php
/**
 * Displays video post content
 *
 * @package Eveny
 */

$video       = get_post_meta( get_the_ID(), 'eveny_video_link', true );
$content     = esc_html( get_the_content() );
$empty_class = '';

if ( ! is_single() && trim( $content ) == '' ) {
	$empty_class = 'empty';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! empty( $video ) ) : ?>

			<figure class="featured-image scalable-wrapper">

				<div class="scalable-element">
					<?php if ( wp_oembed_get( $video ) ) : ?>
						<?php echo wp_oembed_get( $video ); ?>
					<?php else : ?>
						<?php echo $video; ?>
					<?php endif; ?>
				</div>

			</figure>

	<?php else : ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="featured-image">
					<?php if ( is_single() ) : ?>
							<?php the_post_thumbnail(); ?>
					<?php else : ?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					<?php endif; ?>
				</figure>
			<?php endif; ?>

	<?php endif; ?>

	<header class="entry-header">
		<?php if ( is_single() ) : ?>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php else : ?>
				<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		<?php endif; ?>

		<?php eveny_post_meta(); ?>
	</header><!-- .entry-header -->

	<div class="entry-content <?php echo esc_attr( $empty_class ); ?>">
		<?php
			the_content( sprintf(
				__( 'Continue reading %s', 'eveny' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'eveny' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?>

		<footer class="entry-footer">
			<?php eveny_entry_footer(); ?>
		</footer><!-- .entry-footer -->

	<?php endif; ?>

</article><!-- #post-## -->