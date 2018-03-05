<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Eveny
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="sidebar" class="widget-area col-lg-3 col-md-4" role="complementary">

	<div class="sidebar__box">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>

</div><!-- #sidebar -->
