<?php
/**
 * Custom Heder display
 *
 * @package Eveny
 */

$header_title      = get_theme_mod( 'custom_header_title' );
$header_text       = get_theme_mod( 'custom_header_text' );
$header_button     = get_theme_mod( 'custom_header_button_text' );
$header_button_url = get_theme_mod( 'custom_header_button_link' );

?>

<div class="custom-header verticalize-container">
	<img src="<?php header_image(); ?>" alt="">
	<div class="verticalize">
		<div class="container">
			<article id="header-content-box">
				<?php echo '<h1>' . esc_html( $header_title ) . '</h1>'; ?>
				<p>
					<?php echo esc_html( $header_text ); ?>
				</p>
				<a class="button" href="<?php echo esc_url( $header_button_url ); ?>">
					<?php echo esc_html( $header_button ); ?>
				</a>
			</article>
		</div>
	</div>
</div><!-- .custom-header -->
