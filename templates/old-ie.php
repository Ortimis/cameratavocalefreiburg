<?php
/**
 * Template For Old IE
 *
 * @package  Eveny
 */

?>

<div class="ie-page verticalize-container">
	<div class="verticalize">
		<h1><?php _e( 'YOUR BROWSER IS OUTDATED', 'eveny' ); ?>
		<span><?php _e( 'For a better experience, keep your browser up to date.', 'eveny' ); ?></span></h1>
		<a href="http://outdatedbrowser.com/en" class="update-browser"><?php _e( 'Download Latest Versions', 'eveny' ); ?></a>
		<img src="<?php echo get_template_directory_uri();?>/theme-images/browser-icons.png" alt="">
	</div>
</div>
