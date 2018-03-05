<?php
/**
 * Displays album content
 *
 * @package Eveny
 */

$album_template = false;
$columns        = 'clear';

if ( is_page_template( 'templates/template-albums.php' ) ) {
	$album_template = true;
	$columns        = array( 'col-lg-4', 'col-sm-6', 'clear' );
}

// Set No image if thumbnail doesn't exist
if ( has_post_thumbnail() ) {
	if ( is_single() ) {
		$album_image = get_the_post_thumbnail( get_the_ID(), 'album-thumb' );
	} else {
		$album_image = get_the_post_thumbnail( get_the_ID(), 'album-thumb' );
	}
}
else {
	$album_image = '<img src="' . get_template_directory_uri() . '/theme-images/no-image.jpg">';
}

$content     = esc_html( get_the_content() );
$empty_class = '';

if ( ! is_single() && trim( $content ) == '' ) {
    $empty_class = 'empty';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $columns ); ?>>

	<figure class="featured-image">

		<?php if ( ! is_single() ) : ?>

			<a href="<?php the_permalink(); ?>">
				<?php echo $album_image; ?>
				<h1 class="entry-title">
					<?php the_title(); ?>
					<?php echo '<span class="album-info">' . esc_html( get_post_meta( get_the_ID(), 'eveny_album_info', true ) ) . '</span>'; ?>
				</h1>
			</a>

		<?php else : ?>

			<?php echo $album_image; ?>

		<?php endif; ?>

	</figure>

	<?php if ( ! $album_template ) : ?>

		<div class="entry-content <?php echo esc_attr( $empty_class ); ?>">

			<?php if ( is_single() ) : ?>

				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</h1>

			<?php endif; ?>

			<?php the_content(); ?>

		</div><!-- .entry-content -->

	<?php endif; ?>

</article><!-- #post-## -->
